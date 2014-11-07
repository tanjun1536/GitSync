package com.gang.entity.statistics;

import com.gang.entity.BaseEntity;


public class ActiveUser
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String               userName;
	private java.math.BigInteger activityTimes;
	private String               sex;
	private String               activeKey;
	private String               activityType;
	private String 				 deviceType;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getDeviceType() {
		return deviceType;
	}

	public void setDeviceType(String deviceType) {
		this.deviceType = deviceType;
	}

	public String getUserName()
	{
		return userName;
	}

	public void setUserName(String userName)
	{
		this.userName = userName;
	}

	public java.math.BigInteger getActivityTimes()
	{
		return activityTimes;
	}

	public void setActivityTimes(java.math.BigInteger activityTimes)
	{
		this.activityTimes = activityTimes;
	}

	public String getSex()
	{
		return sex;
	}

	public void setSex(String sex)
	{
		this.sex = sex;
	}

	public String getActiveKey()
	{
		return activeKey;
	}

	public void setActiveKey(String activeKey)
	{
		this.activeKey = activeKey;
	}

	public String getActivityType()
	{
		return activityType;
	}

	public void setActivityType(String activityType)
	{
		this.activityType = activityType;
	}
}
