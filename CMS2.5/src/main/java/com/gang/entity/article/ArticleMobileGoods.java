package com.gang.entity.article;

import java.util.List;
import java.util.Set;


public class ArticleMobileGoods
  extends ArticleMobile
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String                             header;
	private String                             description;
	private String                             basicDesc;
	private String                             detailDesc;
	private List<ArticleMobileGoodsImageGroup> imagesGroups;
	private List<ArticleMobileGoodsVideoGroup> videosGroups;
	private List<ArticleMobileGoods>           relatedGoods;
	private List<ArticleMobileNews>            relatedNews;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getDescription()
	{
		return description;
	}

	public void setDescription(String description)
	{
		this.description = description;
	}

	public String getHeader()
	{
		return header;
	}

	public void setHeader(String header)
	{
		this.header = header;
	}

	public String getBasicDesc()
	{
		return basicDesc;
	}

	public void setBasicDesc(String basicDesc)
	{
		this.basicDesc = basicDesc;
	}

	public String getDetailDesc()
	{
		return detailDesc;
	}

	public void setDetailDesc(String detailDesc)
	{
		this.detailDesc = detailDesc;
	}

	public List<ArticleMobileGoodsImageGroup> getImagesGroups()
	{
		return imagesGroups;
	}

	public void setImagesGroups(List<ArticleMobileGoodsImageGroup> imagesGroups)
	{
		this.imagesGroups = imagesGroups;
	}

	public List<ArticleMobileGoodsVideoGroup> getVideosGroups()
	{
		return videosGroups;
	}

	public List<ArticleMobileGoods> getRelatedGoods()
	{
		return relatedGoods;
	}

	public void setRelatedGoods(List<ArticleMobileGoods> relatedGoods)
	{
		this.relatedGoods = relatedGoods;
	}

	public List<ArticleMobileNews> getRelatedNews()
	{
		return relatedNews;
	}

	public void setRelatedNews(List<ArticleMobileNews> relatedNews)
	{
		this.relatedNews = relatedNews;
	}

	public void setVideosGroups(List<ArticleMobileGoodsVideoGroup> videosGroups)
	{
		this.videosGroups = videosGroups;
	}
}
