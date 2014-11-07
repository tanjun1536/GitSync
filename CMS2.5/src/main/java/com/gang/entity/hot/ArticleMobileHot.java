package com.gang.entity.hot;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;


public class ArticleMobileHot
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	@Expose
	private Integer id;
	public Integer getId() {
		return id;
	}


	public void setId(Integer id) {
		this.id = id;
	}

   
	public Integer getOrderNumber() {
		return orderNumber;
	}


	public void setOrderNumber(Integer orderNumber) {
		this.orderNumber = orderNumber;
	}


	private Integer orderNumber;
	private Integer articleId;
	@Expose private String title;
	@Expose private Date createDate;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


	public Date getCreateDate() {
		return createDate;
	}


	public void setCreateDate(Date createDate) {
		this.createDate = createDate;
	}


	public String getTitle()
	{
		return title;
	}


	public Integer getArticleId() {
		return articleId;
	}


	public void setArticleId(Integer articleId) {
		this.articleId = articleId;
	}


	public void setTitle(String title)
	{
		this.title = title;
	}
}
