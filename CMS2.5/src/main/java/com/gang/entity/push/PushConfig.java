package com.gang.entity.push;

import com.gang.entity.BaseEntity;

public class PushConfig extends BaseEntity {
	private String apiKey;
	private String secretKey;
	private String pushPwd;
	public String getPushPwd() {
		return pushPwd;
	}
	public void setPushPwd(String pushPwd) {
		this.pushPwd = pushPwd;
	}
	private Integer deployStatus;
	public Integer getDeployStatus() {
		return deployStatus;
	}
	public void setDeployStatus(Integer deployStatus) {
		this.deployStatus = deployStatus;
	}
	public String getApiKey() {
		return apiKey;
	}
	public void setApiKey(String apiKey) {
		this.apiKey = apiKey;
	}
	public String getSecretKey() {
		return secretKey;
	}
	public void setSecretKey(String secretKey) {
		this.secretKey = secretKey;
	}
	
}
