using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Paycenter_sdk.lib;
using System.Text;
using Paycenter_sdk.service;

namespace Paycenter_sdk
{
    public partial class WebForm1 : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            System.Diagnostics.Debug.Write("进入支付请求发起页");
        }

        /// <summary>
        /// 订单支付
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        protected void pay_Click(object sender, EventArgs e)
        {
            Log.Info(this.GetType().ToString(), "============支付请求开始=========");
            //易票联网关支付地址
		    //1、获取商品信息参数-----------------------------
		    string currencyType = T_currencyType.Text;
            string totalFee = T_amount.Text;
            string remark = T_remark.Text;
		    //2、生成订单流水号-------------------------------
		    string outTradeNo = DateTime.Now.Ticks+"";
            System.Diagnostics.Debug.Write(outTradeNo);
			//3、实例化支付请求实体类，并设置需要的参数--------
            PayCenterData data = new PayCenterData();
            data.SetValue("partner", Resource.PARTNER);
            data.SetValue("out_trade_no",outTradeNo);
            data.SetValue("total_fee",totalFee);
            data.SetValue("currency_type",currencyType);
            data.SetValue("return_url", "http://172.20.16.194/Paycenter_sdk/PayResponse.aspx");
            data.SetValue("notify_url", "http://172.20.16.194/Paycenter_sdk/Paycenter_sdk/NotifyPayResponse.aspx");
            data.SetValue("submission_type","00");
            //中文要base64转码
            data.SetValue("base64_memo",Convert.ToBase64String(Encoding.Default.GetBytes(remark)));
            //data.SetValue("notify_url","zhaohang");//直连招商银行
            //4、传递参数调用sdk发起支付请求
            PaycenterService ps = new PaycenterService();
            ps.paycenterPayRequest(data, Response);
        }

        /// <summary>
        /// 海关电子订单支付
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        protected void customsPay_Click(object sender, EventArgs e)
        {
            Log.Info(this.GetType().ToString(), "============海关支付请求开始=========");
             //易票联网关支付地址
            
		    //1、获取商品信息参数-----------------------------
		    string currencyType = Tc_currencyType.Text;
            string totalFee = Tc_amount.Text;
            string remark = Tc_remark.Text;
            string goodsAmount = T_goodsAmount.Text;
            string goodsAmountCurr = T_goodsAmountCurr.Text;
            string taxAmount = T_taxAmount.Text;
            string taxAmountCurr = T_taxAmountCurr.Text;
            string freight = T_freight.Text;
            string freightCurr = T_freightCurr.Text;
            string bankAccount = T_bankAccount.Text;
            string bankAccType = T_bankAccType.Text;
            string userId = T_userId.Text;
            string userName = T_userName.Text;
            string certType = T_cert_type.Text;
            string certNo = T_cert_no.Text;
            string userMobile = T_userMobile.Text;
		    
		    //2、生成订单流水号-------------------------------
		    string outTradeNo = DateTime.Now.Ticks+"";
            System.Diagnostics.Debug.Write(outTradeNo);
			//3、实例化支付请求实体类，并设置需要的参数--------
            PayCenterData data = new PayCenterData();
            data.SetValue("partner", Resource.PARTNER);
            data.SetValue("out_trade_no",outTradeNo);
            data.SetValue("total_fee",totalFee);
            data.SetValue("currency_type",currencyType);
            data.SetValue("return_url", "http://localhost:57212/PayResponse.aspx");
            data.SetValue("notify_url", "http://localhost:57212/NotifyPayResponse.aspx");
            //中文要base64转码
            data.SetValue("base64_memo", Convert.ToBase64String(Encoding.Default.GetBytes(remark)));
            //海关电子网关支付特有参数
            data.SetValue("submission_type", "01");
            data.SetValue("goods_amount",goodsAmount);
            data.SetValue("goods_amount_curr",goodsAmountCurr);
            data.SetValue("tax_amount",taxAmount);
            data.SetValue("tax_amount_curr",taxAmountCurr);
            data.SetValue("freight",freight);
            data.SetValue("freight_curr",freightCurr);
            String userInfo = "bank_account="+bankAccount+"&bank_acc_type="+bankAccType+"&user_id="+userId+"&user_name="+userName+
                "&user_cert_type=" + certType + "&user_cert_no=" + certNo + "&user_mobile=" + userMobile;//根据接口文档中拼接base64_user_info
            //data.SetValue("notify_url","zhaohang");//直连招商银行
            data.SetValue("base64_user_info", Convert.ToBase64String(Encoding.Default.GetBytes(userInfo)));
            //4、传递参数调用sdk发起支付请求
            PaycenterService ps = new PaycenterService();
            ps.paycenterPayRequest(data,Response);
        }
    }
}