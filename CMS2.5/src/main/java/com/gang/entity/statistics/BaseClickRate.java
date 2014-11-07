package com.gang.entity.statistics;

import java.util.Date;

import com.gang.comms.BaseTypeHelper;
import com.gang.entity.BaseEntity;


public class BaseClickRate
  extends BaseEntity
{
	public BaseClickRate()
	{
		
	}
	public BaseClickRate(OfflineClickRate oc)
	{
		this.setClickId(BaseTypeHelper.getInteger(oc.getId()));
		this.setActiveKey(oc.getActive_key());
		this.setClickUser(BaseTypeHelper.getInteger(oc.getUser_id()));
		this.setClickDateTime(BaseTypeHelper.getDate(oc.getDate()));
		this.setDeviceType(oc.getSoft_type());
	}
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	private Integer clickId;
	private String  deviceType;
	private Date    clickDateTime=new Date();
	private String  activeKey;
	private Integer clickUser;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public Integer getClickId()
	{
		return clickId;
	}

	public void setClickId(Integer clickId)
	{
		this.clickId = clickId;
	}

	public String getDeviceType()
	{
		return deviceType;
	}

	public void setDeviceType(String deviceType)
	{
		this.deviceType = deviceType;
	}

	public Date getClickDateTime()
	{
		return clickDateTime;
	}

	public void setClickDateTime(Date clickDateTime)
	{
		this.clickDateTime = clickDateTime;
	}

	public String getActiveKey()
	{
		return activeKey;
	}

	public void setActiveKey(String activeKey)
	{
		this.activeKey = activeKey;
	}

	public Integer getClickUser()
	{
		return clickUser;
	}

	public void setClickUser(Integer clickUser)
	{
		this.clickUser = clickUser;
	}
}
