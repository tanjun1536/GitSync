package com.gang.action.article;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import com.gang.action.DefaultAction;
import com.gang.comms.CollectionHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.LazyKiller;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.article.ArticleMobileGoodsImageGroup;
import com.gang.entity.article.ArticleMobileGoodsVideoGroup;
import com.gang.entity.article.ArticleMobileTemplate;
import com.gang.entity.section.Section;
import com.gang.service.article.ArticleAuditService;
import com.gang.service.process.StateService;


public class ArticleAuditAction
  extends DefaultAction
{
	//~ Static fields/initializers -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private static final long serialVersionUID = 1L;

	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private ArticleMobile       article;
	private String              reason;
	private ArticleAuditService service;
	private StateService        stateService;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	@SuppressWarnings("unchecked")
	@Override
	public void audit(Integer id)
		throws Exception
	{
		id=article.getId();
		LazyKiller killer = new LazyKiller();
		killer.addCglibProperty ("getSection")
		      .addCglibProperty ("getContentTemplate")
		      .addLazyProperty ("getImagesGroups")
		      .addLazyProperty ("getVideosGroups")
		      .addLazyProperty ("getAudits")
		      .addLazyProperty ("getRelatedArticles");
		article = service.get (id, ArticleMobile.class, killer);

		List<ArticleMobileGoodsImageGroup> imageGroups = (List<ArticleMobileGoodsImageGroup>) service.getProperty (article, "getImagesGroups");

		if (CollectionHelper.isNotEmpty (imageGroups))
		{
			this.addAttribute ("images", JSONHelper.Serialize (imageGroups));
		}

		List<ArticleMobileGoodsVideoGroup> videoGroups = (List<ArticleMobileGoodsVideoGroup>) service.getProperty (article, "getVideosGroups");

		if (CollectionHelper.isNotEmpty (videoGroups))
		{
			this.addAttribute ("videos", JSONHelper.Serialize (videoGroups));
		}

		System.out.println (getRequest ().getAttribute ("images"));
		System.out.println (getRequest ().getAttribute ("videos"));

		ArticleMobileTemplate template = article.getContentTemplate ();
		addAttribute ("content", article);

		Map<String, Object> entities = new HashMap<String, Object>();
		entities.put ("content", article);
		Object assist=service.getProperty(article, "getBasicDesc");
		if(assist!=null)
		{
			String[] ss=assist.toString().split("\\|");
			entities.put("assists", ss);
		}
		String HTML = filterFreeMarkerScript (template.getAuditTemplate (), entities);
		addAttribute ("script", template.getScript ());
		addAttribute ("HTML", HTML);
		super.audit (id);
	}

	public String auditNext()
	{
		service.next (getArticle ().getId (), getBackUser ());

		return LIST;
	}

	public ArticleMobile getArticle()
	{
		return article;
	}

	public void getAuditHistory()
		throws Exception
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		gr.setCsql ("SELECT COUNT(*) FROM ArticleAudit WHERE article.id=" + getId ());
		gr.setDsql ("FROM ArticleAudit WHERE article.id=" + getId ());
		gr.setHsql (true);

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	@Override
	public void getList()
		throws Exception
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());

		String          sids = MOBILE_WAIT_AUDIT + "";

		gr.setCsql ("SELECT COUNT(*) FROM ArticleMobile WHERE state.id in (" + sids + ")");
		gr.setDsql ("FROM ArticleMobile WHERE state.id in (" + sids + ")");
		gr.setHsql (true);
		gr.addCglibProperty ("getSection", new GridPageRequest.AddCglibPropertyHandler()
			{
				@Override
				public void handler(Object unprox)
				{
					Section section = (Section) unprox;
					section.setChildren (null);
				}
			});
		gr.addCglibProperty ("getState");
		gr.addCglibProperty ("getContentTemplate");

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public String getReason()
	{
		return reason;
	}

	public String reject()
	{
		service.reject (getArticle ().getId (), getBackUser (), getReason ());

		return LIST;
	}

	@Override
	public String save()
		throws Exception
	{
		return null;
	}

	public void setArticle(ArticleMobile article)
	{
		this.article = article;
	}

	public void setReason(String reason)
	{
		this.reason = reason;
	}

	public void setService(ArticleAuditService service)
	{
		this.service = service;
	}

	public void setStateService(StateService stateService)
	{
		this.stateService = stateService;
	}

	public String toReject()
	{
		article = (ArticleMobile) service.get (ArticleMobile.class, article.getId ());

		return "reject";
	}

}
