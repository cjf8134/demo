using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Collections.Specialized;
using System.Text;
using System.Collections;
using Paycenter_sdk.lib;
using Paycenter_sdk.service;

namespace Paycenter_sdk
{
    public partial class PayResponse : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            Log.Info(this.GetType().ToString(), "===========支付请求同步通知============");
            PaycenterService ps = new PaycenterService();
            PayCenterData data = ps.acceptResponse(Page);
            if ("1".Equals(data.GetValue("pay_result")))
            {
                Label1.Text = "支付成功";
                //支付成功业务处理

                //支付成功业务处理
            }
            else
            {
                //支付失败业务处理

                //支付失败业务处理
                Label1.Text = "支付失败";
            }
        }
    }
}