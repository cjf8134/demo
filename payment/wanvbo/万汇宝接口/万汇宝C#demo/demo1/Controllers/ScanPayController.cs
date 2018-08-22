﻿using demo1.Models;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
/**
 * 扫描订单支付
 */
namespace demo1.Controllers
{
    public class ScanPayController : Controller
    {
        public IActionResult ScanPay()
        {
            return View();
        }

        public IActionResult ScanPaySubmit(string mer_no,string mer_order_no, string trade_amount, string service_type)
        {
            Dictionary<string, string> dic = new Dictionary<string, string>();
            dic.Add("mer_no", mer_no);
            dic.Add("mer_order_no", mer_order_no);
            dic.Add("trade_amount", trade_amount);
            dic.Add("service_type", service_type);
            dic.Add("order_date", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss"));
            dic.Add("page_url", ConstantUtil.PAY_PAGE_CALLBAKE_URL);
            dic.Add("back_url", ConstantUtil.PAY_BACK_CALLBAKE_URL);
            String signStr = SignUtil.sortData(dic);
            String sign = MD5.Md5Hash(signStr, ConstantUtil.PAY_KEY);
            dic.Add("sign_type", "MD5");
            dic.Add("sign", sign);
            var model = new PaySubmit();
            model.url = ConstantUtil.SCAN_PAY_URL;
            model.dic = dic;
            return View(model);

        }
    }
}
