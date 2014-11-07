package com.gang.entity.statistics;

import java.util.Date;

import com.gang.entity.BaseEntity;

public class ClickRateDetail extends BaseEntity {
	public String getTitle() {
		return title;
	}

	public void setTitle(String title) {
		this.title = title;
	}

	public String getUserName() {
		return userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getDeviceType() {
		return deviceType;
	}

	public void setDeviceType(String deviceType) {
		this.deviceType = deviceType;
	}

	public Date getClickDateTime() {
		return clickDateTime;
	}

	public void setClickDateTime(Date clickDateTime) {
		this.clickDateTime = clickDateTime;
	}

	public String getActiveKey() {
		return activeKey;
	}

	public void setActiveKey(String activeKey) {
		this.activeKey = activeKey;
	}

	private String title;
	private String userName;
	private String deviceType;
	private Date clickDateTime;
	private String activeKey;
}
