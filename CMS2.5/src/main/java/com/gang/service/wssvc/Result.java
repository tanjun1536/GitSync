package com.gang.service.wssvc;

public class Result {
	
	private String id;
	private String msg;
	private String nickName;
	private String ret;
	public String getId() {
		return id;
	}
	public String getMsg() {
		return msg;
	}
	
	public String getNickName() {
		return nickName;
	}
	public String getRet() {
		return ret;
	}
	public void setId(String id) {
		this.id = id;
	}
	public void setMsg(String msg) {
		this.msg = msg;
	}
	public void setNickName(String nickName) {
		this.nickName = nickName;
	}
	public void setRet(String ret) {
		this.ret = ret;
	}
}
