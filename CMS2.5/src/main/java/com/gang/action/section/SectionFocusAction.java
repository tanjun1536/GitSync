package com.gang.action.section;

import java.io.File;
import java.util.List;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.FileHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.GridPageRequest.AddCglibPropertyHandler;
import com.gang.entity.article.Article;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.section.SectionFocus;
import com.gang.service.article.ArticleService;
import com.gang.service.section.SectionFocusService;

public class SectionFocusAction extends DefaultAction {

	private static final long serialVersionUID = 1L;
	/**
	 * 数据库操作服务
	 */
	private SectionFocusService service;
	private ArticleService articleService;
	private SectionFocus focus;
	private File focusImage;
	/**
	 * 文件上传路径
	 */
	private String uploadDir;

	public String getUploadDir() {
		return uploadDir;
	}

	public void setUploadDir(String uploadDir) {
		this.uploadDir = uploadDir;
	}

	public SectionFocus getFocus() {
		return focus;
	}

	public void setFocus(SectionFocus focus) {
		this.focus = focus;
	}

	public void setArticleService(ArticleService articleService) {
		this.articleService = articleService;
	}

	@Override
	public String add() throws Exception {
//		List<Article> as = articleService.getArticles();
//		getRequest().setAttribute("as", as);
		addAttribute("states", service.getStates(State.TYPE_SECTION_MOBILE));
		return ADD;
	}

	@Override
	public void ajaxDelete() throws Exception {
		try {
			Integer id = getId();
			service.delete(id);
			Write(OK);
		} catch (Exception e) {
			Write(NO);
		}
	}

	@Override
	public String edit() throws Exception {
//		List<Article> as = articleService.getArticles();
//		getRequest().setAttribute("as", as);
		addAttribute("states", service.getStates(State.TYPE_SECTION_MOBILE));
		focus = (SectionFocus) service.get(SectionFocus.class, focus.getId());
		if ("上线".equals(focus.getState().getName()))
			return VIEW;
		else
			return EDIT;
	}

	private String getWhere() {
		String searchBy = getString("searchBy");
		String keyword = getString("keyword");
		StringBuffer sb = new StringBuffer();
		if (focus != null) {
			if (focus.getSection() != null && focus.getSection().getId() != null) {
				sb.append(" AND section.id=").append(focus.getSection().getId());
			}
		}
		if (keyword != null) {
			sb.append(" AND ").append(searchBy).append(" LIKE '%").append(keyword).append("%'");
		}
		return sb.toString();
	}

	@Override
	public void getList() throws Exception {
		System.out.println("ASDSAD");
		GridPageRequest gr = new GridPageRequest(getRequest());
		gr.setOrderColumn("orderNumber");
		gr.setOrderType("ASC");
		String hqlD = "FROM SectionFocus WHERE 1=1 ";
		String hqlC = "SELECT COUNT(*) FROM SectionFocus WHERE 1=1 ";
		String where = getWhere();
		gr.setCsql(hqlC + where);
		gr.setDsql(hqlD + where);
		gr.setHsql(true);
		gr.addCglibProperty("getSection", new AddCglibPropertyHandler() {
			@Override
			public void handler(Object unprox) {
				Section section = (Section) unprox;
				section.setChildren(null);
			}
		});
		gr.addCglibProperty("getState");
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	@Override
	public String save() throws Exception {
		// 不关联文章
		if (focus.getArticle() == null || focus.getArticle().getId() < 1) {
			focus.setArticle(null);
		}
		// 没有上传图片
		// if(focusImage != null){
		// String saveDir = getRealPath(uploadDir);
		// // 标题图片
		// String focusImageURL = FileHelper.saveFiles(focusImage, uploadDir,
		// saveDir);
		// if (focusImageURL != null)
		// focus.setImagePath(focusImageURL);
		// FileHelper.saveFiles(focusImage, uploadDir, saveDir);
		// }
		if (focus.getSection() == null || focus.getSection().getId() == null) {
			focus.setSection(null);
		}
		focus.setOrderNumber(service.maxSort());
		service.save(focus);
		return LIST;
	}

	public String setPoistion() throws Exception {
		int id = getId();
		int strategy = getInteger("strategy");// -1 or 1
		service.setPositions(id, strategy);
		return LIST;
	}

	@Override
	public String update() throws Exception {
		// 不关联文章
		if (focus.getArticle() == null || focus.getArticle().getId() == null || focus.getArticle().getId() < 1) {
			focus.setArticle(null);
		}
		// 没有上传图片
		// if(focusImage != null){
		// String saveDir = getRealPath(uploadDir);
		// // 标题图片
		// String focusImageURL = FileHelper.saveFiles(focusImage, uploadDir,
		// saveDir);
		// if (focusImageURL != null)
		// focus.setImagePath(focusImageURL);
		// FileHelper.saveFiles(focusImage, uploadDir, saveDir);
		// }
		if (focus.getSection() == null || focus.getSection().getId() == null || focus.getSection().getId() == null) {
			focus.setSection(null);
		}
		service.update(focus);
		return LIST;
	}

	public void setService(SectionFocusService service) {
		this.service = service;
	}

	public File getFocusImage() {
		return focusImage;
	}

	public void setFocusImage(File focusImage) {
		this.focusImage = focusImage;
	}

}
