package com.mmsp.demo.bean;

import org.springframework.boot.context.properties.ConfigurationProperties;

@ConfigurationProperties(prefix = "mmsp")
public class MmspConfigBean {
	public String getOpenapi() {
		return openapi;
	}
	public void setOpenapi(String openapi) {
		this.openapi = openapi;
	}
	public String getPayapi() {
		return payapi;
	}
	public void setPayapi(String payapi) {
		this.payapi = payapi;
	}
	public String getMerchno() {
		return merchno;
	}
	public void setMerchno(String merchno) {
		this.merchno = merchno;
	}
	public String getTermno() {
		return termno;
	}
	public void setTermno(String termno) {
		this.termno = termno;
	}
	public String getMd5key() {
		return md5key;
	}
	public void setMd5key(String md5key) {
		this.md5key = md5key;
	}
	public String getNotifyurl() {
		return notifyurl;
	}
	public void setNotifyurl(String notifyurl) {
		this.notifyurl = notifyurl;
	}
	public String getJumpurl() {
		return jumpurl;
	}
	public void setJumpurl(String jumpurl) {
		this.jumpurl = jumpurl;
	}

    public String getPaychannel() {
		return paychannel;
	}
	public void setPaychannel(String paychannel) {
		this.paychannel = paychannel;
	}
	private String paychannel;
	private String openapi;
	private String gwapi;
    public String getGwapi() {
		return gwapi;
	}
	public void setGwapi(String gwapi) {
		this.gwapi = gwapi;
	}
	private String payapi;
    private String merchno;
    private String termno;
    private String md5key;
    private String notifyurl;
    private String jumpurl;
    public int getCommandid() {
		return commandid;
	}
	public void setCommandid(int commandid) {
		this.commandid = commandid;
	}
	private int commandid;

}
