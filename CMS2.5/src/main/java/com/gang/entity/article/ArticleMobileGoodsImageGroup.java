package com.gang.entity.article;

import com.gang.entity.BaseEntity;

import java.util.List;


public class ArticleMobileGoodsImageGroup
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String                        name;
	private List<ArticleMobileGoodsImage> images;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getName()
	{
		return name;
	}

	public void setName(String name)
	{
		this.name = name;
	}

	public List<ArticleMobileGoodsImage> getImages()
	{
		return images;
	}

	public void setImages(List<ArticleMobileGoodsImage> images)
	{
		this.images = images;
	}
}
