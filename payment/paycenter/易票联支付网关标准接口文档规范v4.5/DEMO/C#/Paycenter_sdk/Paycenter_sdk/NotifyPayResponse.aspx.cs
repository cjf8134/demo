using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Collections.Specialized;
using Paycenter_sdk.lib;
using System.Collections;
using System.Text;
using Paycenter_sdk.service;

namespace Paycenter_sdk
{
    public partial class NotifyPayResponse : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            Log.Info(this.GetType().ToString(), "===========支付请求异步通知============");
            //调用sdk得到异步通知参数
            PaycenterService ps = new PaycenterService();
            PayCenterData data = ps.acceptNotifyResponse(Page);

            if ("1".Equals(data.GetValue("pay_result")))
            {
                Log.Info(this.GetType().ToString(), "支付成功");
                //支付成功业务处理

                //支付成功业务处理
            }
            else
            {
                Log.Info(this.GetType().ToString(), "支付失败");
                //支付失败业务处理

                //支付失败业务处理
            }

        }

    }
}