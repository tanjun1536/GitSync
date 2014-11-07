package com.gang.entity.article;

import com.gang.entity.BaseEntity;

import com.google.gson.annotations.Expose;

import java.util.Set;


public class ArticleMobileTemplate
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String                     addTemplate;
	private String                     auditTemplate;
	private String                     editTemplate;
	@Expose
	private String                     entityName;
	private String                     name;
	private Integer                    templateType;
	private String                     viewTemplate;
	private String                     action;
	private String                     script;
	private String                     code;
	private Boolean                    shown;
	private Set<ArticleMobileShowType> showTypes;
	private String                     showTypeText;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getShowTypeText()
	{
		return showTypeText;
	}

	public void setShowTypeText(String showTypeText)
	{
		this.showTypeText = showTypeText;
	}

	public Boolean getShown()
	{
		return shown;
	}

	public void setShown(Boolean shown)
	{
		this.shown = shown;
	}

	public Set<ArticleMobileShowType> getShowTypes()
	{
		return showTypes;
	}

	public void setShowTypes(Set<ArticleMobileShowType> showTypes)
	{
		this.showTypes = showTypes;
	}

	public String getCode()
	{
		return code;
	}

	public void setCode(String code)
	{
		this.code = code;
	}

	public String getScript()
	{
		return script;
	}

	public void setScript(String script)
	{
		this.script = script;
	}

	public String getAction()
	{
		return action;
	}

	public void setAction(String action)
	{
		this.action = action;
	}

	public String getAddTemplate()
	{
		return addTemplate;
	}

	public String getAuditTemplate()
	{
		return auditTemplate;
	}

	public String getEditTemplate()
	{
		return editTemplate;
	}

	public String getEntityName()
	{
		return entityName;
	}

	public String getName()
	{
		return name;
	}

	public Integer getTemplateType()
	{
		return templateType;
	}

	public String getViewTemplate()
	{
		return viewTemplate;
	}

	public void setAddTemplate(String addTemplate)
	{
		this.addTemplate = addTemplate;
	}

	public void setAuditTemplate(String auditTemplate)
	{
		this.auditTemplate = auditTemplate;
	}

	public void setEditTemplate(String editTemplate)
	{
		this.editTemplate = editTemplate;
	}

	public void setEntityName(String entityName)
	{
		this.entityName = entityName;
	}

	public void setName(String name)
	{
		this.name = name;
	}

	public void setTemplateType(Integer templateType)
	{
		this.templateType = templateType;
	}

	public void setViewTemplate(String viewTemplate)
	{
		this.viewTemplate = viewTemplate;
	}
}
