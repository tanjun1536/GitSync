package com.gang.entity.user;

import com.gang.entity.BaseEntity;

import java.util.Date;


public class UserTrack
  extends BaseEntity
{
	//~ Instance fields --------------------------------------------------------------------------------------------------------------------------------

	private User   user;
	private Date   recordDate;
	private Number longitude;
	private Number latitude;

	//~ Methods ----------------------------------------------------------------------------------------------------------------------------------------

	public User getUser()
	{
		return user;
	}

	public void setUser(User user)
	{
		this.user = user;
	}

	public Date getRecordDate()
	{
		return recordDate;
	}

	public void setRecordDate(Date recordDate)
	{
		this.recordDate = recordDate;
	}

	public Number getLongitude()
	{
		return longitude;
	}

	public void setLongitude(Number longitude)
	{
		this.longitude = longitude;
	}

	public Number getLatitude()
	{
		return latitude;
	}

	public void setLatitude(Number latitude)
	{
		this.latitude = latitude;
	}
}
