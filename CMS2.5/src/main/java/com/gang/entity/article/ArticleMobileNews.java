package com.gang.entity.article;

public class ArticleMobileNews
  extends ArticleMobile
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String content;
	
	private Integer textType;
	
	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public Integer getTextType() {
		return textType;
	}

	public void setTextType(Integer textType) {
		this.textType = textType;
	}

	public String getContent()
	{
		return content;
	}

	public void setContent(String content)
	{
		this.content = content;
	}
	
}
