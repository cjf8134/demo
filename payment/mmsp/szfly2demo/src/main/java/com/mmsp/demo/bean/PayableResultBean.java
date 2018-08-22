package com.mmsp.demo.bean;

/*
 * RETCODE	结果	string(4)	必须	错误码，具体参见错误码对照表
	RETMSG	结果描述	string(255)	必须	错误信息描述，成功则返回以下数据的加密结果，存入到ENCRYPT字段
	MERNO	商户号	string(20)	必须	MMSP平台分配的商户号
	ORDERNO	商户代付单号	string(14)	必须	商户系统内部的订单号
	BSORDERNO	MMSP平台代付单号	string(14)	必须	MMSP平台代付订单号
	PAYSTATE	该笔代付状态	int	必须	该笔代付状态：1-付款成功，2-付款中，3-付款失败
	DESC	该笔代付状态描述	string	必须	代付状态描述
	RSPTIME	响应时间	string(14)	必须	响应时间，年月日时分秒固定为YYYYMMDDhhmmss
 */
public class PayableResultBean {


	public String getRETCODE() {
		return RETCODE;
	}
	public void setRETCODE(String rETCODE) {
		RETCODE = rETCODE;
	}
	public String getRETMSG() {
		return RETMSG;
	}
	public void setRETMSG(String rETMSG) {
		RETMSG = rETMSG;
	}
	public String getMERNO() {
		return MERNO;
	}
	public void setMERNO(String mERNO) {
		MERNO = mERNO;
	}
	public String getORDERNO() {
		return ORDERNO;
	}
	public void setORDERNO(String oRDERNO) {
		ORDERNO = oRDERNO;
	}
	public String getBSORDERNO() {
		return BSORDERNO;
	}
	public void setBSORDERNO(String bSORDERNO) {
		BSORDERNO = bSORDERNO;
	}
	public String getPAYSTATE() {
		return PAYSTATE;
	}
	public void setPAYSTATE(String pAYSTATE) {
		PAYSTATE = pAYSTATE;
	}
	public String getDESC() {
		return DESC;
	}
	public void setDESC(String dESC) {
		DESC = dESC;
	}
	public String getRSPTIME() {
		return RSPTIME;
	}
	public void setRSPTIME(String rSPTIME) {
		RSPTIME = rSPTIME;
	}
	private String RETCODE;
	private String RETMSG;
	private String MERNO;
	private String ORDERNO;
	private String BSORDERNO;
	private String PAYSTATE;
	private String DESC;
	private String RSPTIME;

}
