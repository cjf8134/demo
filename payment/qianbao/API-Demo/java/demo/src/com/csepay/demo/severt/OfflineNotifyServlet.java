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

/**
 * 后台通知
 * 
 * @author Administrator
 *
 */
public class OfflineNotifyServlet extends HttpServlet {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	@Override
	protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {

		String orderId =Tools.getUTF8String(req, "orderId") ;
		String trade_status = Tools.getUTF8String(req,"trade_status");
		String code = Tools.getUTF8String(req,"code");
		String orderInfo =Tools.getUTF8String(req,"orderInfo");
		String orderTime = Tools.getUTF8String(req,"orderTime");
		String sign_type = Tools.getUTF8String(req,"sign_type");
		String product_name = Tools.getUTF8String(req,"product_name");
		String product_code = Tools.getUTF8String(req,"product_code");
		String sign = Tools.getUTF8String(req,"sign");
		String input_charset = Tools.getUTF8String(req,"input_charset");
		String order_amount = Tools.getUTF8String(req,"order_amount");

		
		Map<String, String> param = new HashMap<>();
		param.put("code", code);
		param.put("input_charset", input_charset);
		param.put("sign_type", sign_type);
		param.put("orderId", orderId);
		param.put("trade_status", trade_status);
		param.put("orderTime", orderTime);
		param.put("order_amount", String.valueOf(order_amount));
		param.put("product_name", product_name);
		param.put("product_code", product_code);
		param.put("orderInfo", orderInfo);
		String[] keys = param.keySet().toArray(new String[] {});
		Arrays.sort(keys,String.CASE_INSENSITIVE_ORDER); // 按 a-z 排序

		StringBuffer sb = new StringBuffer();
		for (String item : keys) {
			if (Tools.isNullOrEmpty(param.get(item)))
				continue;// 如果值为空则不参与计算
			sb.append(item);
			sb.append("=" + param.get(item));
			sb.append("&");
		}
		sb.deleteCharAt(sb.length() - 1);

		System.out.println(sb.toString());
		// csePay公钥
		String public_key = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCTXRAk0ulemRBuM0PuA49imn/6hicl7cVmCo++98V/1lX1kT0DY2FDD8Jz97vqhuOBo474+Ia7bEEMunI6z/AUXw1CF6KtGwGPx/Q8IuG426EZjH3wCSOthQncW8hHBCkgzjqu/Yi/y1E8TVFB8bp1+28L/ZpTZc0ZGnQmp04HSQIDAQAB";

		boolean result = Tools.doCheck(sb.toString(), sign, public_key, input_charset);
		if (result) {
			resp.getWriter().print("success");
			System.out.println("success");
		} else {
			resp.getWriter().print("error");
			System.out.println("error");
		}

	}

}
