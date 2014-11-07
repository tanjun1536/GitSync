package com.gang.action.distribute;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.DateHelper;
import com.gang.comms.FileHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.imagecontent.ImageContent;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.service.article.ArticleService;
import com.gang.service.distribute.ArticlePadDistributeService;
import com.gang.service.template.TemplateService;

public class ArticleMobileDistributeAction extends DefaultAction {

	private ArticleService service;
	private TemplateService templateService;

	public TemplateService getTemplateService() {
		return templateService;
	}

	public void setTemplateService(TemplateService templateService) {
		this.templateService = templateService;
	}

	@Override
	public String add() throws Exception {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public void ajaxDelete() throws Exception {
		// TODO Auto-generated method stub

	}

	@Override
	public String delete() throws Exception {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public String edit() throws Exception {
		// TODO Auto-generated method stub
		return null;
	}

	public void getArticleMobilePrepareDistribute() {
		// SELECT * FROM articlePad WHERE state=(SELECT id FROM state WHERE
		// previd IS NOT NULL AND nextid IS NULL AND nodetype=3)
		String section = getString("sectionId");
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer(
				" SELECT count(p) FROM ArticleMobile p  WHERE p.state.next.next is null  and p.state.nodeType="
						+ State.TYPE_ARTICLE_MOBILE);
		StringBuffer dsql = new StringBuffer(
				" SELECT p FROM ArticleMobile p WHERE p.state.next.next is null  and p.state.nodeType="
						+ State.TYPE_ARTICLE_MOBILE);
		gr.setHsql(true);
		StringBuffer sb = new StringBuffer();
		if (StringHelper.isNotBlank(section)) {
			sb.append(" AND p.section=").append(section);
		}
		sb.append(" order by p.createDate desc ");

		gr.setTableAlias("p");
		gr.addCglibProperty("getState");
		gr.addCglibProperty("getSection",
				new GridPageRequest.AddCglibPropertyHandler() {
					@Override
					public void handler(Object unprox) {
						Section section = (Section) unprox;
						if (section != null) {
							section.setChildren(null);
						}
					}
				});
		gr.setCsql(csql.append(sb).toString());
		gr.setDsql(dsql.append(sb).toString());
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	@Override
	public void getList() throws Exception {
		// TODO Auto-generated method stub

	}

	public void getMobileImageContentPrepareDistribute() {
		// SELECT * FROM articlePad WHERE state=(SELECT id FROM state WHERE
		// previd IS NOT NULL AND nextid IS NULL AND nodetype=3)
		String section = getString("section");
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer(
				" SELECT count(p) FROM ImageContent p  WHERE p.state.next.next is null and p.state.nodeType="
						+ State.TYPE_IMAGE_ARTICLE_MOBILE);
		StringBuffer dsql = new StringBuffer(
				" SELECT p FROM ImageContent p WHERE p.state.next.next is null and p.state.nodeType="
						+ State.TYPE_IMAGE_ARTICLE_MOBILE);
		gr.setHsql(true);
		StringBuffer sb = new StringBuffer();
		if (StringHelper.isNotBlank(section)) {
			sb.append(" AND p.section=").append(section);
		}

		sb.append(" order by p.createDate desc ");
		gr.setTableAlias("p");
		gr.addCglibProperty("getSection",
				new GridPageRequest.AddCglibPropertyHandler() {
					@Override
					public void handler(Object unprox) {
						Section section = (Section) unprox;
						if (section != null) {
							section.setChildren(null);
						}
					}
				});
		gr.setCsql(csql.append(sb).toString());
		gr.setDsql(dsql.append(sb).toString());
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public void distribute() {
		// 获取id
		Integer id = getId();

		Class clazz = ArticleMobile.class;
		String type = getString("type");
		if ("mobileImage".equals(type))
			clazz = ImageContent.class;
		// 获取绝对路径
		String basePath = getBasePath();
		String baseFolder = "HTML";
		// 获取模版存放目录
		String baseDir = getRealPath(baseFolder);
		// 获取时间
		String folder = DateHelper.getDate("yyyy-MM-dd");
		String subFolder = "iPhone";
		// 如果没有文件夹就创建
		String dictory = baseDir + folder + "\\" + subFolder + "\\" + id;
		FileHelper.createFolderIfNotExists(dictory);
		// 获取文件名
		// String fileName = UUID.randomUUID().toString() + ".html";
		String fileName = id + ".html";
		String fullFileName = dictory + "\\" + fileName;
		// 生成静态HTML
		String virtualPath = baseFolder + "/" + folder + "/" + subFolder + "/"
				+ id + "/" + fileName;
		try {
			templateService.render(id, clazz, basePath, virtualPath,
					fullFileName, getBackUser());
			Write("OK");
		} catch (Exception e) {
			e.printStackTrace();
			Write("NO");
		}
		// service.next(getId(),ArticleMobile.class);
	}

	public void setService(ArticleService service) {
		this.service = service;
	}

}
