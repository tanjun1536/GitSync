package com.gang.entity.message;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.ArticleMobile;

import com.google.gson.annotations.Expose;

import java.util.Date;
import java.util.List;


public class Message
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	@Expose
	private String              title;
	@Expose private Date                createDate = new Date();
	private List<ArticleMobile> articles;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getTitle()
	{
		return title;
	}

	public void setTitle(String title)
	{
		this.title = title;
	}

	public Date getCreateDate()
	{
		return createDate;
	}

	public void setCreateDate(Date createDate)
	{
		this.createDate = createDate;
	}

	public List<ArticleMobile> getArticles()
	{
		return articles;
	}

	public void setArticles(List<ArticleMobile> articles)
	{
		this.articles = articles;
	}
}
