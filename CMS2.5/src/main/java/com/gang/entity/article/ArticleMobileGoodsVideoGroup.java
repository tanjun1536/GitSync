package com.gang.entity.article;

import com.gang.entity.BaseEntity;

import java.util.List;


public class ArticleMobileGoodsVideoGroup
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String                        name;
	private List<ArticleMobileGoodsVideo> videos;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getName()
	{
		return name;
	}

	public List<ArticleMobileGoodsVideo> getVideos()
	{
		return videos;
	}

	public void setVideos(List<ArticleMobileGoodsVideo> videos)
	{
		this.videos = videos;
	}

	public void setName(String name)
	{
		this.name = name;
	}
}
