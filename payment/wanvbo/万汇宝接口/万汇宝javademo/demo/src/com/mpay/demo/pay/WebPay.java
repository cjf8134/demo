package com.mpay.demo.pay;

import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

import com.mpay.demo.utils.ConstantUtil;
import com.mpay.demo.utils.HttpClientUtil;
import com.mpay.demo.utils.SignUtil;


/**
 * 订单支付
 */
@WebServlet("/webPay")
public class WebPay extends HttpServlet {
	private static final long serialVersionUID = 1L;
	private static Log log = LogFactory.getLog(HttpClientUtil.class);
	/**
	 * 支付页面
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		String forward = "/webPay.jsp";  
		RequestDispatcher rd = request.getRequestDispatcher(forward);    
		rd.forward(request, response);  
	}

	/**
	 * 提交支付
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		Map<String,String> paramMap=new HashMap<String,String>();
		paramMap.put("mer_no", request.getParameter("mer_no"));
		paramMap.put("mer_order_no", request.getParameter("mer_order_no"));
		paramMap.put("channel_code", request.getParameter("channel_code"));
		paramMap.put("card_no", request.getParameter("card_no"));
		paramMap.put("trade_amount", request.getParameter("trade_amount"));
		paramMap.put("service_type", request.getParameter("service_type"));
		
		paramMap.put("order_date", new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(new Date()));
		paramMap.put("page_url", ConstantUtil.PAY_PAGE_CALLBAKE_URL);
		paramMap.put("back_url",ConstantUtil.PAY_BACK_CALLBAKE_URL);
		String signStr = SignUtil.sortData(paramMap);
		String sign = com.mpay.signutils.Md5Util.MD5Encode(signStr, ConstantUtil.PAY_KEY);
		paramMap.put("sign_type", "MD5");
		paramMap.put("sign", sign);
		log.info("signStr:" + signStr);
		log.info("sign:" + sign);
		
		request.setAttribute("REQ_URL", ConstantUtil.PAY_URL);
		request.setAttribute("paramMap", paramMap);
		
		String forward = "/webPaySubmit.jsp";  
		RequestDispatcher rd = request.getRequestDispatcher(forward);    
		rd.forward(request, response);  
	}

}
