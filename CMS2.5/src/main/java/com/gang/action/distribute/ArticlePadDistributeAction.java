package com.gang.action.distribute;

import com.gang.action.DefaultAction;
import com.gang.comms.DateHelper;
import com.gang.comms.FileHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.imagecontent.ImageContent;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.service.distribute.ArticlePadDistributeService;
import com.gang.service.template.TemplateService;

public class ArticlePadDistributeAction extends DefaultAction {

	private ArticlePadDistributeService service;
	private TemplateService templateService;

	public void distributeSignal() {
		// 获取id
		Integer id = getId();

		Class clazz = ArticlePad.class;
		String type = getString("type");
		if ("padImage".equals(type))
			clazz = ImageContent.class;
		// 获取绝对路径
		String basePath = getBasePath();
		String baseFolder = "HTML";
		// 获取模版存放目录
		String baseDir = getRealPath(baseFolder);
		// 获取时间
		String folder =  DateHelper.getDate("yyyy-MM-dd");
		String subFolder ="iPad";
		// 如果没有文件夹就创建
		String dictory = baseDir + folder + "\\" + subFolder+ "\\"+id;
		FileHelper.createFolderIfNotExists(dictory);
		// 获取文件名
		//String fileName = UUID.randomUUID().toString() + ".html";
		String fileName = id + ".html";
		String fullFileName = dictory + "\\" + fileName;
		// 生成静态HTML
		String virtualPath = baseFolder + "/" + folder + "/" + subFolder + "/" + id+ "/"+fileName;
		try {
			templateService.render(id,clazz, basePath, virtualPath, fullFileName, getBackUser());
			Write("OK");
		} catch (Exception e) {
			Write("NO");
		}
	}
	public void distribute() {
		// 获取id
		String layoutId = getString("layoutId");
		// 获取绝对路径
		String baseFolder = "HTML";
		// 获取模版存放目录
		String baseDir = getRealPath(baseFolder);
		// 获取时间
		String folder = DateHelper.getDate("yyyy-MM-dd");
		String subFolder="iPad";
		// 如果没有文件夹就创建
		String dictory = baseDir + folder+"\\"+subFolder+"\\"+layoutId+"\\";
		FileHelper.createFolderIfNotExists(dictory);
		String absolutlyPath = dictory ;
		FileHelper.createFolderIfNotExists(absolutlyPath);
		// 生成静态HTML
		String virtualPath = baseFolder + "/" + folder + "/" +subFolder+"/"+layoutId+"/";
		try {
			templateService.render(layoutId, virtualPath, absolutlyPath, getBackUser());
			Write("OK");
		} catch (Exception e) {
			Write("NO");
		}
	}

	public void getArticlePadPrepareDistribute() {
		// SELECT * FROM articlePad WHERE state=(SELECT id FROM state WHERE
		// previd IS NOT NULL AND nextid IS NULL AND nodetype=3)
		String section = getString("sectionId");
		GridPageRequest gr = new GridPageRequest(getRequest());
//		StringBuffer csql = new StringBuffer(" SELECT count(p) FROM ArticlePad p  WHERE p.state.next.next is null and p.id not in (select l.article from PadPageLayoutArticle l WHERE  l.type=0 and l.layout.state!=-1) and p.state.nodeType=" + State.TYPE_ARTICLE_PAD);
//		StringBuffer dsql = new StringBuffer(" SELECT p FROM ArticlePad p WHERE p.state.next.next is null and p.id not in (select l.article from PadPageLayoutArticle l WHERE  l.type=0 and l.layout.state!=-1) and p.state.nodeType=" + State.TYPE_ARTICLE_PAD);
		StringBuffer csql = new StringBuffer(" SELECT count(p) FROM ArticlePad p  WHERE p.state.next.next is null  and p.state.nodeType=" + State.TYPE_ARTICLE_PAD);
		StringBuffer dsql = new StringBuffer(" SELECT p FROM ArticlePad p WHERE p.state.next.next is null  and p.state.nodeType=" + State.TYPE_ARTICLE_PAD);
		gr.setHsql(true);
		StringBuffer sb = new StringBuffer();
		if (StringHelper.isNotBlank(section)) {
			sb.append(" AND p.section=").append(section);
		}
		
		sb.append(" order by p.createDate desc ");
		gr.setTableAlias("p");
		gr.addCglibProperty("getSection", new GridPageRequest.AddCglibPropertyHandler() {
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
		System.out.println(json);
		Write(json);
	}

	public void getPadImageContentPrepareDistribute() {
		// SELECT * FROM articlePad WHERE state=(SELECT id FROM state WHERE
		// previd IS NOT NULL AND nextid IS NULL AND nodetype=3)
		String section = getString("section");
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer(" SELECT count(p) FROM PadImageContent p  WHERE p.state.next.next is null and p.state.nodeType=" + State.TYPE_IMAGE_ARTICLE_PAD);
		StringBuffer dsql = new StringBuffer(" SELECT p FROM PadImageContent p WHERE p.state.next.next is null and p.state.nodeType=" + State.TYPE_IMAGE_ARTICLE_PAD);
		gr.setHsql(true);
		gr.setGetAll(true);
		StringBuffer sb = new StringBuffer();
		if (StringHelper.isNotBlank(section)) {
			sb.append(" AND p.section=").append(section);
		}
		sb.append(" order by p.createDate desc ");
		gr.setTableAlias("p");
		gr.addCglibProperty("getSection", new GridPageRequest.AddCglibPropertyHandler() {
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

	public ArticlePadDistributeService getService() {
		return service;
	}
	public TemplateService getTemplateService() {
		return templateService;
	}
	public void setService(ArticlePadDistributeService service) {
		this.service = service;
	}
	public void setTemplateService(TemplateService templateService) {
		this.templateService = templateService;
	}
}
