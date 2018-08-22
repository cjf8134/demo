using demo1.Models;
using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
/**
 * 余额查询
 *
 */
namespace demo1.Controllers
{
    public class BalanceQueryController : Controller
    {
        public IActionResult BalanceQuery()
        {
            return View();
        }

        public IActionResult BalanceQuerySubmit(string mer_no)
        {
            Dictionary<string, string> dic = new Dictionary<string, string>();
            dic.Add("mer_no", mer_no);
            string sign_type = ConstantUtil.SIGN_TYPE;
            String signStr = SignUtil.sortData(dic);
            String sign = MD5.Md5Hash(signStr, ConstantUtil.REMIT_KEY);
            dic.Add("sign", sign);
            dic.Add("sign_type", sign_type);
            string result = HttpClientUtil.Post(ConstantUtil.BALANCE_QUERY_URL, dic);
            var obj= JsonConvert.DeserializeObject<dynamic>(result);
            string ret_sign_type = obj.sign_type;
            string ret_sign = obj.sign;
            string ret_mer_no = obj.mer_no;
            string ret_auth_result = obj.auth_result;
            string ret_error_msg = obj.error_msg;
            string amount = obj.amount;
            string frozen_amount = obj.frozen_amount;
            string available_amount = obj.available_amount;
            string status = obj.status;
            string unsettle_amount = obj.unsettle_amount;

            Dictionary<string, string> dic1 = new Dictionary<string, string>();
            SignUtil.putIfNotNull(dic1, "mer_no", ret_mer_no);
            SignUtil.putIfNotNull(dic1, "auth_result", ret_auth_result);
            SignUtil.putIfNotNull(dic1, "error_msg", ret_error_msg);
            SignUtil.putIfNotNull(dic1, "amount", amount);
            SignUtil.putIfNotNull(dic1, "frozen_amount", frozen_amount);
            SignUtil.putIfNotNull(dic1, "available_amount", available_amount);
            SignUtil.putIfNotNull(dic1, "status", status);
            SignUtil.putIfNotNull(dic1, "unsettle_amount", unsettle_amount);

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
