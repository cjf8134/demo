package com.mmsp.demo.bean;

import com.alibaba.fastjson.JSONObject;

public class NotifyBean {
	
	/*
	 * CommandID	integer	必须	消息命令或响应类型
		SeqID	integer	必须	序列id，客户端自增默认值 1
		NodeType	integer	必须	请求类型，填写默认值 3
		NodeID	string(20)	必须	请求编号，填写默认值 openplat，收银机/pos机填写 POS
		Version	string(10)	必须	通信协议版本号，本协议版本号为1.0.0
		AGENTNO	string(8)	条件	代理商编号，机构模式必须 其他模式不传或为空字符串
		MERNO	string(15)	必须	商户号，平台分发
		TERMNO	string(8)	必须	终端号，平台分发
		Attach	binary	可选	附件用于上传文件和图片，不参与签名和加密
		Extends	string(255)	可选	扩展字段，不参与签名和加密
		RetCode	integer	条件	响应码，参考响应码定义，请求包不需要该字段，应答包必须带有该字段
		ErrorMsg	string(255)	条件	响应信息描述，如果RetCode不为1，则服务端需要返回响应描述信息
		Body	string(x)	可选	业务数据包，内容查看下列接口
		Sign	string(255)	可选	签名
	 */
	private String CommandID;
	public String getCommandID() {
		return CommandID;
	}

	public void setCommandID(String commandID) {
		CommandID = commandID;
	}

	public String getSeqID() {
		return SeqID;
	}

	public void setSeqID(String seqID) {
		SeqID = seqID;
	}

	public String getNodeType() {
		return NodeType;
	}

	public void setNodeType(String nodeType) {
		NodeType = nodeType;
	}

	public String getNodeID() {
		return NodeID;
	}

	public void setNodeID(String nodeID) {
		NodeID = nodeID;
	}

	public String getVersion() {
		return Version;
	}

	public void setVersion(String version) {
		Version = version;
	}

	public String getAGENTNO() {
		return AGENTNO;
	}

	public void setAGENTNO(String aGENTNO) {
		AGENTNO = aGENTNO;
	}

	public String getMERNO() {
		return MERNO;
	}

	public void setMERNO(String mERNO) {
		MERNO = mERNO;
	}

	public String getTERMNO() {
		return TERMNO;
	}

	public void setTERMNO(String tERMNO) {
		TERMNO = tERMNO;
	}

	public String getRetCode() {
		return RetCode;
	}

	public void setRetCode(String retCode) {
		RetCode = retCode;
	}

	public String getErrorMsg() {
		return ErrorMsg;
	}

	public void setErrorMsg(String errorMsg) {
		ErrorMsg = errorMsg;
	}

	public String getSign() {
		return Sign;
	}

	public void setSign(String sign) {
		Sign = sign;
	}

	public JSONObject getBody() {
		return Body;
	}

	public void setBody(JSONObject body) {
		Body = body;
	}

	private String SeqID;
	private String NodeType;
	private String NodeID;
	private String Version;
	private String AGENTNO;
	private String MERNO;
	private String TERMNO;
	private String RetCode;
	private String ErrorMsg;
	private String Sign;
	
	private JSONObject Body;
	

}
