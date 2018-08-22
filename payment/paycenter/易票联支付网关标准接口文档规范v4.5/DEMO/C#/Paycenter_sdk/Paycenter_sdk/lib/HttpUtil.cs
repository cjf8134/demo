using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Net;
using System.Text;
using System.IO;
using System.Net.Security;
using System.Security.Cryptography.X509Certificates;

namespace Paycenter_sdk.lib
{
    public class HttpUtil
    {

        public static string HttpPost(string Url, string postDataStr)
        {
            System.GC.Collect();//垃圾回收，回收没有正常关闭的http连接
            string result = "";//返回结果
            HttpWebRequest request= null;
            HttpWebResponse response = null;
            Stream reqStream = null;
            try
            {
                //System.Net.ServicePointManager.SecurityProtocol = SecurityProtocolType.Ssl3;
                //request = (HttpWebRequest)WebRequest.Create(Url);
                if(Url.StartsWith("https",StringComparison.OrdinalIgnoreCase))  
                {  
                    ServicePointManager.ServerCertificateValidationCallback = new RemoteCertificateValidationCallback(CheckValidationResult);  
                    request = WebRequest.Create(Url) as HttpWebRequest;  
                    request.ProtocolVersion=HttpVersion.Version10;  
                }  
                else 
                {  
                    request = WebRequest.Create(Url) as HttpWebRequest;  
                }  
                request.Method = "POST";
                request.ContentType = "application/x-www-form-urlencoded";
                request.ContentLength = Encoding.UTF8.GetByteCount(postDataStr);
               
                byte[] data = System.Text.Encoding.UTF8.GetBytes(postDataStr);
                reqStream = request.GetRequestStream();
                reqStream.Write(data, 0, data.Length);
                reqStream.Close();
                

                response = (HttpWebResponse)request.GetResponse();
                Stream myResponseStream = response.GetResponseStream();
                StreamReader myStreamReader = new StreamReader(myResponseStream, Encoding.GetEncoding("GBK"));
                result = myStreamReader.ReadToEnd();
                myStreamReader.Close();
                myResponseStream.Close();
            }
            catch (System.Threading.ThreadAbortException e)
            {
                Log.Error("HttpUtil", "Thread - caught ThreadAbortException - resetting.");
                Log.Error("Exception message: {0}", e.Message);
                System.Threading.Thread.ResetAbort();
            }
            catch (WebException e)
            {
                Log.Error("HttpUtil", e.ToString());
                if (e.Status == WebExceptionStatus.ProtocolError)
                {
                    Log.Error("HttpUtil", "StatusCode : " + ((HttpWebResponse)e.Response).StatusCode);
                    Log.Error("HttpUtil", "StatusDescription : " + ((HttpWebResponse)e.Response).StatusDescription);
                }
                throw new PayCenterException(e.ToString());
            }
            catch (Exception e)
            {
                Log.Error("HttpUtil", e.ToString());
                throw new PayCenterException(e.ToString());
            }
            finally
            {
                //关闭连接和流
                if (response != null)
                {
                    response.Close();
                }
                if (request != null)
                {
                    request.Abort();
                }
            }
            return result;
        }

        private static bool CheckValidationResult(object sender, X509Certificate certificate, X509Chain chain, SslPolicyErrors errors)  
        {  
            return true; //总是接受  
        }  

    }
}