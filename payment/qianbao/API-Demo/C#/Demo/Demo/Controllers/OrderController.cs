using Demo.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;
using System.Web.Mvc;

namespace Demo.Controllers
{
    public class OrderController : Controller
    {
        // GET: Order
        public ActionResult Index()
        {

            string timestamps = TimeUtils.GetTimeStamp(DateTime.UtcNow, 10);//时间戳 10 位
            return Content(timestamps);
        }

        /// <summary>
        /// 查询订单记录
        /// </summary>
        /// <param name="beginTime"></param>
        /// <param name="endTime"></param>
        /// <param name="pageIndex"></param>
        /// <param name="pageSize"></param>
        /// <returns></returns>
        public ActionResult GetOrderList(string beginTime,string endTime,int pageIndex=1,int pageSize=10)
        {
            string orderId = "";//订单编号
            string code = "1685";//商户号 CSEPay  平台ID
            string interfaceVersion = "2.0.1";//接口版本
            string input_charset = "UTF-8";
            string sign_type = "RSA-S";//加密方式 固定值

            string result_format = "JSON";//返回格式 （JSON/XML）

            string timestamps = TimeUtils.GetTimeStamp(DateTime.UtcNow,10);//时间戳 10 位


            Dictionary<string, string> dic = new Dictionary<string, string>();
            dic.Add("orderId", orderId);
            dic.Add("code", code);
            dic.Add("result_format", result_format);
            dic.Add("interfaceVersion", interfaceVersion);
            dic.Add("beginTime", beginTime);
            dic.Add("endTime", endTime);
            dic.Add("sign_type", sign_type);
            dic.Add("input_charset", input_charset);
            dic.Add("timestamps", timestamps);


            //商户私钥 注意不能包含空格
            string private_key = "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALq0mkjfAi8bEpP6MdvlwHPDXqajtKZBOV+SSyOuxxYMBEcLaiHZgCF+hUXD5Gl8aEISqkjEIJ8HxhCiVEeDZTU303shg6kmtOuRu9crx+jAPmSdJbpLsgdVKOKTWhbMsCczIIdkw10aYcoHyKw2QLvCUXB9KskV96CcHhQcnKvbAgMBAAECgYEAguEZil2yFT1gH5VyoBiFeWEKF7yIZUcxpdpSi/f4HW9dDERnKMVkOZaMbCRvGLcaCr802X+K8pArevugIuVr6tdy/2iSJ+9HDq6ZLD3QfG5WNdJilAZiLUh4lWrd0BAUH+T7bGAbjXRnGXFcd1hcOObX20GCn3Hzf2dwmWFhPYkCQQDxKzKfOYIQVzhIfahpXXTWlWkKZkMINYw9UNSMduZzuA94eCybrverNKB8NlL3zngOS8REIulDE2CdoHMFev7XAkEAxi/4mogovWzw4/i37Fre/3M1YKwjfSi65KJ6JR3Cp / kZ9 / f1ncFDujBBfLGn4dHARHnVbamUOdSIr5pOPwJunQJAZP2l8S9v28/qbdDRGW5dYw6mMgiowWNLGtIib7/KuWK2d8g7ReZ7KGKdYeaNz9/SPopT4gSMkd4nc1qhUAY1eQJABftIq5FUeXMiSh8lnfKYLGmTwNkxMQPbsC7fNOOTDnLMP9myBhLhMmtmbpcGFCC6htaOhILLwHsTrQkhN3GhWQJBAIcNQWgcSZxbqij1e0mVI60rWbfcGSxycqVJCOhzsariU2JkJ0PhV1Dlqh+y994KOj/FcRTa0UoQ+MuCOUJ7cjw=";

            /***
            pageIndex pageSize 不参与计算
            */

            string param = HttpHelp.AssemblySign(dic);

            //私钥转换成C#专用私钥
            private_key = HttpHelp.RSAPrivateKeyJava2DotNet(private_key);
            //签名
            string sign = HttpHelp.RSASign(param, private_key);
            string datas = HttpUtility.UrlEncode( sign);

            StringBuilder url = new StringBuilder("https://csewallet.com/csepay/GetOrderList?");
            url.Append(param);
            url.AppendFormat("&sign={0}", datas);
            url.AppendFormat("&pageIndex={0}", pageIndex);
            url.AppendFormat("&pageSize={0}", pageSize);
            return Redirect(url.ToString());
        }

        
    }
}