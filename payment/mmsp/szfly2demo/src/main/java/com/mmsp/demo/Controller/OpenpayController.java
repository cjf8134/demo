package com.mmsp.demo.Controller;

import java.util.concurrent.ThreadLocalRandom;

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
 * 微信、支付宝、QQ业务接口
 * eg:
 * http://localhost:8090/api/openpay/3000
 */

@ComponentScan
@Configuration
@RestController
@RequestMapping("/api/openpay")
@Api(value = "demo - OpenpayController", description = "扫码支付接口demo")
public class OpenpayController {
	private static Logger logger = Logger.getLogger(OpenpayController.class);

	@Autowired
	MmspConfigBean mmspConfigBean;


	@RequestMapping(value="/{amt}",method = RequestMethod.GET)
	public JSONObject pay(@PathVariable int amt) {
		JSONObject result = new JSONObject();
		try {

			JSONObject param = new JSONObject();

			String goodsname = "测试商品";
			String orderid = "TEST" + System.currentTimeMillis();
			String randomNum = ThreadLocalRandom.current().nextInt(10000000, 99999999) + "";

			param.put("MERORDERID", orderid);
			// 交易类型：1、正扫、2公众号支付
			param.put("TRADETYPE", 1);
			// 金额，单位：分
			param.put("AMT", amt);
			// 商品名称，长度限制 1~15个字符串
			if (goodsname.length() > 15)
				goodsname = goodsname.substring(0, 15);
			param.put("GOODSNAME", goodsname);
			// 支付结果通知地址
			param.put("NOTIFY_URL", mmspConfigBean.getNotifyurl());
			String merno = mmspConfigBean.getMerchno();
			String termno = mmspConfigBean.getTermno();
			String key = mmspConfigBean.getMd5key();
			String apiurl = mmspConfigBean.getOpenapi();
			//param.put("CommandID", 2306);// 微信扫码
			//param.put("CommandID", 1030 );//支付宝H5
			//param.put("CommandID", 2325 );//QQ宝扫码支付
			param.put("CommandID", mmspConfigBean.getCommandid() );
			param.put("RANDSTR", randomNum);
			// 终端号
			param.put("TERMNO", termno);
			// 商户号
			param.put("MERNO", merno);
			// 固定值
			param.put("NodeID", "openplat");
			param.put("NodeType", 3);
			param.put("Version", "1.0.0");
			param.put("SeqID", "1");
			param.put("IP", "127.0.0.1");
			param.put("JUMP_URL", "http://www.baidu.com");

			String[] signObj = MmspPayUtil.GenSign(param, key);
			String body = signObj[0];
			String sign = signObj[1];
			param.put("Sign", sign);
			logger.info("交易校验密钥:" + sign);

			String postdata = param.toString().substring(0, param.toString().length() - 1) + ",\"Body\":" + body + "}";
			logger.info("交易POST提交数据:" + postdata);

			String response = HttpUtil.submitPost(apiurl, postdata, "UTF-8", 60000, 60000);
			logger.info("BS交易返回的数据:" + response);
			JSONObject jsonMsg = JSONObject.parseObject(response);
			Integer retcode = jsonMsg.getInteger("RetCode");
			if (retcode == 1) {// 成功
				JSONObject jsonBody = JSONObject.parseObject(jsonMsg.getString("Body"));
				String payUrl = jsonBody.getString("URL");
				Integer bodyStatus = jsonBody.getInteger("STATUS");
				if (bodyStatus == 1) {

					result.put("result_code", "00");
					result.put("result_msg", "生成订单完成");
					result.put("order_id", orderid);
					result.put("pay_url", payUrl);

				} else {
					String errCode = jsonBody.getString("ERR_CODE");
					String errCodeMsg = jsonBody.getString("ERR_CODE_MSG");
					if (errCode != "00") {
						throw new Exception("产生订单失败(" + errCode + "):" + errCodeMsg);
					}
				}

			} else if (retcode == 2) {

				throw new Exception("产生订单失败:" + jsonMsg.getString("ERR_CODE_MSG"));
			} else {
				throw new Exception("产生订单失败");
			}
		} catch (Exception e) {
			logger.error(e.getMessage());
			result.put("result_code", "01");
			result.put("result_msg", "BS交易失败");
		}
		return result;
	}

}
