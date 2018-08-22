package com.mpay.demo.pay.orderquery;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;
import com.mpay.demo.utils.ConstantUtil;
import com.mpay.demo.utils.HttpClientUtil;
import com.mpay.demo.utils.SignUtil;
import com.mpay.signutils.Md5Util;

/**
 * 订单查询
 */
@WebServlet("/selectOrder")
public class SelectOrder extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
	/**
	 * 查询支付订单页面
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		String forward = "/SelectOrder.jsp";  
		RequestDispatcher rd = request.getRequestDispatcher(forward);    
		rd.forward(request, response);  
	}

	/**
	 * 提交支付订单查询
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		Map<String, String> param=new HashMap<>();
		param.put("mer_no", request.getParameter("mer_no"));
		param.put("mer_order_no", request.getParameter("mer_order_no"));
		String sign= getSign(param);
		
		param.put("sign",sign);
		
		param.put("sign_type", ConstantUtil.SIGN_TYPE);
		
		String result= HttpClientUtil.post(ConstantUtil.SELECT_Order_URL, param);
		System.out.println("返回结果：" + result);

		// 返回参数处理
		JSONObject obj = JSON.parseObject(result);
		String ret_sign_type = obj.getString("sign_type");
		String ret_sign = obj.getString("sign");
		String ret_mer_no = obj.getString("mer_no");
		String ret_auth_result = obj.getString("auth_result");
		String ret_error_msg = obj.getString("error_msg");
		String trade_amount = obj.getString("trade_amount");
		String trade_result = obj.getString("trade_result");
		String mer_order_no = obj.getString("mer_order_no");
		String order_no = obj.getString("order_no");
		String pay_date = obj.getString("pay_date");

		Map<String, String> returnMap = new HashMap<>();
		SignUtil.putIfNotNull(returnMap, "mer_no", ret_mer_no);
		SignUtil.putIfNotNull(returnMap, "auth_result", ret_auth_result);
		SignUtil.putIfNotNull(returnMap, "error_msg", ret_error_msg);
		SignUtil.putIfNotNull(returnMap, "trade_amount", trade_amount);
		SignUtil.putIfNotNull(returnMap, "trade_result", trade_result);
		SignUtil.putIfNotNull(returnMap, "mer_order_no",mer_order_no );
		SignUtil.putIfNotNull(returnMap, "order_no", order_no);
		SignUtil.putIfNotNull(returnMap, "pay_date", pay_date);

		String retSignStr = SignUtil.sortData(returnMap);
		System.out.println("retSignStr:"+retSignStr);
		String retSign = Md5Util.MD5Encode(retSignStr, ConstantUtil.PAY_KEY);
		if (!ConstantUtil.SIGN_TYPE.equals(ret_sign_type) || !retSign.equals(ret_sign)) {
			System.out.println("签名验证失败");
		} else {
			System.out.println("签名验证成功");
		}
		response.setContentType("text/html;charset=utf-8");
		response.getWriter().print(result);
	}
	
	private String getSign(Map<String, String> paramMap){
		String signStr = SignUtil.sortData(paramMap);
		String result = com.mpay.signutils.Md5Util.MD5Encode(signStr, ConstantUtil.PAY_KEY);
		return result;
	}
}
