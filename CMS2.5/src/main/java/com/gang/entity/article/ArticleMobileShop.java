package com.gang.entity.article;

import java.util.List;
import java.util.Set;


public class ArticleMobileShop
  extends ArticleMobile
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String                            header;
	private String                            city;
	private String                            district;
	private String                            street;
	private String                            building;
	private String                            longitude;
	private String                            latitude;
	private String                            telephone;
	private String                            email;
	private String                            qq;
	private String                            otherContactInfo;
	private String                            description;
	private String                            basicDesc;
	private String                            detailDesc;
	private List<ArticleMobileGoods>          relatedGoods;
	private List<ArticleMobileNews>           relatedNews;
	private List<ArticleMobileShopImageGroup> imagesGroups;
	private List<ArticleMobileShopVideoGroup> videosGroups;
	

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

	public String getCity()
	{
		return city;
	}

	public void setCity(String city)
	{
		this.city = city;
	}

	public String getDistrict()
	{
		return district;
	}

	public void setDistrict(String district)
	{
		this.district = district;
	}

	public String getStreet()
	{
		return street;
	}

	public void setStreet(String street)
	{
		this.street = street;
	}

	public String getBuilding()
	{
		return building;
	}

	public void setBuilding(String building)
	{
		this.building = building;
	}

	public String getLatitude()
	{
		return latitude;
	}

	public String getLongitude()
	{
		return longitude;
	}

	public void setLongitude(String longitude)
	{
		this.longitude = longitude;
	}

	public void setLatitude(String latitude)
	{
		this.latitude = latitude;
	}

	public String getTelephone()
	{
		return telephone;
	}

	public void setTelephone(String telephone)
	{
		this.telephone = telephone;
	}

	public String getEmail()
	{
		return email;
	}

	public void setEmail(String email)
	{
		this.email = email;
	}

	public String getQq()
	{
		return qq;
	}

	public void setQq(String qq)
	{
		this.qq = qq;
	}

	public String getOtherContactInfo()
	{
		return otherContactInfo;
	}

	public void setOtherContactInfo(String otherContactInfo)
	{
		this.otherContactInfo = otherContactInfo;
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

	public List<ArticleMobileShopImageGroup> getImagesGroups()
	{
		return imagesGroups;
	}

	public void setImagesGroups(List<ArticleMobileShopImageGroup> imagesGroups)
	{
		this.imagesGroups = imagesGroups;
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

	public List<ArticleMobileShopVideoGroup> getVideosGroups()
	{
		return videosGroups;
	}

	public void setVideosGroups(List<ArticleMobileShopVideoGroup> videosGroups)
	{
		this.videosGroups = videosGroups;
	}
}
