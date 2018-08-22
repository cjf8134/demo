using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Paycenter_sdk.service;
using Paycenter_sdk.lib;

namespace Paycenter_sdk
{
    public partial class Default : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void pay_test_Click(object sender, EventArgs e)
        {
            Response.Redirect("index.aspx");
        }

        protected void order_query_Click(object sender, EventArgs e)
        {
            //----参数--由接入者实际接入时填写---
            string outTradeNo = "1447208747438"; //设置商户交易流水号
            //----参数end
            PaycenterService ps = new PaycenterService();
            PayCenterData pd = ps.paycenterQueryOrder(outTradeNo);
            Log.Info(this.GetType().ToString(), "返回结果：" + pd.GetValue("resp_desc"));
        }

        protected void refund_request_Click(object sender, EventArgs e)
        {
            //----参数--由接入者实际接入时填写---
            string outTradeNo = "1447208747438"; //设置商户交易流水号
            string outRefundNo = "TK144720874743802";
            string totalAmount = "0.05";
            string refundAmount = "0.01";
            //----参数end
            PaycenterService ps = new PaycenterService();
            PayCenterData pd = ps.paycenterRefundRequest(outTradeNo,outRefundNo,totalAmount,refundAmount);
            Log.Info(this.GetType().ToString(), "返回结果：" + pd.GetValue("resp_desc"));
            Log.Info(this.GetType().ToString(), "易票联退款流水号：" + pd.GetValue("refund_id"));
        }

        protected void refund_query_Click(object sender, EventArgs e)
        {
            //----参数--由接入者实际接入时填写---
            string outTradeNo = "1447208747438"; //设置商户交易流水号
            string outRefundNo = "TK144720874743802";
            string refundId = "1988";
            //----参数end
            PaycenterService ps = new PaycenterService();
            PayCenterData pd = ps.paycenterRefundQuery(outTradeNo,refundId, outRefundNo);
            Log.Info(this.GetType().ToString(), "返回结果：" + pd.GetValue("resp_desc"));
        }
    }
}