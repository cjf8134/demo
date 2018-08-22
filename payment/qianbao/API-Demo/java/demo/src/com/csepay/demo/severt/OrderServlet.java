package com.csepay.demo.severt;

import java.io.IOException;
import java.net.URLEncoder;
import java.util.Arrays;
import java.util.Calendar;
import java.util.HashMap;
import java.util.Map;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.csepay.demo.utils.Tools;

public class OrderServlet extends HttpServlet{
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		
		String beginTime=req.getParameter("beginTime");
		String endTime=req.getParameter("endTime");
		
		String page=req.getParameter("pageIndex");
		String size=req.getParameter("pageSize");
		
		int pageIndex=(Tools.isNullOrEmpty(page))?1:Integer.parseInt(page);  //不参与签名计算
		int pageSize=(Tools.isNullOrEmpty(size))?1:Integer.parseInt(size);  //不参与签名计算
		
		String orderId="";//订单编号
		String code="1685";//商户号
		String interfaceVersion = "2.0.1";//接口版本号 固定ֵ
		String input_charset = "UTF-8";//编码格式
		String sign_type = "RSA-S";//加密方式
		
		String result_format="JSON"; //返回格式 （JSON/XML）
		
		// 1、取得本地时间：
	    Calendar cal = Calendar.getInstance() ;
	    // 2、取得时间偏移量：
	    int zoneOffset = cal.get(java.util.Calendar.ZONE_OFFSET);
	    // 3、取得夏令时差：
	    int dstOffset = cal.get(java.util.Calendar.DST_OFFSET);
	    // 4、从本地时间里扣除这些差量，即可以取得UTC时间：
	    cal.add(java.util.Calendar.MILLISECOND, -(zoneOffset + dstOffset));
		
		String timestamps=cal.getTimeInMillis()+"";
		timestamps=timestamps.substring(0, 10);//10 位  时间戳
		
		
		Map<String, String> param = new HashMap<>();
		param.put("code", code);
		param.put("interfaceVersion", interfaceVersion);
		param.put("input_charset", input_charset);
		param.put("sign_type", sign_type);
		param.put("orderId", orderId);
		param.put("result_format", result_format);
		param.put("timestamps", timestamps);
		param.put("endTime", endTime);
		param.put("beginTime", beginTime);
		
		
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
		sign=URLEncoder.encode(sign);
		
		StringBuffer params=new StringBuffer("https://www.csewallet.com/csepay/GetOrderList?");
		params.append(sb.toString());
		params.append("&sign="+sign);
		params.append("&pageIndex="+pageIndex);
		params.append("&pageSize="+pageSize);
		
		resp.sendRedirect(params.toString());
		
	}
	
	@Override
	protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		this.doGet(req, resp);
	}
	

}
