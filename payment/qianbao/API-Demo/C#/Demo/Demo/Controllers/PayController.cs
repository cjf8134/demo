using Demo.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace Demo.Controllers
{

    /// <summary>
    /// CSE 支付 支持快速开户
    /// </summary>
    public class PayController : Controller
    {

        // GET: Pay
        /// <summary>
        /// 支付提交地址
        /// </summary>
        public const string submit_url = "https://csewallet.com/CSEPay/PayPage";

        [HttpGet]
        public ActionResult Index()
        {
            string orderId = DateTime.Now.Ticks + "";//订单编号
            ViewBag.orderId = orderId;

            return View();
        }


        [HttpPost]
        public ActionResult Index(string orderId, string orderInfo, string product_name, string product_code, 
            string user_name,
            string email,
            string id_card,
            string tel,
            decimal order_amount)
        {

            string code = "1685";//商户号 CSEPay  平台ID
            string interfaceVersion = "2.0.1";//接口版本号 固定值
            string orderTime = DateTime.Now.ToString("yyyyMMddHHmmss");//订单时间
            string input_charset = "UTF-8";
            string sign_type = "RSA-S";//加密方式 固定值

            string root = Request.Url.Scheme + "://" + Request.Url.Authority;
            string offline_notify = root + "/Pay/PayNotify";//支付成功后异步通知地址
            string page_notify = root + "/Pay/ReturnPage";//支付成功后同步通知地址


            Dictionary<string, string> dic = new Dictionary<string, string>();
            dic.Add("orderId", orderId);
            dic.Add("code", code);
            dic.Add("orderInfo", orderInfo);
            dic.Add("interfaceVersion", interfaceVersion);
            dic.Add("offline_notify", offline_notify);
            dic.Add("page_notify", page_notify);
            dic.Add("orderTime", orderTime);
            dic.Add("sign_type", sign_type);
            dic.Add("product_name", product_name);
            dic.Add("product_code", product_code);
            dic.Add("order_amount", order_amount + "");
            dic.Add("input_charset", input_charset);

            dic.Add("user_name", user_name);
            dic.Add("email", email);
            dic.Add("id_card", id_card);
            dic.Add("tel", tel);

            //商户私钥 注意不能包含空格
            string private_key = "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALq0mkjfAi8bEpP6MdvlwHPDXqajtKZBOV+SSyOuxxYMBEcLaiHZgCF+hUXD5Gl8aEISqkjEIJ8HxhCiVEeDZTU303shg6kmtOuRu9crx+jAPmSdJbpLsgdVKOKTWhbMsCczIIdkw10aYcoHyKw2QLvCUXB9KskV96CcHhQcnKvbAgMBAAECgYEAguEZil2yFT1gH5VyoBiFeWEKF7yIZUcxpdpSi/f4HW9dDERnKMVkOZaMbCRvGLcaCr802X+K8pArevugIuVr6tdy/2iSJ+9HDq6ZLD3QfG5WNdJilAZiLUh4lWrd0BAUH+T7bGAbjXRnGXFcd1hcOObX20GCn3Hzf2dwmWFhPYkCQQDxKzKfOYIQVzhIfahpXXTWlWkKZkMINYw9UNSMduZzuA94eCybrverNKB8NlL3zngOS8REIulDE2CdoHMFev7XAkEAxi/4mogovWzw4/i37Fre/3M1YKwjfSi65KJ6JR3Cp / kZ9 / f1ncFDujBBfLGn4dHARHnVbamUOdSIr5pOPwJunQJAZP2l8S9v28/qbdDRGW5dYw6mMgiowWNLGtIib7/KuWK2d8g7ReZ7KGKdYeaNz9/SPopT4gSMkd4nc1qhUAY1eQJABftIq5FUeXMiSh8lnfKYLGmTwNkxMQPbsC7fNOOTDnLMP9myBhLhMmtmbpcGFCC6htaOhILLwHsTrQkhN3GhWQJBAIcNQWgcSZxbqij1e0mVI60rWbfcGSxycqVJCOhzsariU2JkJ0PhV1Dlqh+y994KOj/FcRTa0UoQ+MuCOUJ7cjw=";

            string param = HttpHelp.AssemblySign(dic);
            //私钥转换成C#专用私钥
            private_key = HttpHelp.RSAPrivateKeyJava2DotNet(private_key);
            //签名
            string sign = HttpHelp.RSASign(param, private_key);

            dic.Add("sign", sign);

            string html = HttpHelp.GetRedirectHtml(submit_url, dic);

            return Content(html);
        }






        //支付成功前台回调
        public ActionResult ReturnPage(string orderId, string trade_status, string code,
            string orderInfo,
            string orderTime,
            string sign_type,
            string product_name,
            string product_code,
            string sign,
            string input_charset,
            decimal order_amount = 0)
        {


            ViewBag.trade_status = trade_status;

            return View();
        }

        //支付成功后台回调
        public ActionResult PayNotify(string orderId, string trade_status, string code,
            string orderInfo,
            string orderTime,
            string sign_type,
            string product_name,
            string product_code,
            string sign,
            string input_charset,
            decimal order_amount = 0)
        {
            Dictionary<string, string> dic = new Dictionary<string, string>();
            dic.Add("orderId", orderId);
            dic.Add("code", code);
            dic.Add("orderInfo", orderInfo);
            dic.Add("orderTime", orderTime);
            dic.Add("sign_type", sign_type);
            dic.Add("product_name", product_name);
            dic.Add("product_code", product_code);
            dic.Add("order_amount", order_amount + "");
            dic.Add("trade_status", trade_status);
            dic.Add("input_charset", input_charset);

            string str = HttpHelp.AssemblySign(dic);

            //csePay公钥
            string public_key = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC4aAGKkRv+JPnsg5N5taaeDl3Q+K0mEZWNBWI2BJ40F7pZgckobqmb4V09k2Zmbo1n0hqGCjoGhyrCtt0pvv60sjTcz+BtcQd+DKXJjjWSpbDTta1S0M4EQrPrhXm6P3gcHgAAVEP6Umw+4+B5OCJGOQpgPqpXXkUV0pFoIfeO8QIDAQAB";
            public_key = HttpHelp.RSAPublicKeyJava2DotNet(public_key);
            bool result = HttpHelp.ValidateRsaSign(str, public_key, sign);
            if (result)
            {
                if (!string.IsNullOrEmpty(trade_status) && trade_status == "SUCCESS")
                {
                    //支付成功
                    return Content("success");
                }
            }
            return Content("支付失败");
        }


    }
}