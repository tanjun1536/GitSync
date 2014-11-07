package com.gang.action.layout;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;

import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;

import com.gang.entity.article.Article;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.imagecontent.PadImageContent;
import com.gang.entity.layout.PadPageLayout;
import com.gang.entity.layout.PadPageLayoutArticle;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.template.Template;

import com.gang.service.layout.PadPageLayoutService;
import com.gang.service.template.TemplateService;

import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;

import java.util.ArrayList;
import java.util.List;
import java.util.Set;

import javax.servlet.http.HttpServletRequest;


public class PadPageLayoutAction
  extends DefaultAction
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private PadPageLayout        layout;
	private PadPageLayoutService service;
	private TemplateService      templateService;
	private String               articles;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getArticles()
	{
		return articles;
	}

	public void setArticles(String articles)
	{
		this.articles = articles;
	}

	@Override
	public void add(HttpServletRequest req)
		throws Exception
	{
		List<Template> templates = templateService.getPadListTemplates ();
		req.setAttribute ("templates", templates);
	}

	@Override
	public void ajaxDelete()
		throws Exception
	{
		Integer id = getId ();

		try
		{
			service.deleteObject (PadPageLayout.class, id);
			Write (OK);
		}
		catch (Exception e)
		{
			e.printStackTrace ();
			Write (NO);
		}
	}

	@Override
	public void edit(
	  Integer            id,
	  HttpServletRequest req)
		throws Exception
	{
		PadPageLayout pdl = service.get (PadPageLayout.class, id);
		req.setAttribute ("layout", pdl);

		List<Template> templates = templateService.getPadListTemplates ();
		req.setAttribute ("templates", templates);
	}

	public PadPageLayout getLayout()
	{
		return layout;
	}

	@Override
	public void getList()
		throws Exception
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer(" SELECT count(p) FROM PadPageLayout p  WHERE (1=1)");
		StringBuffer    dsql = new StringBuffer(" SELECT p FROM PadPageLayout p WHERE (1=1)");
		String          section = getString ("section");
		String          state = getString ("state");
		gr.setHsql (true);
		gr.setTableAlias ("p");

		StringBuffer sb = new StringBuffer();

		if (StringHelper.isNotBlank (section))
		{
			sb.append (" AND p.section=")
			  .append (section);
		}

		if (StringHelper.isNotBlank (state))
		{
			sb.append (" AND p.state=")
			  .append (state);
		}

		gr.setCsql (csql.append (sb).toString ());
		gr.setDsql (dsql.append (sb).toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public PadPageLayoutService getService()
	{
		return service;
	}

	public TemplateService getTemplateService()
	{
		return templateService;
	}

	@Override
	public void doSave()
		throws Exception
	{
		String                    json = getArticles ();
		Type                      typeOf = new TypeToken<Set<PadPageLayoutArticle>>()
				{
				}.getType ();
		Set<PadPageLayoutArticle> sets = JSONHelper.Deserialize (json, typeOf);
		layout.setArticles (sets);
		service.save (layout);
	}

	public void setLayout(PadPageLayout layout)
	{
		this.layout = layout;
	}

	public void setService(PadPageLayoutService service)
	{
		this.service = service;
	}

	public void setTemplateService(TemplateService templateService)
	{
		this.templateService = templateService;
	}

	public void getArticleMobilePrepareDistribute()
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer(" SELECT count(m) FROM ArticleMobile m  WHERE m.state.next is null and m.state.prev is not null and m.state.nodeType=" + State.TYPE_ARTICLE_PAD);
		StringBuffer    dsql = new StringBuffer(" SELECT m FROM ArticleMobile m WHERE m.state.next is null and m.state.prev is not null and m.state.nodeType=" + State.TYPE_ARTICLE_PAD);
		gr.setHsql (true);
		gr.setTableAlias ("m");

		StringBuffer sb = new StringBuffer();
		gr.setCsql (csql.append (sb).toString ());
		gr.setDsql (dsql.append (sb).toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void getLayoutArticle()
	{
		GridPageResponse gpr = service.getGridPage (service.getLayoutArticles (getId ()));
		Write (JSONHelper.Serialize (gpr));
	}

	public void OffLinePadPage()
	{
		try
		{
			Integer id = getId ();
			service.OffLinePadPage (id);
			Write (OK);
		}
		catch (Exception e)
		{
			Write (NO);
		}
	}

	public void getPrepareDistributePages()
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer(" SELECT count(p) FROM PadPageLayout p  WHERE (1=1)");
		StringBuffer    dsql = new StringBuffer(" SELECT p FROM PadPageLayout p WHERE (1=1)");
		String          section = getString ("sectionId");
		String          state = "0";
		gr.setHsql (true);
		gr.setTableAlias ("p");

		StringBuffer sb = new StringBuffer();

		if (StringHelper.isNotBlank (section))
		{
			sb.append (" AND p.section=")
			  .append (section);
		}

		if (StringHelper.isNotBlank (state))
		{
			sb.append (" AND p.state=")
			  .append (state);
		}

		gr.setCsql (csql.append (sb).toString ());
		gr.setDsql (dsql.append (sb.append (" order by p.createDate desc")).toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void getOnlinePadPages()
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer(" SELECT count(p) FROM PadPageLayout p  WHERE  p.state = 1");
		StringBuffer    dsql = new StringBuffer(" SELECT p FROM PadPageLayout p WHERE p.state = 1");
		String          section = getString ("sectionId");
		gr.setHsql (true);
		gr.setTableAlias ("p");

		StringBuffer sb = new StringBuffer();

		if (StringHelper.isNotBlank (section))
		{
			sb.append (" AND p.section=")
			  .append (section);
		}

		gr.setCsql (csql.append (sb).toString ());
		gr.setDsql (dsql.append (sb.append (" order by p.createDate desc")).toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void getOfflinePadPages()
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer(" SELECT count(p) FROM PadPageLayout p  WHERE  p.state = -1");
		StringBuffer    dsql = new StringBuffer(" SELECT p FROM PadPageLayout p WHERE   p.state = -1");
		String          section = getString ("sectionId");
		gr.setHsql (true);
		gr.setTableAlias ("p");

		StringBuffer sb = new StringBuffer();

		if (StringHelper.isNotBlank (section))
		{
			sb.append (" AND p.section=")
			  .append (section);
		}

		gr.setCsql (csql.append (sb).toString ());
		gr.setDsql (dsql.append (sb.append (" order by p.createDate desc")).toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}
}
