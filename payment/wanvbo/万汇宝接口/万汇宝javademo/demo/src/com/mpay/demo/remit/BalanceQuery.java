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
import com.mpay.signutils.Md5Util;

/**
 * 余额查询
 *
 */
@WebServlet("/balanceQuery")
public class BalanceQuery extends HttpServlet {
	private static final long serialVersionUID = 1L;

	@Override
	protected void service(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		String mer_no = req.getParameter("mer_no");
		String sign_type = ConstantUtil.SIGN_TYPE;

		// 签名
		Map<String, String> paramMap = new HashMap<>();
		paramMap.put("mer_no", mer_no);
		String signStr = SignUtil.sortData(paramMap);
		String sign = Md5Util.MD5Encode(signStr, ConstantUtil.REMIT_KEY);
		paramMap.put("sign", sign);
		paramMap.put("sign_type", sign_type);

		// 发送
		String result = HttpClientUtil.post(ConstantUtil.BALANCE_QUERY_URL, paramMap);
		System.out.println("返回结果：" + result);

		// 返回参数处理
		JSONObject obj = JSON.parseObject(result);
		String ret_sign_type = obj.getString("sign_type");
		String ret_sign = obj.getString("sign");
		String ret_mer_no = obj.getString("mer_no");
		String ret_auth_result = obj.getString("auth_result");
		String ret_error_msg = obj.getString("error_msg");
		String amount = obj.getString("amount");
		String frozen_amount = obj.getString("frozen_amount");
		String available_amount = obj.getString("available_amount");
		String status = obj.getString("status");
		String unsettle_amount = obj.getString("unsettle_amount");

		Map<String, String> returnMap = new HashMap<>();
		SignUtil.putIfNotNull(returnMap, "mer_no", ret_mer_no);
		SignUtil.putIfNotNull(returnMap, "auth_result", ret_auth_result);
		SignUtil.putIfNotNull(returnMap, "error_msg", ret_error_msg);
		SignUtil.putIfNotNull(returnMap, "amount", amount);
		SignUtil.putIfNotNull(returnMap, "frozen_amount", frozen_amount);
		SignUtil.putIfNotNull(returnMap, "available_amount", available_amount);
		SignUtil.putIfNotNull(returnMap, "unsettle_amount", unsettle_amount);
		SignUtil.putIfNotNull(returnMap, "status", status);

		String retSignStr = SignUtil.sortData(returnMap);
		String retSign = Md5Util.MD5Encode(retSignStr, ConstantUtil.REMIT_KEY);
		if (!ConstantUtil.SIGN_TYPE.equals(ret_sign_type) || !retSign.equals(ret_sign)) {
			System.out.println("签名验证失败");
		} else {
			System.out.println("签名验证成功");
		}
	}
}
