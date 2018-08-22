using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Paycenter_sdk.lib;
using System.Collections.Specialized;
using System.Web.UI;
using System.Text;

namespace Paycenter_sdk.service
{
    public class PaycenterService
    {
        /// <summary>
        /// 发起支付请求
        /// </summary>
        /// <param name="data">支付请求参数</param>
        /// <param name="response">HttpResponse</param>
        public void paycenterPayRequest(PayCenterData data,HttpResponse response) {
            data.SetValue("version", Resource.VERSION.ToString());
            string url = Resource.PAY_URL;
            string httpUrl = url + "?";
            string sign = data.MakeSign();
            //请求实体类自动签名并得到支付参数--------------
            string requestStr = data.ToRequestUrl() + "&sign=" + HttpUtility.UrlEncode(sign, Encoding.GetEncoding("GBK"));
            httpUrl += requestStr;
            Log.Info(this.GetType().ToString(), "请求url：" + httpUrl);
            //发起请求-------------------------------------
            response.Redirect(httpUrl);
        }

        /// <summary>
        /// 支付请求获取同步消息返回
        /// </summary>
        /// <param name="page">Page</param>
        /// <returns>返回响应参数 SortedDictionary</returns>
        public PayCenterData acceptResponse(Page page) {
            PayCenterData data = new PayCenterData();
            NameValueCollection nvc = page.Request.QueryString;
            if (nvc.Count != 0)
            {
                for (int i = 0; i < nvc.Count; i++)
                {
                    data.SetValue(nvc.GetKey(i), nvc.GetValues(i)[0]);
                }
            }
            else
            {
                Log.Info(this.GetType().ToString(), "没有收到传递的参数值");
            }

            //2、验证签名
            if (data.CheckSign())
            {
                Log.Info(this.GetType().ToString(), "签名验证成功");
                return data;
            }
            else
            {
                Log.Error(this.GetType().ToString(), "PayCenterData签名验证错误!");
                throw new PayCenterException("PayCenterData签名验证错误!");
            }
            
        }

        /// <summary>
        /// 支付请求获取异步消息返回
        /// </summary>
        /// <param name="page">Page</param>
        /// <returns>返回响应参数 SortedDictionary</returns>
        public PayCenterData acceptNotifyResponse(Page page)
        {
            //实例化异步通知处理类
            Notify notify = new Notify(page);
            //得到异步响应参数
            PayCenterData data = notify.GetNotifyData();
            //返回
            return data;
        }


        /// <summary>
        /// 订单查询
        /// </summary>
        /// <param name="outTradeNo">商户平台业务流水号</param>
        /// <returns>返回响应参数 SortedDictionary</returns>
        public PayCenterData paycenterQueryOrder(string outTradeNo) 
        {
            Log.Info(this.GetType().ToString(), "===========查询订单请求开始============");
            //易票联网关订单类地址
            string url = Resource.ORDER_URL;
            string httpUrl = url + "?";
            //1、实例化支付请求实体类，并设置需要的参数--------
            PayCenterData data = new PayCenterData();
            data.SetValue("partner", Resource.PARTNER);
            data.SetValue("trans_type","query");
            data.SetValue("out_trade_no", outTradeNo);
            data.SetValue("version", Resource.VERSION.ToString());
            //2、签名
            string sign = data.MakeSign();
            //3、请求实体类自动签名并得到支付参数--------------
            string requestStr = data.ToRequestUrl() + "&sign=" + HttpUtility.UrlEncode(sign, Encoding.GetEncoding("GBK"));
            httpUrl += requestStr;
            Log.Info(this.GetType().ToString(), "请求地址：" + httpUrl);
            //4、发起请求并得到响应
            String responseXml = HttpUtil.HttpPost(httpUrl,requestStr);
            Log.Info(this.GetType().ToString(), "响应xml：" + responseXml);
            PayCenterData responseData = new PayCenterData();
            SortedDictionary<string, object> sd = responseData.FromXml(responseXml);
            
            return responseData;
        }

        /// <summary>
        /// 退款请求
        /// </summary>
        /// <param name="outTradeNo">商户平台业务流水号</param>
        /// <param name="outRefundNo">商户平台退款单号</param>
        /// <param name="totalAmount">订单总金额</param>
        /// <param name="refundAmount">退款金额</param>
        /// <returns>返回响应参数 SortedDictionary</returns>
        public PayCenterData paycenterRefundRequest(string outTradeNo,string outRefundNo,string totalAmount,string refundAmount)
        {
            Log.Info(this.GetType().ToString(), "===========退款请求开始============");
            //易票联网关订单类地址
            string url = Resource.ORDER_URL;
            string httpUrl = url + "?";
            //1、实例化支付请求实体类，并设置需要的参数--------
            PayCenterData data = new PayCenterData();
            data.SetValue("partner", Resource.PARTNER);
            data.SetValue("trans_type", "refund");
            data.SetValue("sign_type", "SHA256withRSA");
            data.SetValue("out_trade_no", outTradeNo);
            data.SetValue("out_refund_no", outRefundNo);
            data.SetValue("total_amount",totalAmount);
            data.SetValue("refund_amount",refundAmount);
            //2、签名
            string sign = data.MakeSign();
            //3、请求实体类自动签名并得到支付参数--------------
            string requestStr = data.ToRequestUrl() + "&sign=" + HttpUtility.UrlEncode(sign, Encoding.GetEncoding("GBK"));
            httpUrl += requestStr;
            Log.Info(this.GetType().ToString(), "请求地址：" + httpUrl);
            //4、发起请求并得到响应
            String responseXml = HttpUtil.HttpPost(httpUrl, requestStr);
            Log.Info(this.GetType().ToString(), "响应xml：" + responseXml);
            PayCenterData responseData = new PayCenterData();
            SortedDictionary<string, object> sd = responseData.FromXml(responseXml);

            return responseData;
        }

        /// <summary>
        /// 退款单查询
        /// </summary>
        /// <param name="outTradeNo">商户平台订单流水号</param>
        /// <param name="refundId">易票联退款单号</param>
        /// <param name="outRefundNo">商户平台退款单号</param>
        /// <returns></returns>
        public PayCenterData paycenterRefundQuery(string outTradeNo,string refundId,String outRefundNo)
        {
            Log.Info(this.GetType().ToString(), "===========退款订单查询请求开始============");
            //易票联网关订单类地址
            string url = Resource.ORDER_URL;
            string httpUrl = url + "?";
            //1、实例化支付请求实体类，并设置需要的参数--------
            PayCenterData data = new PayCenterData();
            data.SetValue("partner", Resource.PARTNER);
            data.SetValue("trans_type", "refundQuery");
            data.SetValue("sign_type", "SHA256withRSA");
            data.SetValue("out_trade_no", outTradeNo);
            data.SetValue("refund_id",refundId);
            data.SetValue("out_refund_no",outRefundNo);
            //2、签名
            string sign = data.MakeSign();
            //3、请求实体类自动签名并得到支付参数--------------
            string requestStr = data.ToRequestUrl() + "&sign=" + HttpUtility.UrlEncode(sign, Encoding.GetEncoding("GBK"));
            httpUrl += requestStr;
            Log.Info(this.GetType().ToString(), "请求地址：" + httpUrl);
            //4、发起请求并得到响应
            String responseXml = HttpUtil.HttpPost(httpUrl, requestStr);
            Log.Info(this.GetType().ToString(), "响应xml：" + responseXml);
            PayCenterData responseData = new PayCenterData();
            SortedDictionary<string, object> sd = responseData.FromXml(responseXml);

            return responseData;
        }
    }
}