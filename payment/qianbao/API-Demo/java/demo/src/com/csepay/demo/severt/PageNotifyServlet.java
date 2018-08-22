package com.csepay.demo.severt;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.csepay.demo.utils.Tools;

/**
 * 前台页面
 * @author Administrator
 *
 */
public class PageNotifyServlet extends HttpServlet{
	
	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		
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
		
		req.setAttribute("trade_status", trade_status);
		req.getRequestDispatcher("returnpage.jsp").forward(req, resp);
		
	}
	
	@Override
	protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		this.doGet(req, resp);
	}
	

}
