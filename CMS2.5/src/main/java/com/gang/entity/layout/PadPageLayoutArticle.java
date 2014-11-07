package com.gang.entity.layout;

import com.gang.entity.BaseEntity;


public class PadPageLayoutArticle
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private Integer       article;
	private PadPageLayout layout;
	private String        section;
	private String        title;
	private String        type;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public Integer getArticle()
	{
		return article;
	}

	public PadPageLayout getLayout()
	{
		return layout;
	}

	public String getSection()
	{
		return section;
	}

	public String getTitle()
	{
		return title;
	}

	public String getType()
	{
		return type;
	}

	public void setArticle(Integer article)
	{
		this.article = article;
	}

	public void setLayout(PadPageLayout layout)
	{
		this.layout = layout;
	}

	public void setSection(String section)
	{
		this.section = section;
	}

	public void setTitle(String title)
	{
		this.title = title;
	}

	public void setType(String type)
	{
		this.type = type;
	}
}
