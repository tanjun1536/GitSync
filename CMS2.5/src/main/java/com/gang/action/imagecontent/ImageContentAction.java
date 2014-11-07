package com.gang.action.imagecontent;

import java.util.Date;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.imagecontent.ImageContent;
import com.gang.entity.imagecontent.SelImage;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.template.Template;
import com.gang.service.imagecontent.ImageContentService;
import com.gang.service.template.TemplateService;

public class ImageContentAction extends DefaultAction{

	private static final long serialVersionUID = 1L;
	private ImageContentService service;
	private ImageContent imgContent;
	private String paths[];
	private String descs[];

	private TemplateService templateService;

	public void setTemplateService(TemplateService templateService) {
		this.templateService = templateService;
	}
	
	public ImageContent getImgContent() {
		return imgContent;
	}

	public void setImgContent(ImageContent imgContent) {
		this.imgContent = imgContent;
	}

	public void setService(ImageContentService service) {
		this.service = service;
	}

	@Override
	public String add() throws Exception {
		queryTemplates();
		addAttribute("states", service.getStates(State.TYPE_IMAGE_ARTICLE_MOBILE));
		return ADD;
	}

	@Override
	public void ajaxDelete() throws Exception {
		try {
			service.delete(getId());
			Write(OK);
		} catch (Exception e) {
			e.printStackTrace();
			Write(NO);
		}
	}


	@Override
	public String edit() throws Exception {
		imgContent = service.getImageContent(getId());
		queryTemplates();
		addAttribute("states", service.getStates(State.TYPE_IMAGE_ARTICLE_MOBILE));
		return EDIT;
	}

	public String getWhere(){
		String where = " WHERE 1=1";
		if(imgContent != null){
			if(imgContent.getSection() != null && imgContent.getSection().getId() != null){
				where += " AND section.id=" + imgContent.getSection().getId();
			}
			if(imgContent.getState() != null && imgContent.getState().getId() != null){
				where += " AND section.id=" + imgContent.getState().getId();
			}
		}
		
		String startDate = getString("startDate");
		String endDate = getString("endDate");
		String searchBy = getString("searchBy");
		String keyword = getString("keyword");
		
		if(keyword != null){
			where += " AND " + searchBy + " like '%" + keyword + "%'";
		}
		if (startDate != null) {
			where += String.format(" AND createDate>='%s'", startDate);
		}
		if (endDate != null) {
			where += String.format(" AND createDate<='%s'", endDate);
		}
		
		return where;
	}
	
	@Override
	public void getList() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());
		String where = getWhere();
		System.out.println(where);
		gr.setCsql("SELECT COUNT(*) FROM ImageContent " + where);
		gr.setDsql("FROM ImageContent " + where);
		
		gr.setHsql(true);
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

	@Override
	public String save() throws Exception {
		imgContent.setCreateDate(new Date());
		imgContent.setEditor(getBackUser().getName());
		imgContent.setImages(getSelImages());
		service.add(imgContent);
		return LIST;
	}
	
	private Set<SelImage> getSelImages(){
		Set<SelImage> images = new HashSet<SelImage>();
		if(paths.length == descs.length){
			for(int i=0; i<paths.length; i++){
				SelImage image = new SelImage();
				image.setPath(paths[i]);
				image.setDes(descs[i]);
				image.setContent(imgContent);
				images.add(image);
			}
		}
		return images;
	}

	@Override
	public String update() throws Exception {
		imgContent.setEditor(getBackUser().getName());
		imgContent.setImages(getSelImages());
		service.update(imgContent);
		return LIST;
	}

	private void queryTemplates() {
		List<Template> templates = templateService.getMobileTemplates();
		addAttribute("templates", templates);
	}
	
	public String[] getPaths() {
		return paths;
	}

	public void setPaths(String[] paths) {
		this.paths = paths;
	}

	public String[] getDescs() {
		return descs;
	}

	public void setDescs(String[] descs) {
		this.descs = descs;
	}
	
}
