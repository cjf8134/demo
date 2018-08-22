using System;    
using System.Collections.Generic;    
using System.Text;    
using System.Security.Cryptography;    
using System.IO;   

namespace demo1
{
    public class AesUtil
    {
       
        public static string AESEncrypt(string cn, string Key)
        {
            byte[] keyArray = UTF8Encoding.UTF8.GetBytes(Key);

            byte[] toEncryptArray = UTF8Encoding.UTF8.GetBytes(cn);
                

            RijndaelManaged rDel = new RijndaelManaged();

            rDel.Key = keyArray;

            rDel.Mode = CipherMode.ECB;

            rDel.Padding = PaddingMode.PKCS7;


            ICryptoTransform cTransform = rDel.CreateEncryptor();

            byte[] resultArray = cTransform.TransformFinalBlock(toEncryptArray, 0, toEncryptArray.Length);

            return parseByte2HexStr(resultArray);
           // return Convert.ToBase64String(resultArray, 0, resultArray.Length).ToUpper();
        }

        public static string parseByte2HexStr(byte[] buf)
        {
            StringBuilder sb = new StringBuilder();
            for (int i = 0; i < buf.Length; ++i)
            {
                String hex = String.Format("{0:X}", buf[i]);
                if (hex.Length == 1)
                {
                    hex = '0' + hex;
                }
                sb.Append(hex.ToUpper());
            }
           
            return sb.ToString();
        }


    }
    }
