package com.gang.entity.log;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.gang.entity.user.BackUser;
import com.google.gson.annotations.Expose;

public class StateLog extends BaseEntity{
	/**
	 * 手机文章
	 */
	public static final Integer Mobile_Article = 1;
	/**
	 * 平板文章
	 */
	public static final Integer Pad_Article = 2;
	
	//操作时间
	@Expose private Date date;
	//操作人
	@Expose private BackUser user;
	//状态名称
	@Expose private String stateName;
	//状态ID
	@Expose private Integer stateId;
	//类型
	@Expose private Integer logType;
	//数据ID
	@Expose private Integer dataId;
	public Integer getDataId() {
		return dataId;
	}
	public void setDataId(Integer dataId) {
		this.dataId = dataId;
	}
	public void setStateId(Integer stateId) {
		this.stateId = stateId;
	}
	public Date getDate() {
		return date;
	}
	public void setDate(Date date) {
		this.date = date;
	}
	public BackUser getUser() {
		return user;
	}
	public void setUser(BackUser user) {
		this.user = user;
	}
	public String getStateName() {
		return stateName;
	}
	public void setStateName(String stateName) {
		this.stateName = stateName;
	}
	public Integer getLogType() {
		return logType;
	}
	public void setLogType(Integer logType) {
		this.logType = logType;
	}
	public Integer getStateId() {
		return stateId;
	}
}
