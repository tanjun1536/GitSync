package com.gang.entity.statistics;



public class OfflineClickRate
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String id;
	private String type;
	private String date;
	private String user_id;
	private String active_key;
	private String soft_type;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getId()
	{
		return id;
	}

	public void setId(String id)
	{
		this.id = id;
	}

	public String getType()
	{
		return type;
	}

	public void setType(String type)
	{
		this.type = type;
	}

	public String getDate()
	{
		return date;
	}

	public void setDate(String date)
	{
		this.date = date;
	}

	public String getUser_id()
	{
		return user_id;
	}

	public void setUser_id(String user_id)
	{
		this.user_id = user_id;
	}

	public String getActive_key()
	{
		return active_key;
	}

	public void setActive_key(String active_key)
	{
		this.active_key = active_key;
	}

	public String getSoft_type()
	{
		return soft_type;
	}

	public void setSoft_type(String soft_type)
	{
		this.soft_type = soft_type;
	}
}
