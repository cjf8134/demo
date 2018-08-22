package com.mmsp.demo.Controller;

import java.io.BufferedReader;
import java.util.concurrent.ThreadLocalRandom;

import javax.servlet.http.HttpServletRequest;

import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

import com.alibaba.fastjson.JSONObject;
import com.mmsp.demo.*;
import com.mmsp.demo.bean.MmspConfigBean;

import io.swagger.annotations.Api;

/*
 * 
 * 快捷支付接口
 * eg:
 * http://localhost:8010/api/quickpay/3000
 */

@ComponentScan
@Configuration
@RestController
@RequestMapping("/api/quickpay")
@Api(value = "demo - QuickpayController", description = "快捷支付接口demo")
public class QuickpayController {

	@Autowired
	HttpServletRequest request; // 这里可以获取到request

	private static Logger logger = Logger.getLogger(QuickpayController.class);

	@Autowired
	MmspConfigBean mmspConfigBean;

	@RequestMapping(value="/{amt}",method=RequestMethod.GET)
	public JSONObject payment(@PathVariable int amt) {
		String orderid = "TEST" + System.currentTimeMillis();

		JSONObject param = new JSONObject();
		param.put("AMT", amt);
		param.put("MERORDERID", orderid);

		param.put("CARDNO", "6225365271562822");
		param.put("NAME", "测试");
		param.put("CARDTYPE", 1); // 1：借记卡 2：信用卡

		// param.put("EXPDATE", "1203");
		// param.put("CVN2", "123");
		param.put("ID_NO", "12345612345678123X");
		param.put("PHONENO", "12312345678");
		param.put("NOTIFY_URL", mmspConfigBean.getNotifyurl());
		param.put("JUMP_URL", mmspConfigBean.getJumpurl());

		return postAndReturn(param, "快捷支付交易");
	}

	private JSONObject postAndReturn(JSONObject param,  String msg) {
		
		int commandId =  mmspConfigBean.getCommandid();

		String randomNum = ThreadLocalRandom.current().nextInt(10000000, 99999999) + "";
		param.put("RANDSTR", randomNum);
		String[] signObj = MmspPayUtil.GenSign(param, mmspConfigBean.getMd5key());
		String body = signObj[0];
		String sign = signObj[1];
		param.clear();
		param.put("Sign", sign);
		param.put("NodeID", "openapi");
		param.put("NodeType", 3);
		param.put("Version", "1.0.0");
		param.put("SeqID", "1");
		param.put("CommandID", commandId);
		param.put("MERNO", mmspConfigBean.getMerchno());
		param.put("TERMNO", mmspConfigBean.getTermno());

		logger.info("渠道交易[BSPAY]校验密钥:" + sign);

		String postdata = param.toString().substring(0, param.toString().length() - 1) + ",\"Body\":" + body + "}";
		logger.info("渠道交易[BSPAY]POST提交数据:" + postdata);

		try {

			String response = HttpUtil.submitPost(mmspConfigBean.getOpenapi(), postdata, "UTF-8", 60000, 60000);
			logger.info("渠道交易[BSPAY]返回的数据:" + response);
			JSONObject jsonMsg = JSONObject.parseObject(response);
			Integer retcode = jsonMsg.getInteger("RetCode");
			JSONObject json = new JSONObject();
			if (retcode == 1) {// 返回成功
				JSONObject jsonBody = JSONObject.parseObject(jsonMsg.getString("Body"));
				Integer status = jsonBody.getInteger("STATUS");
				String channelOrderNo = jsonBody.getString("LIST_ID");
				if (status == 0) { // 成功
					json.put("respCode", "00");
					json.put("message", "success");
					json.put("channelOrderno", channelOrderNo);
					json.put("pay_url", jsonBody.getString("PAY_URL"));

				} else {
					String errcode = jsonBody.getString("ERRCODE");
					String errmsg = jsonBody.getString("ERRMSG");
					logger.error(msg + "失败(" + errcode + "):" + errmsg);
					json.put("respCode", "01");
					json.put("message", errmsg);
				}
			} else {
				String errmsg = jsonMsg.getString("ErrorMsg");
				logger.error(msg + "失败(" + retcode + "):" + errmsg);
				json.put("respCode", "02");
				json.put("message", errmsg);
			}
			return json;
		} catch (Exception e) {
			e.printStackTrace();
			logger.error(msg + "失败", e);
			return null;
		}
	}

}
