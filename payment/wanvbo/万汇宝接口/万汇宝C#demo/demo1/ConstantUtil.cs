using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace demo1
{
    public class ConstantUtil
    {
        public const String PAY_BASICS_URL="http://pay.wanvbo.com" ;
	
	//支付请求地址
	    public const String PAY_URL=PAY_BASICS_URL+"/payment/web/receive" ;
	
	//扫码支付请求地址
	    public const String SCAN_PAY_URL=PAY_BASICS_URL+"/payment/api/scanpay" ;
	
	//查询请求地址
	    public const String SELECT_Order_URL=PAY_BASICS_URL+"/query/order/doquery" ;
	
	//测试支付成功同步通知,如使用localhost将得不到通知,请使用对应的域名
	    public const String APP_BASICS_URL="http://demo.wanvbo.com";
	    public const String PAY_PAGE_CALLBAKE_URL=APP_BASICS_URL+ "/webPayPageCallBake/WebPayPageCall";
	    public const String PAY_BACK_CALLBAKE_URL=APP_BASICS_URL+ "/WebPayBackCallBake/WebPayBackCall";
	
	//代付请求地址
	    public const String REMIT_BASE_URL = "http://remit.wanvbo.com";
	    public const String REMIT_URL =  REMIT_BASE_URL + "/remit/doRemit";
	    public const String REMIT_QUERY_URL = REMIT_BASE_URL + "/remit/query";
	    public const String BALANCE_QUERY_URL = REMIT_BASE_URL + "/balance/query";
	
	//支付秘钥
	    public const String PAY_KEY="";
	
	//代付秘钥
	    public const String REMIT_KEY= "";
	
	//签名类型
	    public const String SIGN_TYPE="MD5" ;
    }
}
