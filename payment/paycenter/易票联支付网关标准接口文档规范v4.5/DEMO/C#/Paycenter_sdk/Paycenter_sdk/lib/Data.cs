using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Xml;
using System.Text;
using System.Security.Cryptography;
using System.Security.Cryptography.X509Certificates;
using System.Globalization;
using Org.BouncyCastle.Math;
using Org.BouncyCastle.Asn1;
using Org.BouncyCastle.Asn1.Pkcs;
using Org.BouncyCastle.X509;
using Org.BouncyCastle.Security;

namespace Paycenter_sdk.lib
{
    public class PayCenterData
    {
        public PayCenterData() 
        {
            this.SetValue("sign_type",Resource.SIGN_TYPE.ToString());
        }

        //采用排序的Dictionary的好处是方便对数据包进行签名，不用再签名之前再做一次排序
        private SortedDictionary<string, object> m_values = new SortedDictionary<string, object>();

        /**
        * 设置某个字段的值
        * @param key 字段名
         * @param value 字段值
        */
        public void SetValue(string key, object value)
        {
            m_values[key] = value;
        }

        /**
        * 根据字段名获取某个字段的值
        * @param key 字段名
         * @return key对应的字段值
        */
        public object GetValue(string key)
        {
            object o = null;
            m_values.TryGetValue(key, out o);
            return o;
        }

        /**
         * 判断某个字段是否已设置
         * @param key 字段名
         * @return 若字段key已被设置，则返回true，否则返回false
         */
        public bool IsSet(string key)
        {
            object o = null;
            m_values.TryGetValue(key, out o);
            if (null != o)
                return true;
            else
                return false;
        }

        /**
        * @将xml转为PayCenterData对象并返回对象内部的数据
        * @param string 待转换的xml串
        * @return 经转换得到的Dictionary
        * @throws PayCenterException
        */
        public SortedDictionary<string, object> FromXml(string xml)
        {
            if (string.IsNullOrEmpty(xml))
            {
                Log.Error(this.GetType().ToString(), "将空的xml串转换为PayCenterData不合法!");
                throw new PayCenterException("将空的xml串转换为PayCenterData不合法!");
            }

            XmlDocument xmlDoc = new XmlDocument();
            xmlDoc.LoadXml(xml);
            XmlNode xmlNode = xmlDoc.GetElementsByTagName("root")[0];//xmlDoc.FirstChild;//获取到根节点<xml>
            XmlNodeList nodes = xmlNode.ChildNodes;
            foreach (XmlNode xn in nodes)
            {
                XmlElement xe = (XmlElement)xn;
                m_values[xe.Name] = xe.InnerXml;//获取xml的键值对到PayCenterData内部的数据中\
                Log.Info("PayCenterData", xe.Name + ":" + xe.InnerXml);
            }

            try
            {
                //2015-06-29 错误是没有签名的
                if (!"00".Equals(m_values["resp_code"]))
                {
                    return m_values;
                }
                CheckSign();//验证签名,不通过会抛异常
            }
            catch (PayCenterException ex)
            {
                throw new PayCenterException(ex.Message);
            }

            return m_values;
        }

        /**
        * @Dictionary格式转化成url参数格式
        * @ return url格式串, 该串不包含sign字段值
        */
        public string ToUrl()
        {
            string buff = "";
            foreach (KeyValuePair<string, object> pair in m_values)
            {
                if (pair.Value == null)
                {
                    Log.Error(this.GetType().ToString(), "PayCenterData内部含有值为null的字段!");
                    throw new PayCenterException("PayCenterData内部含有值为null的字段!");
                }
                
                if (pair.Key != "sign" && pair.Value.ToString() != "")
                {
                    buff += pair.Key + "=" + pair.Value.ToString() + "&";
                }
            }
            buff = buff.Trim('&');
            return buff;
        }

        public string ToRequestUrl()
        {
            string buff = "";
            foreach (KeyValuePair<string, object> pair in m_values)
            {
                if (pair.Value == null)
                {
                    Log.Error(this.GetType().ToString(), "PayCenterData内部含有值为null的字段!");
                    throw new PayCenterException("PayCenterData内部含有值为null的字段!");
                }
                    buff += pair.Key + "=" + HttpUtility.UrlEncode(pair.Value.ToString(), Encoding.GetEncoding("GBK")) + "&";
            }
            buff = buff.Trim('&');
            return buff;
        }

        /**
        * @生成签名，详见签名生成算法
        * @return 签名, sign字段不参加签名
        */
        public string MakeSign()
        {
            X509Certificate2 c3 = SafeUtil.GetCertificateFromPfxFile(System.AppDomain.CurrentDomain.BaseDirectory+Resource.PFX_PATH, Resource.PRIVATEKEY_PASSWORD);
            
            string keyPublic3 = c3.PublicKey.Key.ToXmlString(false);  // 公钥
            string keyPrivate3 = c3.PrivateKey.ToXmlString(true);  // 私钥
            PrivateKeyInfo info = SafeUtil.getJavaPrivateKeyFromXml(keyPrivate3);
            
            //BigInteger certId = new BigInteger(1, c3.GetSerialNumber());
            Org.BouncyCastle.X509.X509Certificate certificate = DotNetUtilities.FromX509Certificate(c3);
            
            //Asn1Sequence asq = (Asn1Sequence)Asn1Object.FromByteArray(info.ParsePrivateKey().GetDerEncoded());
            String certId = certificate.SerialNumber.ToString();
            this.SetValue("certId", certId.ToString());

            //转url格式
            string str = ToUrl();
            //在string后加入API KEY
            //str += "&key=" + Resource.KEY;
            //SHA256加密
            //var sb = SHA256Encrypt(str);
            Log.Info(this.GetType().ToString(), "计算签名串：" + str);
            str = SafeUtil.HashAndSign(str, keyPrivate3);
            Log.Info(this.GetType().ToString(), "签名：" + str);
            //所有字符转为小写
            return str.ToString();
        }

        /**
        * 
        * 检测签名是否正确
        * 正确返回true，错误抛异常
        */
        public bool CheckSign()
        {
            X509Certificate2 c3 = SafeUtil.GetCertFromCerFile(System.AppDomain.CurrentDomain.BaseDirectory + Resource.CER_PATH);
            String pukey = c3.PublicKey.Key.ToXmlString(false);

            //如果没有设置签名，则跳过检测
            if (!IsSet("sign"))
            {
                Log.Error(this.GetType().ToString(), "PayCenterData签名不存在!");
                throw new PayCenterException("PayCenterData签名不存在!");
            }
            //如果设置了签名但是签名为空，则抛异常
            else if (GetValue("sign") == null || GetValue("sign").ToString() == "")
            {
                Log.Error(this.GetType().ToString(), "PayCenterData签名存在但不合法!");
                throw new PayCenterException("PayCenterData签名存在但不合法!");
            }

            //获取接收到的签名
            string return_sign = GetValue("sign").ToString();

            string str = ToUrl();
            if (SafeUtil.VerifySignedHash(str, return_sign, pukey))
            {
                return true;
            }

            Log.Error(this.GetType().ToString(), "PayCenterData签名验证错误!");
            throw new PayCenterException("PayCenterData签名验证错误!");
        }

        /**
        * @获取Dictionary
        */
        public SortedDictionary<string, object> GetValues()
        {
            return m_values;
        }


        /**
         * SHA256加密
         */
        public string SHA256Encrypt(string str)
        {
            System.Security.Cryptography.SHA256 s256 = new System.Security.Cryptography.SHA256Managed();
            var bs = s256.ComputeHash(Encoding.UTF8.GetBytes(str));
            s256.Clear();
            var sb = new StringBuilder();
            foreach (byte b in bs)
            {
                sb.Append(b.ToString("x2"));
            }
            return sb.ToString();
        }


        
    }
}