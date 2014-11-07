package com.gang.action.article;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.script.ScriptException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import com.gang.action.DefaultAction;
import com.gang.comms.CollectionHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.HibernateUpdateCollectionKiller;
import com.gang.comms.JSONHelper;
import com.gang.comms.LazyKiller;
import com.gang.comms.StringHelper;
import com.gang.entity.article.Article;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.article.ArticleMobileGoodsImageGroup;
import com.gang.entity.article.ArticleMobileGoodsVideoGroup;
import com.gang.entity.article.ArticleMobileTemplate;
import com.gang.entity.article.ArticleMobileType;
import com.gang.entity.imagecontent.ImageContent;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.template.Template;
import com.gang.service.article.ArticleService;
import com.gang.service.template.TemplateService;
import com.opensymphony.xwork2.ModelDriven;


public class ArticleMobileAction
  extends DefaultAction
  implements ModelDriven<ArticleMobile>
{
	//~ Static fields/initializers -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private static final String TEMPLATES_SESSION_KEY = "TEMPLATES";
	private static final String SHOWTPYES_SESSION_KEY = "SHOWTYPES";

	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private ArticleMobile   article;
	private ArticleService  service;
	private TemplateService templateService;

	//~ Constructors ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public ArticleMobileAction()
	{
		super();
		this.setEntityClass (ArticleMobile.class);
	}

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private List<ArticleMobileTemplate> getArticleMobileTemplate()
		throws ScriptException
	{
		HttpSession                 session = getSession ();
		List<ArticleMobileTemplate> Temps = (List<ArticleMobileTemplate>) session.getAttribute (TEMPLATES_SESSION_KEY);

		if (Temps == null)
		{
			Temps = service.getList (ArticleMobileTemplate.class,"shown",true);

			List<State>         states = service.getStates (State.TYPE_ARTICLE_MOBILE);
			Map<String, Object> entities = new HashMap<String, Object>();
			entities.put ("states", states);

			for (ArticleMobileTemplate amt : Temps)
			{
				String template = filterFreeMarkerScript (amt.getAddTemplate (), entities);
				template   = template.replace ("\"", "\\\"");
				template   = template.replace ("\r\n", "");
				amt.setAddTemplate (template);
				amt.setShowTypeText(JSONHelper.Serialize(amt.getShowTypes()));
			}
		}

		return Temps;
	}

	public void ajaxBatchDelete()
		throws Exception
	{
		String ids = getString ("ids");

		try
		{
			service.batchDelete (ArticleMobile.class, ids);
			Write (OK);
		}
		catch (Exception e)
		{
			Write (NO);
		}
	}

	@Override
	public void ajaxDelete(Integer id)
	{
		service.deleteObject (ArticleMobile.class, getId ());
	}

	@Override
	public void delete(Integer id)
	{
		service.deleteObject (ArticleMobile.class, getId ());
	}

	public ArticleMobile getArticle()
	{
		return article;
	}

	public void getState()
	{
		List<State> states = service.getStatesAll (State.TYPE_ARTICLE_MOBILE);
		String      json = JSONHelper.SerializeWithNeedAnnotation (states);
		Write (json);
	}

	public void getList()
		throws Exception
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer(" SELECT count(a) FROM ArticleMobile a  inner join a.state  WHERE (1=1)");
		StringBuffer    dsql = new StringBuffer(" SELECT a FROM ArticleMobile a  inner join a.state  WHERE (1=1)");
		String          section = getString ("section.id");
		String          startDate = getString ("startDate");
		String          endDate = getString ("endDate");
		String          searchBy = getString ("searchBy");
		String          keyword = getString ("keyword");
		String          state = getString ("state.id");
		gr.setTableAlias ("a");
		gr.setHsql (true);

		StringBuffer      sb = new StringBuffer();
		Map<String, Date> map = gr.getQueryDateProperties ();

		if (section != null)
		{
			sb.append (" AND a.section.id=")
			  .append (section);
		}

		if (StringHelper.isNotBlank (startDate))
		{
			sb.append (" AND a.createDate >=:startDate");
			map.put ("startDate", new SimpleDateFormat("yyyy-MM-dd").parse (startDate + " 00:00:00"));
		}

		if (StringHelper.isNotBlank (endDate))
		{
			sb.append (" AND a.createDate <=:endDate");
			map.put ("endDate", new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse (endDate + " 23:59:59"));
		}

		if (keyword != null)
		{
			sb.append (" AND a.")
			  .append (searchBy)
			  .append (" LIKE '%" + keyword + "%'");
		}

		if (state != null)
		{
			sb.append (" AND a.state.id=")
			  .append (state);
		}

		sb.append (" order by a.createDate desc ");
		gr.setCsql (csql.append (sb).toString ());
		gr.setDsql (dsql.append (sb).toString ());
		gr.setClazz (Article.class);

		gr.addCglibProperty ("getSection",
		  new GridPageRequest.AddCglibPropertyHandler()
			{
				@Override
				public void handler(Object unprox)
				{
					Section section = (Section) unprox;

					if (section != null)
					{
						section.setChildren (null);
					}
				}
			});
		gr.addCglibProperty ("getState");
		gr.addCglibProperty ("getContentTemplate");

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void getMobileArt()
		throws Exception
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer("SELECT count(a) FROM ArticleMobile a WHERE (1=1)");
		StringBuffer    dsql = new StringBuffer("SELECT a FROM ArticleMobile a WHERE (1=1)");
		Integer         sectionId = getInteger ("sectionId");

		if ((sectionId != null) && (sectionId != 0))
		{
			csql.append (" AND a.section.id=" + sectionId);
			dsql.append (" AND a.section.id=" + sectionId);
		}

		dsql.append (" order by a.createDate desc ");

		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());
		gr.addCglibProperty ("getSection",
		  new GridPageRequest.AddCglibPropertyHandler()
			{
				@Override
				public void handler(Object unprox)
				{
					Section section = (Section) unprox;

					if (section != null)
					{
						section.setChildren (null);
					}
				}
			});
		gr.addCglibProperty ("getState");

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public ArticleService getService()
	{
		return service;
	}

	public TemplateService getTemplateService()
	{
		return templateService;
	}

	private void queryTemplates()
	{
		List<Template> templates = templateService.getMobileTemplates ();

		addAttribute ("templates", templates);
	}

	public void setArticle(ArticleMobile article)
	{
		this.article = article;
	}

	public void setService(ArticleService service)
	{
		this.service = service;
	}

	public void setTemplateService(TemplateService templateService)
	{
		this.templateService = templateService;
	}

	@Override
	public void doUpdate()
		throws Exception
	{
		service.update (article, new HibernateUpdateCollectionKiller("getImagesGroups", "getVideosGroups"));
	}

	public void getOnlineArticleMobiles()
	{
		State           onLine = service.getOnlineState ();
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer("SELECT count(a) FROM ArticleMobile a WHERE  a.state.id =" + onLine.getId ());
		StringBuffer    dsql = new StringBuffer("SELECT a FROM ArticleMobile a WHERE  a.state.id =" + onLine.getId ());
		Integer         sectionId = getInteger ("sectionId");

		if ((sectionId != null) && (sectionId != 0))
		{
			csql.append (" AND a.section.id=" + sectionId);
			dsql.append (" AND a.section.id=" + sectionId);
		}

		dsql.append (" order by a.topDate desc,a.createDate desc ");
		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());
		gr.addCglibProperty ("getSection",
		  new GridPageRequest.AddCglibPropertyHandler()
			{
				@Override
				public void handler(Object unprox)
				{
					Section section = (Section) unprox;

					if (section != null)
					{
						section.setChildren (null);
					}
				}
			});
		gr.addCglibProperty ("getState");

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void getOfflineArticleMobiles()
	{
		State offLine = service.getOfflineState ();

		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer csql = new StringBuffer("SELECT count(a) FROM ArticleMobile a WHERE    a.state.id = " + offLine.getId ());
		StringBuffer dsql = new StringBuffer("SELECT a FROM ArticleMobile a WHERE   a.state.id = " + offLine.getId ());
		Integer sectionId = getInteger ("sectionId");

		if ((sectionId != null) && (sectionId != 0))
		{
			csql.append (" AND a.section.id=" + sectionId);
			dsql.append (" AND a.section.id=" + sectionId);
		}

		dsql.append (" order by a.createDate desc ");
		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());
		gr.addCglibProperty ("getSection",
		  new GridPageRequest.AddCglibPropertyHandler()
			{
				@Override
				public void handler(Object unprox)
				{
					Section section = (Section) unprox;

					if (section != null)
					{
						section.setChildren (null);
					}
				}
			});
		gr.addCglibProperty ("getState");

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void getOnlineArticleImages()
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer("SELECT count(a) FROM ImageContent a WHERE  a.state.next = null");
		StringBuffer    dsql = new StringBuffer("SELECT a FROM ImageContent a WHERE  a.state.next = null ");
		Integer         sectionId = getInteger ("sectionId");

		if ((sectionId != null) && (sectionId != 0))
		{
			csql.append (" AND a.section.id=" + sectionId);
			dsql.append (" AND a.section.id=" + sectionId);
		}

		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());
		gr.addCglibProperty ("getSection",
		  new GridPageRequest.AddCglibPropertyHandler()
			{
				@Override
				public void handler(Object unprox)
				{
					Section section = (Section) unprox;

					if (section != null)
					{
						section.setChildren (null);
					}
				}
			});
		gr.addCglibProperty ("getState");

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void changeOnLineState()
	{
		Integer id = getId ();
		Class   clazz = ArticleMobile.class;
		String  type = getString ("type");

		if ("mobileImage".equals (type))
		{
			clazz = ImageContent.class;
		}

		Article article = service.get (clazz, id);
		article.setState (service.getOfflineState ());
		service.saveMobile (article, getBackUser ());
	}

	public void ajaxDeleteOffLine()
	{
		Integer id = getId ();

		try
		{
			service.deleteObject (ArticleMobile.class, id);
			Write (OK);
		}
		catch (Exception e)
		{
			e.printStackTrace ();
			Write (NO);
		}
	}

	public void ajaxToTop()
	{
		Integer id = getId ();

		try
		{
			service.toTop (id, ArticleMobile.class);
			Write (OK);
		}
		catch (Exception e)
		{
			e.printStackTrace ();
			Write (NO);
		}
	}

	public void changeToEditState()
	{
		Integer id = getId ();

		try
		{
			service.changeToEditState (id, ArticleMobile.class);
			Write (OK);
		}
		catch (Exception e)
		{
			e.printStackTrace ();
			Write (NO);
		}
	}

	@Override
	public void add(HttpServletRequest req)
		throws ScriptException
	{
		List<ArticleMobileTemplate> contentTemplates = getArticleMobileTemplate ();
		req.setAttribute ("contentTemplates", contentTemplates);
		List<ArticleMobileType> contentTypes= getArticleMobileTypes ();
		req.setAttribute("contentTypes", contentTypes);
	}

	private List<ArticleMobileType> getArticleMobileTypes() {
		HttpSession                 session = getSession ();
		List<ArticleMobileType> Types = (List<ArticleMobileType>) session.getAttribute (SHOWTPYES_SESSION_KEY);

		if (Types == null)
		{
			Types = service.getList (ArticleMobileType.class);

		}
		return Types;
	}

	@SuppressWarnings("unchecked")
	@Override
	public void edit(
	  Integer            id,
	  HttpServletRequest req)
		throws Exception
	{
		LazyKiller killer = new LazyKiller();
		killer.addCglibProperty ("getSection")
		      .addCglibProperty ("getContentTemplate")
		      .addLazyProperty ("getImagesGroups")
		      .addLazyProperty ("getVideosGroups")
		      .addLazyProperty ("getRelatedArticles");
		article = service.get (id, ArticleMobile.class, killer);

		List<ArticleMobileGoodsImageGroup> imageGroups = (List<ArticleMobileGoodsImageGroup>) service.getProperty (article, "getImagesGroups");

		if (CollectionHelper.isNotEmpty (imageGroups))
		{
			req.setAttribute ("images", JSONHelper.Serialize (imageGroups));
		}

		List<ArticleMobileGoodsVideoGroup> videoGroups = (List<ArticleMobileGoodsVideoGroup>) service.getProperty (article, "getVideosGroups");

		if (CollectionHelper.isNotEmpty (videoGroups))
		{
			req.setAttribute ("videos", JSONHelper.Serialize (videoGroups));
		}

//		System.out.println (getRequest ().getAttribute ("images"));
//		System.out.println (getRequest ().getAttribute ("videos"));
		//修改了商家的辅助信息
		
		ArticleMobileTemplate template = article.getContentTemplate ();
		addAttribute ("content", article);

		Map<String, Object> entities = new HashMap<String, Object>();
		entities.put ("content", article);

		List<State> states = service.getStates (State.TYPE_ARTICLE_MOBILE);
		entities.put ("states", states);
		Object assist=service.getProperty(article, "getBasicDesc");
		if(assist!=null)
		{
			String[] ss=assist.toString().split("\\|");
			entities.put("assists", ss);
		}
		String HTML = filterFreeMarkerScript (template.getEditTemplate (), entities);
		addAttribute ("HTML", HTML);

		List<ArticleMobileTemplate> contentTemplates = getArticleMobileTemplate ();
		req.setAttribute ("contentTemplates", contentTemplates);
		List<ArticleMobileType> contentTypes= getArticleMobileTypes ();
		req.setAttribute("contentTypes", contentTypes);
	}
	
	@Override
	public void doSave()
	{
		service.saveMobile (article, getBackUser ());
	}

	public void getRelatedNews()
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		String          ams = getString ("ams");
		StringBuffer    csql = new StringBuffer("SELECT count(am) FROM ArticleMobileNews am WHERE am.state.id = 45 and am.sender in ( SELECT u.id FROM BackUser u where u.department=" + getBackUser ().getDepartment ().getId () + ")");
		StringBuffer    dsql = new StringBuffer("SELECT am FROM ArticleMobileNews am WHERE am.state.id = 45 and am.sender in ( SELECT u.id FROM BackUser u where u.department=" + getBackUser ().getDepartment ().getId () + ")");
		Integer         sectionId = getInteger ("sectionId");

		if ((sectionId != null) && (sectionId != 0))
		{
			csql.append (" AND am.section.id=" + sectionId);
			dsql.append (" AND am.section.id=" + sectionId);
		}

		if (StringHelper.isNotBlank (ams))
		{
			csql.append (" AND am.id not in(")
			    .append (ams)
			    .append (")");
			dsql.append (" AND am.id not in(")
			    .append (ams)
			    .append (")");
		}

		dsql.append (" order by am.createDate desc ");

		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void getRelatedGoods()
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		String          ams = getString ("ams");
		StringBuffer    csql = new StringBuffer("SELECT count(am) FROM ArticleMobileGoods am WHERE am.state.id = 45 and am.sender in ( SELECT u.id FROM BackUser u where u.department=" + getBackUser ().getDepartment ().getId () + ")");
		StringBuffer    dsql = new StringBuffer("SELECT am FROM ArticleMobileGoods am WHERE am.state.id = 45 and am.sender in ( SELECT u.id FROM BackUser u where u.department=" + getBackUser ().getDepartment ().getId () + ")");
		Integer         sectionId = getInteger ("sectionId");

		if ((sectionId != null) && (sectionId != 0))
		{
			csql.append (" AND am.section.id=" + sectionId);
			dsql.append (" AND am.section.id=" + sectionId);
		}

		if (StringHelper.isNotBlank (ams))
		{
			csql.append (" AND am.id not in(")
			    .append (ams)
			    .append (")");
			dsql.append (" AND am.id not in(")
			    .append (ams)
			    .append (")");
		}

		dsql.append (" order by am.createDate desc ");

		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}
	public void getRelatedArticle()
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		String          ams = getString ("ams");
		StringBuffer    csql = new StringBuffer("SELECT count(am) FROM ArticleMobile am WHERE am.state.id = 45 and am.sender in ( SELECT u.id FROM BackUser u where u.department=" + getBackUser ().getDepartment ().getId () + ")");
		StringBuffer    dsql = new StringBuffer("SELECT am FROM ArticleMobile am WHERE am.state.id = 45 and am.sender in ( SELECT u.id FROM BackUser u where u.department=" + getBackUser ().getDepartment ().getId () + ")");
		Integer         sectionId = getInteger ("sectionId");
		
		if ((sectionId != null) && (sectionId != 0))
		{
			csql.append (" AND am.section.id=" + sectionId);
			dsql.append (" AND am.section.id=" + sectionId);
		}
		
		if (StringHelper.isNotBlank (ams))
		{
			csql.append (" AND am.id not in(")
			.append (ams)
			.append (")");
			dsql.append (" AND am.id not in(")
			.append (ams)
			.append (")");
		}
		
		dsql.append (" order by am.createDate desc ");
		
		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());
		
		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public void getContentTemplate()
		throws ScriptException,
			ClassNotFoundException
	{
		ArticleMobileTemplate ct = service.get (ArticleMobileTemplate.class, getId ());
		List<State>           states = service.getStates (State.TYPE_ARTICLE_MOBILE);
		Map<String, Object>   entities = new HashMap<String, Object>();
		entities.put ("states", states);

		String template = filterFreeMarkerScript (ct.getAddTemplate (), entities);
		Write (template);
	}

	@Override
	public ArticleMobile getModel()
	{
		try
		{
			this.article = (ArticleMobile) Class.forName (entityClass.getName ())
				                                  .newInstance ();
		}
		catch (InstantiationException e)
		{
			e.printStackTrace ();
		}
		catch (IllegalAccessException e)
		{
			e.printStackTrace ();
		}
		catch (ClassNotFoundException e)
		{
			e.printStackTrace ();
		}

		return article;
	}
}
