package com.mmsp.demo.Controller;

import java.util.concurrent.ThreadLocalRandom;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.servlet.ModelAndView;

import com.alibaba.fastjson.JSONObject;
import com.mmsp.demo.*;
import com.mmsp.demo.bean.MmspConfigBean;

import io.swagger.annotations.Api;



/*
 * 网关支付接口
 * eg:
 * http://localhost:8090/api/gwpay/3000
 * 
 */

@Controller
@ComponentScan
@Configuration
@RequestMapping("/api/gwpay")
@Api(value = "demo - GatewaypayController", description = "网关支付接口demo")
public class GatewaypayController {
	private static Logger logger = Logger.getLogger(GatewaypayController.class);

	@Autowired
	MmspConfigBean mmspConfigBean;
	
	
	@RequestMapping(value="/{amt}",method=RequestMethod.GET)
	public String pay(@PathVariable int amt, Model model) {
		JSONObject result = new JSONObject();
		ModelAndView mv = new ModelAndView();
		try {

			JSONObject param = new JSONObject();
			JSONObject paramBody = new JSONObject();

			String goodsname = "测试商品";
			String orderid = "TEST" + System.currentTimeMillis();
			String randomNum = ThreadLocalRandom.current().nextInt(10000000, 99999999) + "";

			paramBody.put("MERORDERID", orderid);
			//param.put("PAY_CHANNEL", "ICBC-NET-B2C");
			//YLBILL-NET-B2C
			paramBody.put("PAY_CHANNEL", mmspConfigBean.getPaychannel());
			// 金额，单位：分
			paramBody.put("AMT", amt);
			// 商品名称，长度限制 1~15个字符串
			if (goodsname.length() > 15)
				goodsname = goodsname.substring(0, 15);
			paramBody.put("GOODSNAME", goodsname);
			// 支付结果通知地址
			paramBody.put("NOTIFY_URL",   mmspConfigBean.getNotifyurl());
			paramBody.put("JUMP_URL",  mmspConfigBean.getJumpurl());

			param.put("CommandID", 2322);// 微信扫码
			// param.put("CommandID", 2308 );//支付宝扫码支付
			param.put("RANDSTR", randomNum);
			// 终端号
			param.put("TERMNO", mmspConfigBean.getTermno());
			// 商户号
			param.put("MERNO", mmspConfigBean.getMerchno());
			// 固定值
			param.put("NodeID", "openapi");
			param.put("NodeType", 3);
			param.put("Version", "1.0.0");
			param.put("SeqID", "1");

			String[] signObj = MmspPayUtil.GenSign(paramBody, mmspConfigBean.getMd5key());
			String body = signObj[0];
			String sign = signObj[1];
			param.put("Sign", sign);
			logger.info("交易校验密钥:" + sign);

			String postdata = param.toString().substring(0, param.toString().length() - 1) + ",\"Body\":" + body + "}";
			logger.info("交易POST提交数据:" + postdata);

			model.addAttribute("apiurl", mmspConfigBean.getGwapi());
			
			model.addAttribute("apidata",postdata);
			
		} catch (Exception e) {
			logger.error(e.getMessage());
			result.put("result_code", "01");
			result.put("result_msg", "BS交易失败");
		}
		return "gw";
	}

}
