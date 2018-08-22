using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
/**
 * 代付请求
 *
 */
namespace demo1.Controllers
{
    public class RemitRequestController : Controller
    {
        public IActionResult RemitRequest()
        {
            return View();
        }

        public IActionResult RemitRequestSubmit(string mer_no, string mer_remit_no, string apply_date, string bank_code, string province, string city, string card,string name,string amount,string remark)
        {
            string card_and_name_str = card + "|" + name;
            string card_and_name = AesUtil.AESEncrypt(card_and_name_str,ConstantUtil.REMIT_KEY);
            string sign_type = ConstantUtil.SIGN_TYPE;

            Dictionary<string, string> dic = new Dictionary<string, string>();
            dic.Add("card_and_name", card_and_name);
            dic.Add("mer_no", mer_no);
            dic.Add("mer_remit_no", mer_remit_no);
            dic.Add("apply_date", apply_date);
            dic.Add("bank_code", bank_code);
            dic.Add("province", province);
            dic.Add("city", city);
            dic.Add("amount", amount);
            dic.Add("remark", remark);
            String signStr = SignUtil.sortData(dic);
            String sign = MD5.Md5Hash(signStr, ConstantUtil.REMIT_KEY);
            dic.Add("sign_type", sign_type);
            dic.Add("sign", sign);
            dic["card_and_name"]=System.Web.HttpUtility.UrlEncode(card_and_name);
            String result = HttpClientUtil.Post(ConstantUtil.REMIT_URL, dic);
            var obj = JsonConvert.DeserializeObject<dynamic>(result);
            string ret_sign_type = obj.sign_type;
            string ret_sign = obj.sign;
            string ret_mer_no = obj.mer_no;
            string ret_auth_result = obj.auth_result;
            string ret_error_msg = obj.error_msg;
            string ret_mer_remit_no = obj.ret_mer_remit_no;
            string ret_trade_result = obj.ret_trade_result;
            string ret_amount = obj.amount;
            string ret_apply_date = obj.apply_date;

            Dictionary<string, string> dic1 = new Dictionary<string, string>();
            SignUtil.putIfNotNull(dic1, "mer_no", ret_mer_no);
            SignUtil.putIfNotNull(dic1, "auth_result", ret_auth_result);
            SignUtil.putIfNotNull(dic1, "error_msg", ret_error_msg);
            SignUtil.putIfNotNull(dic1, "ret_mer_remit_no", ret_mer_remit_no);
            SignUtil.putIfNotNull(dic1, "ret_trade_result", ret_trade_result);
            SignUtil.putIfNotNull(dic1, "ret_amount", ret_amount);
            SignUtil.putIfNotNull(dic1, "apply_date", ret_apply_date);

            string retSignStr = SignUtil.sortData(dic1);
            string retSign = MD5.Md5Hash(retSignStr, ConstantUtil.REMIT_KEY);
            if (!ConstantUtil.SIGN_TYPE.Equals(ret_sign_type) || !retSign.Equals(ret_sign))
            {
                Console.WriteLine("签名验证失败");
            }
            else
            {
                Console.WriteLine("签名验证成功");
            }   


            return View((object)result);

        }
    }
}
