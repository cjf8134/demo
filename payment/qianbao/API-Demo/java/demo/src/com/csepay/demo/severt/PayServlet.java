package com.csepay.demo.severt;

import java.io.IOException;
import java.util.Arrays;
import java.util.HashMap;
import java.util.Map;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.csepay.demo.utils.Tools;

public class PayServlet extends HttpServlet{
	
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		//super.doGet(req, resp);
		
		String url = "http://localhost:8080/";
		
		String code = "1685";//商户代码
		String offline_notify = url+"demo/PayNotify";//后台异步通知 地址   异步调用5次 间隔1分钟
		String page_notify = url+"demo/PageNotify";//前台通知地址
		
		String interfaceVersion = "2.0.1";//接口版本号 固定ֵ
		String input_charset = "UTF-8";//编码格式
		String sign_type = "RSA-S";//加密方式
		String orderId = System.currentTimeMillis() + "";//订单编号
		String orderTime = Tools.getTime();//支付时间
		
		String order_amount = "10.5";//֧支付金额
		String product_name = "奥利奥";//商品名称 可空
		String product_code = "100002";//商品编号 可空
		String orderInfo = "测试";//订单信息 可空

		Map<String, String> param = new HashMap<>();
		param.put("code", code);
		param.put("offline_notify", offline_notify);
		param.put("page_notify", page_notify);
		param.put("interfaceVersion", interfaceVersion);
		param.put("input_charset", input_charset);
		param.put("sign_type", sign_type);
		param.put("orderId", orderId);

		param.put("orderTime", orderTime);
		param.put("order_amount", String.valueOf(order_amount));
		param.put("product_name", product_name);
		param.put("product_code", product_code);
		param.put("orderInfo", orderInfo);
		String[] keys = param.keySet().toArray(new String[] {});
		Arrays.sort(keys,String.CASE_INSENSITIVE_ORDER); //按 a-z 排序

		StringBuffer sb = new StringBuffer();
		for (String item : keys) {
			if(Tools.isNullOrEmpty(param.get(item)))
			continue;// 如果值为空则不参与计算
			sb.append(item);
			sb.append("=" + param.get(item));
			sb.append("&");
		}
		sb.deleteCharAt(sb.length() - 1);

		String sign = Tools.getSign(sb.toString());
		for (String string : keys) {
			req.setAttribute(string, param.get(string));
		}
		req.setAttribute("sign", sign);
		
		
		req.getRequestDispatcher("index.jsp").forward(req, resp);
		
	}

	
	@Override
	protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		this.doGet(req, resp);
		
	}
	
}
