package com.mpay.demo.pay.callback;

import java.io.IOException;
import java.util.Enumeration;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 * 页面通知
 */
@WebServlet("/webPayBackCallBake")
public class WebPayBackCallBake extends HttpServlet {
	private static final long serialVersionUID = 1L;
	/**
	 * 支付成功后，异步回调调用方法
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		Enumeration<String> paraNames=request.getParameterNames();
		
		for(Enumeration<String> e=paraNames;e.hasMoreElements();){
			String parameterName=e.nextElement().toString();
			String parameterValue=request.getParameter(parameterName);
			System.out.println(parameterName+":"+parameterValue);
		}
	}

}
