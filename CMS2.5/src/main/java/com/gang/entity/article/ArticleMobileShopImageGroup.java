package com.gang.entity.article;

import com.gang.entity.BaseEntity;

import java.util.List;


public class ArticleMobileShopImageGroup
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String                   name;
	private List<ArticleMobileShopImage> images;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


	public List<ArticleMobileShopImage> getImages() {
		return images;
	}

	public void setImages(List<ArticleMobileShopImage> images) {
		this.images = images;
	}

	public String getName()
	{
		return name;
	}

	public void setName(String name)
	{
		this.name = name;
	}

}
