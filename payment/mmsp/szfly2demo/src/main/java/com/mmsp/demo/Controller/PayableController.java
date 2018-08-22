package com.mmsp.demo.Controller;

import java.io.FileNotFoundException;
import java.nio.charset.Charset;
import java.security.PrivateKey;
import java.security.PublicKey;
import java.security.Signature;
import java.text.SimpleDateFormat;
import java.util.Base64;
import java.util.Calendar;
import java.util.Date;
import java.util.concurrent.ThreadLocalRandom;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.log4j.Logger;
import org.apache.tomcat.jni.File;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.util.ResourceUtils;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestController;

import com.alibaba.fastjson.JSONObject;
import com.alibaba.fastjson.TypeReference;
import com.mmsp.demo.*;
import com.mmsp.demo.bean.MmspConfigBean;
import com.mmsp.demo.bean.PayableResultBean;

import io.swagger.annotations.Api;

/*
 * 代付接口
 * eg:
 * http://localhost:8090/api/payable/3000
 * 
 */

@ComponentScan
@Configuration
@RestController
@RequestMapping("/api/payable")
@Api(value = "demo - PayableController", description = "代付接口demo")
public class PayableController {
	private static Logger logger = Logger.getLogger(PayableController.class);
	
	
	@Autowired
	MmspConfigBean mmspConfigBean;
	
	private static String publicKeyStr = null;
	private static String privateKeyStr = null;
	private static String mmspKeyStr = null;
	
	PayableController(){
		
		try {
			publicKeyStr = MmspPayUtil.txt2String(ResourceUtils.getFile("classpath:keys/public.key"));
			privateKeyStr = MmspPayUtil.txt2String(ResourceUtils.getFile("classpath:keys/private.key"));
			mmspKeyStr = MmspPayUtil.txt2String(ResourceUtils.getFile("classpath:keys/mmsp.key"));
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}

	

	@RequestMapping(value="/{amt}",method=RequestMethod.POST)
	@ResponseBody
	public String pay(@PathVariable int amt) {
		
		JSONObject param =new JSONObject();
		
		param.put("ACCNAME","张三");
		param.put("ACCTYPE","0");
		param.put("ACCNO","6212264100032601308");
		param.put("AMT",amt);
		param.put("BANKBRANCHNAME","104581006015");
		param.put("BANKCITY","深圳市");
		param.put("BANKNAME","招商银行");		
		param.put("BANKPROV","广东省");
		param.put("BANKSETTLENO","305551031025");
		param.put("BUSITYPE","001");
		param.put("CMDID","4097");
		param.put("MEMO","代付");
		param.put("IDCARD","43012619901218123X");
		param.put("MERNO",mmspConfigBean.getMerchno());
		param.put("MOBILE","13688888888");
		String orderno = new SimpleDateFormat("yyyyMMddHHmmss").format(new Date());
		param.put("ORDERNO", orderno);
		param.put("REQTIME", orderno);
		param.put("VERSION","1.0");
		String data = param.toString();

		// 公钥加密
		byte[] encryptedBytes;
		try {
			
			//logger.info(publicKeyStr);
			// 获取公钥
			PublicKey publicKey = MmspPayUtil.getPublicKey(publicKeyStr);
			PublicKey mmspKey = MmspPayUtil.getPublicKey(mmspKeyStr);
			// 获取私钥
			PrivateKey privateKey = MmspPayUtil.getPrivateKey(privateKeyStr);

			logger.info("current charset:" +Charset.defaultCharset().name() );
			
			//测试加解密
			encryptedBytes = MmspPayUtil.encrypt(data.getBytes("UTF-8"), publicKey);
			logger.info("加密后：" + Base64.getEncoder().encodeToString(encryptedBytes));
			// 私钥解密
			byte[] decryptedBytes = MmspPayUtil.decrypt(encryptedBytes, privateKey);
			logger.info("解密后：" + new String(decryptedBytes));
			
			String encryptStr = new String(Base64.getEncoder().encode(MmspPayUtil.encrypt(data.getBytes("UTF-8"), mmspKey)));
			//SHA1withRSA算法进行签名  
            Signature sign = Signature.getInstance("SHA1withRSA");  
            sign.initSign(privateKey);  
            sign.update(data.getBytes("UTF-8"));
            String signature =  new String(Base64.getEncoder().encode(sign.sign()));
			JSONObject postdata = new JSONObject();
			postdata.put("ENCRYPT",encryptStr );
			postdata.put("SIGN", signature);
			
			logger.info(postdata.toString());
			
				
			
			String response  = HttpUtil.submitPost(mmspConfigBean.getPayapi(), postdata.toString(), "UTF-8",
					60000, 60000);
			
			JSONObject retdata = JSONObject.parseObject(response);
			String retCode = retdata.getString("RETCODE");
			logger.info(response);
			logger.info("retCode:"+ retCode);
			if ( retCode.equals("0000") )
			{
				String oriencrypt = retdata.getString("ENCRYPT");
				byte[] bytes= Base64.getDecoder().decode(oriencrypt.getBytes("UTF-8"));
				String decrypt = new String(MmspPayUtil.decrypt(bytes, privateKey));
				logger.info("返回结果解密后：" + decrypt);
				PayableResultBean result = JSONObject.parseObject(decrypt,new TypeReference<PayableResultBean>() {});
				logger.info("返回结果对象：" + result.getDESC());
				
			}else{
				String retmsg = retdata.getString("RETMSG");
				logger.info("RETMSG:" + retmsg);
				return retCode + ": "+ retmsg;
			}
				
			
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		// return result;
		return "success";
	}
	
	@RequestMapping(value="/query",method=RequestMethod.POST)
	@ResponseBody
	public String query() {

		
		JSONObject param =new JSONObject();
		
		String data = "{\"MERNO\":\"085100059691429\",\"CMDID\":\"0x1002\",\"VERSION\":\"1.0\",\"REQTIME\":\"20180301160903\",\"ORDERNO\":\"201803011452198\"}";

		// 公钥加密
		byte[] encryptedBytes;
		try {
			// 获取公钥
			PublicKey publicKey = MmspPayUtil.getPublicKey(publicKeyStr);
			PublicKey mmspKey = MmspPayUtil.getPublicKey(mmspKeyStr);
			// 获取私钥
			PrivateKey privateKey = MmspPayUtil.getPrivateKey(privateKeyStr);
			
			

			String encryptStr = new String(Base64.getEncoder().encode(MmspPayUtil.encrypt(data.getBytes("UTF-8"), mmspKey)));
			//SHA1withRSA算法进行签名  
            Signature sign = Signature.getInstance("SHA1withRSA");  
            sign.initSign(privateKey);  
            sign.update(data.getBytes("UTF-8"));
            String signature =  new String(Base64.getEncoder().encode(sign.sign()));
			JSONObject postdata = new JSONObject();
			postdata.put("ENCRYPT",encryptStr );
			postdata.put("SIGN", signature);
			
			logger.info(postdata.toString());
			
			String response  = HttpUtil.submitPost(mmspConfigBean.getPayapi(), postdata.toString(), "UTF-8",
					60000, 60000);
			
			JSONObject retdata = JSONObject.parseObject(response);
			String retCode = retdata.getString("RETCODE");
			logger.info(response);
			logger.info("retCode:"+ retCode);
			if ( retCode != "0000" ){
				String retmsg = retdata.getString("RETMSG");
				logger.info("RETMSG:" + retmsg);
				return retCode + ": "+ retmsg;
			}
			
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		// return result;
		return "success";
	}

}
