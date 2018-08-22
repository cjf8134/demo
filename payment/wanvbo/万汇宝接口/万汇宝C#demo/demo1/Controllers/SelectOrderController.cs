using demo1.Models;
using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
    /**
	 * 提交支付订单查询
	 */
namespace demo1.Controllers
{
    public class SelectOrderController : Controller
    {
        public IActionResult SelectOrder()
        {
            return View();
        }

        public IActionResult SelectOrderSubmit(string mer_no,string mer_order_no)
        {
            Dictionary<string, string> dic = new Dictionary<string, string>();
            dic.Add("mer_no", mer_no);
            dic.Add("mer_order_no", mer_order_no);
            string sign = getSign(dic);
            dic.Add("sign", sign);
            dic.Add("sign_type", ConstantUtil.SIGN_TYPE);
            string result = HttpClientUtil.Post(ConstantUtil.SELECT_Order_URL, dic);
            var obj= JsonConvert.DeserializeObject<dynamic>(result);
            string ret_sign_type = obj.sign_type;
            string ret_sign = obj.sign;
            string ret_mer_no = obj.mer_no;
            string ret_auth_result = obj.auth_result;
            string ret_error_msg = obj.error_msg;
            string trade_amount = obj.trade_amount;
            string trade_result = obj.trade_result;
            string m_order_no = obj.mer_order_no;
            string order_no = obj.order_no;
            string pay_date = obj.pay_date;

            Dictionary<string, string> dic1 = new Dictionary<string, string>();
            SignUtil.putIfNotNull(dic1, "mer_no", ret_mer_no);
            SignUtil.putIfNotNull(dic1, "auth_result", ret_auth_result);
            SignUtil.putIfNotNull(dic1, "error_msg", ret_error_msg);
            SignUtil.putIfNotNull(dic1, "trade_amount", trade_amount);
            SignUtil.putIfNotNull(dic1, "trade_result", trade_result);
            SignUtil.putIfNotNull(dic1, "mer_order_no", m_order_no);
            SignUtil.putIfNotNull(dic1, "order_no", order_no);
            SignUtil.putIfNotNull(dic1, "pay_date", pay_date);

            string retSignStr = SignUtil.sortData(dic1);
            string retSign = MD5.Md5Hash(retSignStr, ConstantUtil.PAY_KEY);
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

        private string getSign(Dictionary<string, string> dic)
        {
            string signStr = SignUtil.sortData(dic);
            string result = MD5.Md5Hash(signStr, ConstantUtil.PAY_KEY);
            return result;
        }
    }
}
