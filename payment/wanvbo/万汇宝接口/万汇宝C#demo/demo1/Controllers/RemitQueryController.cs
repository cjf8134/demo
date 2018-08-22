using demo1.Models;
using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
/**
 * 代付查询
 *
 */
namespace demo1.Controllers
{
    public class RemitQueryController : Controller
    {
        public IActionResult RemitQuery()
        {
            return View();
        }

        public IActionResult RemitQuerySubmit(string mer_no,string mer_remit_no,string apply_date)
        {
            Dictionary<string, string> dic = new Dictionary<string, string>();
            dic.Add("mer_no", mer_no);
            dic.Add("mer_remit_no", mer_remit_no);
            dic.Add("apply_date", apply_date);
            String signStr = SignUtil.sortData(dic);
            String sign = MD5.Md5Hash(signStr, ConstantUtil.REMIT_KEY);
            dic.Add("sign", sign);
            dic.Add("sign_type", ConstantUtil.SIGN_TYPE);
            string result = HttpClientUtil.Post(ConstantUtil.REMIT_QUERY_URL, dic);
            var obj= JsonConvert.DeserializeObject<dynamic>(result);
            string ret_sign_type = obj.sign_type;
            string ret_sign = obj.sign;
            string ret_mer_no = obj.mer_no;
            string ret_auth_result = obj.auth_result;
            string ret_error_msg = obj.error_msg;
            string ret_mer_remit_no = obj.ret_mer_remit_no;
            string ret_trade_result = obj.ret_trade_result;
            string ret_amount = obj.ret_amount;
            string app_date = obj.apply_date;

            Dictionary<string, string> dic1 = new Dictionary<string, string>();
            SignUtil.putIfNotNull(dic1, "mer_no", ret_mer_no);
            SignUtil.putIfNotNull(dic1, "auth_result", ret_auth_result);
            SignUtil.putIfNotNull(dic1, "error_msg", ret_error_msg);
            SignUtil.putIfNotNull(dic1, "ret_mer_remit_no", ret_mer_remit_no);
            SignUtil.putIfNotNull(dic1, "ret_trade_result", ret_trade_result);
            SignUtil.putIfNotNull(dic1, "ret_amount", ret_amount);
            SignUtil.putIfNotNull(dic1, "apply_date", app_date);

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
