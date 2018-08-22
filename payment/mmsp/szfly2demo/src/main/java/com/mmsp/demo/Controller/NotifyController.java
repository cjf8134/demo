package com.mmsp.demo.Controller;

import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;

import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;
import com.alibaba.fastjson.TypeReference;
import com.mmsp.demo.*;
import com.mmsp.demo.bean.MmspConfigBean;
import com.mmsp.demo.bean.NotifyBean;

import io.swagger.annotations.Api;

/*
 * 
 * 异步回调接口
 * http://localhost:8090/api/rsynnotify
 */

@ComponentScan
@Configuration
@RestController
@RequestMapping("/api")
@Api(value = "demo - NotifyController", description = "异步回调demo")
public class NotifyController {
	private static Logger logger = Logger.getLogger(NotifyController.class);

	@Autowired
	MmspConfigBean mmspConfigBean;

	@PostMapping("/rsynnotify")
	public String recnotify(@RequestBody String param) {

		logger.info("param：" + param);
		
		NotifyBean notify = JSON.parseObject(param,new TypeReference<NotifyBean>() {});


		logger.info("Sign:" + notify.getSign());

		String[] rets = MmspPayUtil.GenSign(notify.getBody(), mmspConfigBean.getMd5key());
		if (rets[1].equals(notify.getSign())) {
			logger.info("签名验证通过");
		} else {
			logger.info("签名不符");
			return "error";
		}
		logger.info("CommandID:" + notify.getCommandID());
	
		JSONObject bodyObject = notify.getBody();
		
		//支付状态：1，支付成功，支付成功才会推送交易结果，其他的支付状态不推送结果
		String status=bodyObject.getString("STATUS");
				
		if("1".equals(status)){//支付成功
		{
			logger.info("支付成功");
		}
	
		}else{
			logger.info("支付失败");
		}
		return "success";
	}
	
	public static void main(String[] args ) {
		String retdata = "{\"CommandID\":35104,\"SeqID\":1,\"NodeType\":3,\"NodeID\":\"openplat\",\"Version\":\"1.0.0\",\"RetCode\":1,\"ErrorMsg\":\"\",\"Body\":{\"AMT\":\"600\",\"GOODSNAME\":\"BB-CRAZYEXPLOSIVE\",\"LIST_ID\":\"110005150316\",\"MERORDERID\":\"e4b0810b45a035b2F624\",\"NOTIFY_DATE\":\"20180615111455\",\"PAY_DATE\":\"20180615111455\",\"PUSH_COUNT\":8,\"STATUS\":\"1\"},\"Sign\":\"33651BCB72AE1A6E79CC29B6DB24BA10\",\"AGENTNO\":\"\",\"MERNO\":\"019100059696660\",\"TERMNO\":\"25980001\"}";
		
		NotifyBean notify = JSON.parseObject(retdata,new TypeReference<NotifyBean>() {});
		
		logger.info("Sign:" + notify.getSign());
		
		String[] rets = MmspPayUtil.GenSign(notify.getBody(), "049e810e68774fcf0dc2adca030a9a7d");
		
		logger.info("Compute Sign:" + rets[1]);
		
	}
}
