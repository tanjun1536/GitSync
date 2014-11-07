package com.gang.entity.user;

import com.gang.entity.BaseEntity;


public class UserImage
  extends BaseEntity
{
	//~ Instance fields --------------------------------------------------------------------------------------------------------------------------------

	private String descript;
	private String url;

	//~ Methods ----------------------------------------------------------------------------------------------------------------------------------------

	public String getUrl()
	{
		return url;
	}

	public String getDescript()
	{
		return descript;
	}

	public void setDescript(String descript)
	{
		this.descript = descript;
	}

	public void setUrl(String url)
	{
		this.url = url;
	}
}
