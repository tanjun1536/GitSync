package com.gang.entity.article;

import com.gang.entity.BaseEntity;
import com.gang.entity.comment.ArticleMobileComment;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.template.Template;

import com.google.gson.annotations.Expose;

import java.util.Date;
import java.util.List;
import java.util.Set;


public class Article
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	@Expose
	private Integer                      browseCount;
	private Set<ArticleMobileComment>    comments;
	private String                       content;
	private String                       contentLink;
	@Expose
	private Date                         createDate = new Date();
	private Date                         distributeDate = new Date();
	private String                       domain;
	private String                       editor;
	private String                       focusImage;
	@Expose
	private Boolean                      isHot = false;
	private String                       keywords;
	@Expose
	private Section                      section;
	private String                       sender;
	private String                       source;
	@Expose
	private State                        state;
	private String                       subTitle;
	private String                       summary;
	private Template                     template;
	@Expose
	private ArticleMobileTemplate        contentTemplate;
	@Expose
	private String                       title;
	@Expose
	private String                       titleImage;
	private Date                         topDate = new Date();
	private Integer                      articleType;
	private ArticleMobileShowType        contentShowType;
	private ArticleMobileType            contentType;
	private Integer                      version = 0;
	private List<ArticleMobile>          relatedArticles;

	//~ Constructors ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public Article()
	{
		super();
	}

	public Article(Integer id)
	{
		super(id);
	}

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public List<ArticleMobile> getRelatedArticles()
	{
		return relatedArticles;
	}

	public void setRelatedArticles(List<ArticleMobile> relatedArticles)
	{
		this.relatedArticles = relatedArticles;
	}

	public ArticleMobileType getContentType()
	{
		return contentType;
	}

	public void setContentType(ArticleMobileType contentType)
	{
		this.contentType = contentType;
	}

	public Integer getVersion()
	{
		return version;
	}

	public void setVersion(Integer version)
	{
		this.version = version;
	}

	public Integer getArticleType()
	{
		return articleType;
	}

	public ArticleMobileShowType getContentShowType()
	{
		return contentShowType;
	}

	public void setContentShowType(ArticleMobileShowType contentShowType)
	{
		this.contentShowType = contentShowType;
	}

	public void setArticleType(Integer articleType)
	{
		this.articleType = articleType;
	}

	public ArticleMobileTemplate getContentTemplate()
	{
		return contentTemplate;
	}

	public void setContentTemplate(ArticleMobileTemplate contentTemplate)
	{
		this.contentTemplate = contentTemplate;
	}

	public Integer getBrowseCount()
	{
		return (browseCount == null) ? 0 : browseCount;
	}

	public String getContent()
	{
		return content;
	}

	public Set<ArticleMobileComment> getComments()
	{
		return comments;
	}

	public void setComments(Set<ArticleMobileComment> comments)
	{
		this.comments = comments;
	}

	public String getContentLink()
	{
		if (domain != null)
		{
			return domain + contentLink;
		}

		return contentLink;
	}

	public Date getCreateDate()
	{
		return createDate;
	}

	public Date getDistributeDate()
	{
		return distributeDate;
	}

	public String getDomain()
	{
		return domain;
	}

	public String getEditor()
	{
		return editor;
	}

	public String getFocusImage()
	{
		if (domain != null)
		{
			return domain + focusImage;
		}

		return focusImage;
	}

	public Boolean getIsHot()
	{
		return isHot;
	}

	public String getKeywords()
	{
		return keywords;
	}

	public Section getSection()
	{
		return section;
	}

	public String getSender()
	{
		return sender;
	}

	public String getSource()
	{
		return source;
	}

	public State getState()
	{
		return state;
	}

	public String getSubTitle()
	{
		return subTitle;
	}

	public String getSummary()
	{
		return summary;
	}

	public Template getTemplate()
	{
		return template;
	}

	public String getTitle()
	{
		return title;
	}

	public String getTitleImage()
	{
		if (domain != null)
		{
			return domain + titleImage;
		}

		return titleImage;
	}

	public Date getTopDate()
	{
		return topDate;
	}

	public void setBrowseCount(Integer browseCount)
	{
		this.browseCount = browseCount;
	}

	public void setContent(String content)
	{
		this.content = content;
	}

	public void setContentLink(String contentLink)
	{
		this.contentLink = contentLink;
	}

	public void setCreateDate(Date createDate)
	{
		this.createDate = createDate;
	}

	public void setDistributeDate(Date distributeDate)
	{
		this.distributeDate = distributeDate;
	}

	public void setDomain(String domain)
	{
		this.domain = domain;
	}

	public void setEditor(String editor)
	{
		this.editor = editor;
	}

	public void setFocusImage(String focusImage)
	{
		this.focusImage = focusImage;
	}

	public void setIsHot(Boolean isHot)
	{
		this.isHot = isHot;
	}

	public void setKeywords(String keywords)
	{
		this.keywords = keywords;
	}

	public void setSection(Section section)
	{
		this.section = section;
	}

	public void setSender(String sender)
	{
		this.sender = sender;
	}

	public void setSource(String source)
	{
		this.source = source;
	}

	public void setState(State state)
	{
		this.state = state;
	}

	public void setSubTitle(String subTitle)
	{
		this.subTitle = subTitle;
	}

	public void setSummary(String summary)
	{
		this.summary = summary;
	}

	public void setTemplate(Template template)
	{
		this.template = template;
	}

	public void setTitle(String title)
	{
		this.title = title;
	}

	public void setTitleImage(String titleImage)
	{
		this.titleImage = titleImage;
	}

	public void setTopDate(Date topDate)
	{
		this.topDate = topDate;
	}
}
