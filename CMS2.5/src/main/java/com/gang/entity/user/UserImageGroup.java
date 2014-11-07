package com.gang.entity.user;

import com.gang.entity.BaseEntity;

import java.util.List;


public class UserImageGroup
  extends BaseEntity
{
	//~ Instance fields --------------------------------------------------------------------------------------------------------------------------------

	private String          groupName;
	private List<UserImage> images;

	//~ Methods ----------------------------------------------------------------------------------------------------------------------------------------

	public String getGroupName()
	{
		return groupName;
	}

	public List<UserImage> getImages()
	{
		return images;
	}

	public void setGroupName(String groupName)
	{
		this.groupName = groupName;
	}

	public void setImages(List<UserImage> images)
	{
		this.images = images;
	}
}
