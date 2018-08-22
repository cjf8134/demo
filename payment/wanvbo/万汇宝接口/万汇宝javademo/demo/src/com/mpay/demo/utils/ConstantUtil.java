package com.mpay.demo.utils;

public class ConstantUtil {
	//支付api地址
	public static final String PAY_BASICS_URL="http://pay.wanvbo.com" ;
	
	//支付请求地址
	public static final String PAY_URL=PAY_BASICS_URL+"/payment/web/receive" ;
	
	//扫码支付请求地址
	public static final String SCAN_PAY_URL=PAY_BASICS_URL+"/payment/api/scanpay" ;
	
	//查询请求地址
	public static final String SELECT_Order_URL=PAY_BASICS_URL+"/query/order/doquery" ;
	
	//测试支付成功同步通知,如使用localhost将得不到通知,请使用对应的域名
	public static final String APP_BASICS_URL="http://demo.wanvbo.com";
	public static final String PAY_PAGE_CALLBAKE_URL=APP_BASICS_URL+"/webPayPageCallBake" ;
	public static final String PAY_BACK_CALLBAKE_URL=APP_BASICS_URL+"/webPayBackCallBake" ;
	
	//代付请求地址
	public static final String REMIT_BASE_URL = "http://remit.wanvbo.com";
	public static final String REMIT_URL =  REMIT_BASE_URL + "/remit/doRemit";
	public static final String REMIT_QUERY_URL = REMIT_BASE_URL + "/remit/query";
	public static final String BALANCE_QUERY_URL = REMIT_BASE_URL + "/balance/query";
	
	//支付秘钥
	public static final String PAY_KEY="";
	
	//代付秘钥
	public static final String REMIT_KEY="" ;
	
	//签名类型
	public static final String SIGN_TYPE="MD5" ;
	
}
