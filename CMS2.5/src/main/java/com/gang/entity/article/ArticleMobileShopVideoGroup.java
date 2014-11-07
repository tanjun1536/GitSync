package com.gang.entity.article;

import com.gang.entity.BaseEntity;

import java.util.List;


public class ArticleMobileShopVideoGroup
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String                       name;
	private List<ArticleMobileShopVideo> videos;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getName()
	{
		return name;
	}

	public List<ArticleMobileShopVideo> getVideos()
	{
		return videos;
	}

	public void setVideos(List<ArticleMobileShopVideo> videos)
	{
		this.videos = videos;
	}

	public void setName(String name)
	{
		this.name = name;
	}
}
