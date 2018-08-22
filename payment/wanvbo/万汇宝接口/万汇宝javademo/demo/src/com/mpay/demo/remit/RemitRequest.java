package com.mpay.demo.remit;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

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
import com.mpay.signutils.AesUtil;
import com.mpay.signutils.Md5Util;

/**
 * 代付请求
 *
 */
@WebServlet("/remitRequest")
public class RemitRequest  extends HttpServlet {

	private static final long serialVersionUID = 1L;

	@Override
	protected void service(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		String mer_no = req.getParameter("mer_no");
		String mer_remit_no = req.getParameter("mer_remit_no");
		String apply_date = req.getParameter("apply_date");
		String bank_code = req.getParameter("bank_code");
		String province = req.getParameter("province");
		String city = req.getParameter("city");
		String card = req.getParameter("card");
		String name = req.getParameter("name");
		String amount = req.getParameter("amount");
		String remark = req.getParameter("remark");
		
		String card_and_name = card+"|"+name;
		card_and_name = AesUtil.encrypt(card_and_name, ConstantUtil.REMIT_KEY);
		
		String sign_type = ConstantUtil.SIGN_TYPE;
		
		//签名
		Map<String, String> paramMap = new HashMap<>();
		
		paramMap.put("card_and_name", card_and_name);
		paramMap.put("mer_no", mer_no);
		paramMap.put("mer_remit_no", mer_remit_no);
		paramMap.put("apply_date",apply_date );
		paramMap.put("bank_code", bank_code);
		paramMap.put("province", province);
		paramMap.put("city", city);
		paramMap.put("amount", amount);
		paramMap.put("remark", remark);
		String signStr = SignUtil.sortData(paramMap);
		String sign = Md5Util.MD5Encode(signStr, ConstantUtil.REMIT_KEY);
		paramMap.put("sign", sign);
		paramMap.put("sign_type", sign_type);
		
		//发送
		String result = HttpClientUtil.post(ConstantUtil.REMIT_URL, paramMap);
		System.out.println("返回结果："+result);
		
		//返回参数处理
		JSONObject obj = JSON.parseObject(result);
		String ret_sign_type = obj.getString("sign_type");
		String ret_sign = obj.getString("sign");
		String ret_mer_no = obj.getString("mer_no");
		String ret_auth_result = obj.getString("auth_result");
		String ret_error_msg = obj.getString("error_msg");
		String ret_mer_remit_no = obj.getString("mer_remit_no");
		String ret_trade_result = obj.getString("trade_result");
		String ret_amount = obj.getString("amount");
		String ret_apply_date = obj.getString("apply_date");
		
		Map<String, String> returnMap = new HashMap<>();
		SignUtil.putIfNotNull(returnMap, "mer_no", ret_mer_no);
		SignUtil.putIfNotNull(returnMap, "auth_result",ret_auth_result);
		SignUtil.putIfNotNull(returnMap, "error_msg", ret_error_msg);
		SignUtil.putIfNotNull(returnMap, "mer_remit_no", ret_mer_remit_no);
		SignUtil.putIfNotNull(returnMap, "trade_result", ret_trade_result);
		SignUtil.putIfNotNull(returnMap, "amount", ret_amount);
		SignUtil.putIfNotNull(returnMap, "apply_date", ret_apply_date);
		
		String retSignStr = SignUtil.sortData(returnMap);
		String retSign = Md5Util.MD5Encode(retSignStr, ConstantUtil.REMIT_KEY);
		String signCheckMsg = "";
		if(!ConstantUtil.SIGN_TYPE.equals(ret_sign_type) || !retSign.equals(ret_sign)) {
			signCheckMsg = "签名验证失败";
		}else{
			signCheckMsg = "签名验证成功";
		}
		resp.getWriter().println("返回参数："+retSignStr);
		resp.getWriter().println("签名验证结果："+signCheckMsg);
		System.out.println("返回参数："+retSignStr);
		System.out.println("签名验证结果："+signCheckMsg);
		resp.getWriter().close();
	}
}
