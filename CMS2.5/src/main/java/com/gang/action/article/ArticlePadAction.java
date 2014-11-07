package com.gang.action.article;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Map;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;
import com.gang.entity.article.Article;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.imagecontent.PadImageContent;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.template.Template;
import com.gang.service.article.ArticleService;
import com.gang.service.template.TemplateService;

public class ArticlePadAction extends DefaultAction {
	/**
	 * 文章对象
	 */
	private ArticlePad article;
	private ArticleService service;

	private TemplateService templateService;

	@Override
	public String add() {
		queryTemplates();
		addAttribute("states", service.getStates(State.TYPE_ARTICLE_PAD));
		return ADD;
	}

	public void ajaxBatchDelete() throws Exception {
		String ids = getString("ids");
		try {
			service.batchDelete(ArticlePad.class, ids);
			Write(OK);
		} catch (Exception e) {
			Write(NO);
		}

	}

	@Override
	public void ajaxDelete() throws Exception {
		if (!service.checkWetherLayout(getId())) {
			service.deleteObject(ArticlePad.class, getId());
			Write(OK);
		} else {
			Write(NO);
		}
	}

	public String delete() {
		service.deleteObject(ArticlePad.class, getId());
		return LIST;
	}

	public String edit() {
		Integer id = getId();
		Article article = (Article) service.get(ArticlePad.class, id);
		getRequest().setAttribute("article", article);
		addAttribute("states", service.getStates(State.TYPE_ARTICLE_PAD));
		queryTemplates();
		return EDIT;
	}

	public ArticlePad getArticle() {
		return article;
	}

	public void getList() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer(" SELECT count(a) FROM ArticlePad a  inner join a.state  WHERE (1=1)");
		StringBuffer dsql = new StringBuffer(" SELECT a FROM ArticlePad a  inner join a.state  WHERE (1=1)");
		String section = getString("section");
		String getAll = getString("getAll");
		String startDate = getString("startDate");
		String endDate = getString("endDate");
		String searchBy = getString("searchBy");
		String keyword = getString("keyword");
		String state = getString("state");
		gr.setTableAlias("a");
		if (StringHelper.isNotBlank(getAll))
			gr.setGetAll(true);
		gr.setHsql(true);
		StringBuffer sb = new StringBuffer();
		Map<String, Date> map = gr.getQueryDateProperties();
		if (StringHelper.isNotBlank(section)) {
			sb.append(" AND a.section.id=").append(section);
		}
		if (StringHelper.isNotBlank(startDate)) {
			sb.append(" AND a.createDate >=:startDate");
			map.put("startDate", new SimpleDateFormat("yyyy-MM-dd").parse(startDate + " 00:00:00"));
		}
		if (StringHelper.isNotBlank(endDate)) {
			sb.append(" AND a.createDate <=:endDate");
			map.put("endDate", new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(endDate + " 23:59:59"));
		}
		if (StringHelper.isNotBlank(keyword)) {
			sb.append(" AND a.").append(searchBy).append(" LIKE '%" + keyword + "%'");
		}
		if (StringHelper.isNotBlank(state)) {
			sb.append(" AND a.state.id=").append(state);
		}
		sb.append(" order by a.createDate desc ");
		gr.setCsql(csql.append(sb).toString());
		gr.setDsql(dsql.append(sb).toString());
		gr.addCglibProperty("getSection", new GridPageRequest.AddCglibPropertyHandler() {
			@Override
			public void handler(Object unprox) {
				Section section = (Section) unprox;
				if (section != null) {
					section.setChildren(null);
				}
			}
		});
		gr.addCglibProperty("getState");
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public ArticleService getService() {
		return service;
	}

	public void getTemplates() {
		List<Template> templates = templateService.getPadListTemplates();
		String json = JSONHelper.SerializeWithNeedAnnotation(templates);
		Write(json);
	}

	public TemplateService getTemplateService() {
		return templateService;
	}

	private void queryTemplates() {
		List<Template> templates = templateService.getPadTemplates();
		addAttribute("templates", templates);
	}

	public String save() throws Exception {
		article.setSender(getBackUser().getName());
		service.savePad(article, getBackUser());
		return LIST;
	}

	public void setArticle(ArticlePad article) {
		this.article = article;
	}

	public void setService(ArticleService service) {
		this.service = service;
	}

	public void setTemplateService(TemplateService templateService) {
		this.templateService = templateService;
	}

	@Override
	public String update() throws Exception {
		return save();
	}

	// public String getPadArt() throws Exception{
	// List<ArticlePad> aps = service.getPadArticle(getInteger("sectionId"));
	// getRequest().setAttribute("as", aps);
	// return "ArtList";
	// }

	public void getPadArt() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer("SELECT count(a) FROM ArticlePad a WHERE (1=1)");
		StringBuffer dsql = new StringBuffer("SELECT a FROM ArticlePad a WHERE (1=1)");
		Integer sectionId = getInteger("sectionId");
		if (sectionId != null && sectionId != 0) {
			csql.append(" AND a.section.id=" + sectionId);
			dsql.append(" AND a.section.id=" + sectionId);
		}
		dsql.append(" order by a.createDate desc ");
		gr.setHsql(true);
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(Article.class);
		gr.addCglibProperty("getSection", new GridPageRequest.AddCglibPropertyHandler() {
			@Override
			public void handler(Object unprox) {
				Section section = (Section) unprox;
				if (section != null) {
					section.setChildren(null);
				}
			}
		});
		gr.addCglibProperty("getState");
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public void getOnlineArticlePads() {
		State onLine = service.getOnlineState();

		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer("SELECT count(a) FROM ArticlePad a WHERE  a.state.id =" + onLine.getId());
		StringBuffer dsql = new StringBuffer("SELECT a FROM ArticlePad a WHERE  a.state.id =" + onLine.getId());
		Integer sectionId = getInteger("sectionId");
		if (sectionId != null && sectionId != 0) {
			csql.append(" AND a.section.id=" + sectionId);
			dsql.append(" AND a.section.id=" + sectionId);
		}
		dsql.append(" order by a.topDate desc , a.createDate desc ");
		gr.setHsql(true);
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.addCglibProperty("getSection", new GridPageRequest.AddCglibPropertyHandler() {
			@Override
			public void handler(Object unprox) {
				Section section = (Section) unprox;
				if (section != null) {
					section.setChildren(null);
				}
			}
		});
		gr.addCglibProperty("getState");
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public void getOfflineArticlePads() {
		State offLine = service.getOfflineState();

		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer("SELECT count(a) FROM ArticlePad a WHERE   a.state.id = " + offLine.getId());
		StringBuffer dsql = new StringBuffer("SELECT a FROM ArticlePad a WHERE    a.state.id = " + offLine.getId());
		Integer sectionId = getInteger("sectionId");
		if (sectionId != null && sectionId != 0) {
			csql.append(" AND a.section.id=" + sectionId);
			dsql.append(" AND a.section.id=" + sectionId);
		}
		dsql.append(" order by a.createDate desc ");
		gr.setHsql(true);
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.addCglibProperty("getSection", new GridPageRequest.AddCglibPropertyHandler() {
			@Override
			public void handler(Object unprox) {
				Section section = (Section) unprox;
				if (section != null) {
					section.setChildren(null);
				}
			}
		});
		gr.addCglibProperty("getState");
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public void changeOnLineState() {
		Integer id = getId();
		Class clazz = ArticlePad.class;
		String type = getString("type");
		if ("padImage".equals(type))
			clazz = PadImageContent.class;
		Article article = service.get(clazz, id);
		article.setState(service.getOfflineState());
		service.savePad(article, getBackUser());
	}

	public void ajaxDeleteOffLine() {
		Integer id = getId();
		try {
			service.deleteObject(ArticlePad.class, id);
			Write(OK);
		} catch (Exception e) {
			e.printStackTrace();
			Write(NO);
		}
	}

	public void ajaxToTop() {
		Integer id = getId();
		try {
			service.toTop(id, ArticlePad.class);
			Write(OK);
		} catch (Exception e) {
			e.printStackTrace();
			Write(NO);
		}
	}
	public void changeToEditState()
	{
		Integer id = getId();
		try {
			service.changeToEditState(id,ArticlePad.class);
			Write(OK);
		} catch (Exception e) {
			e.printStackTrace();
			Write(NO);
		}
	}
}
