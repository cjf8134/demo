package com.mmsp.demo;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.InetSocketAddress;
import java.net.Proxy;
import java.util.Enumeration;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Set;

import javax.servlet.http.HttpServletRequest;

public class HttpUtil {

	/**
	 * 描述:获取请求头内容
	 */
	public static String GetHeadersInfo(HttpServletRequest request) {
		Map<String, String> map = new HashMap<String, String>();
		Enumeration headerNames = request.getHeaderNames();
		while (headerNames.hasMoreElements()) {
			String key = (String) headerNames.nextElement();
			String value = request.getHeader(key);
			map.put(key, value);
		}

		String result = "";
		for (String key : map.keySet()) {
			// System.out.println("key= "+ key + " and value= " + map.get(key));
			result = result + "key= " + key + " and value= " + map.get(key) + "\n";
		}
		return result;
	}

	public static String submitPost(String url, String paramContent, String charSet, int connTimeOut, int soTimeOut) {
		StringBuffer message = null;
		java.net.URLConnection connection = null;
		java.net.URL reqUrl = null;
		OutputStreamWriter reqOut = null;
		InputStream in = null;
		BufferedReader br = null;
		String param = paramContent;
		String identifier = System.currentTimeMillis() + "";
		if (null == charSet || "".equals(charSet)) {
			charSet = "GBK";
		}
		try {
			message = new StringBuffer();// 创建对象接收响应信息
			reqUrl = new java.net.URL(url);			
			connection = reqUrl.openConnection();// 创建连接
			connection.setReadTimeout(soTimeOut);// 设置读取数据超时时间
			connection.setConnectTimeout(connTimeOut);// 设置连接地址超时时间
			connection.setDoOutput(true);// 使用post方式的时候，需要使用 URL
											// 连接进行输出，所以设定为true
			reqOut = new OutputStreamWriter(connection.getOutputStream(), charSet);
			reqOut.write(param);// 将参数信息添加到输出流中
			reqOut.flush();// 刷新该流的缓冲
			int charCount = -1;
			in = connection.getInputStream();
			br = new BufferedReader(new InputStreamReader(in, charSet));// 设定收取响应字符的编码格式
			while ((charCount = br.read()) != -1) {
				message.append((char) charCount);// 将响应信息添加到message对象中
			}
		} catch (Exception ex) {
			ex.printStackTrace();
			return "EXCEPTION";
		} finally {
			try {
				// 关闭打开的输入流和输出流
				in.close();
				reqOut.close();
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		return message.toString();
	}

	public static String GetRequestPayload(HttpServletRequest req) {  
        StringBuilder sb = new StringBuilder();  
        try(BufferedReader reader = req.getReader();) {  
                 char[]buff = new char[1024];  
                 int len;  
                 while((len = reader.read(buff)) != -1) {  
                          sb.append(buff,0, len);  
                 }  
        }catch (IOException e) {  
                 e.printStackTrace();  
        }  
        return sb.toString();  
}

	@SuppressWarnings("rawtypes")
	public static String GetParameterMap(HttpServletRequest request) {
		Map map = request.getParameterMap();
		String text = "";
		if (map != null) {
			Set set = map.entrySet();
			Iterator iterator = set.iterator();
			while (iterator.hasNext()) {
				Map.Entry entry = (Entry) iterator.next();
				if (entry.getValue() instanceof String[]) {

					String key = (String) entry.getKey();
					if (key != null && !"id".equals(key) && key.startsWith("[") && key.endsWith("]")) {
						text = (String) entry.getKey();
						break;
					}
					String[] values = (String[]) entry.getValue();
					for (int i = 0; i < values.length; i++) {
						// logger.info("==B==entry的value: " + values[i]);
						key += "=" + values[i];
					}
					if (key.startsWith("[") && key.endsWith("]")) {
						text = (String) entry.getKey();
						break;
					}
				} else if (entry.getValue() instanceof String) {
					// logger.info("==========entry的key： " + entry.getKey());
					// logger.info("==========entry的value: " +
					// entry.getValue());
				}
			}
		}
		return text;
	}

}
