package com.gang.action.image;

import java.io.File;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.FileHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.entity.image.ImageInfo;
import com.gang.entity.section.Section;
import com.gang.service.image.ImageInfoService;


public class ImageInfoAction extends DefaultAction {

	private static final long serialVersionUID = 1L;
	
	private ImageInfoService service;
	private GridPageRequest req;
	private ImageInfo imgInfo;
	private File img;
	private String imgFileName;
	/**
	 * 文件上传路径
	 */
	private String uploadDir;
	public void setUploadDir(String uploadDir) {
		this.uploadDir = uploadDir;
	}

	public void setReq(GridPageRequest req) {
		this.req = req;
	}

	public void setImg(File img) {
		this.img = img;
	}

	public ImageInfoAction(){
		req = new GridPageRequest();
		req.setPageIndex(1);
		req.setPageSize(10000);
	}

	@Override
	public String add() throws Exception {
		Section section = (Section)service.get(Section.class, imgInfo.getSection().getId());
		getRequest().setAttribute("section", section);
		return ADD;
	}                                           

	@Override
	public void ajaxDelete() throws Exception {
		try {
			service.delete(imgInfo);
			Write(OK);
		} catch (Exception e) {
			Write(NO);
		}
	}
	@Override
	public String edit() throws Exception {
		imgInfo = service.getImageInfoById(imgInfo.getId());
		return EDIT;
	}
	@Override
	public String save() throws Exception {
		if(img != null){
			String saveDir = getRealPath(uploadDir);
			// 标题图片
			String imageURL = FileHelper.saveFiles(img, imgFileName, uploadDir, saveDir);
			if (imageURL != null){
				imgInfo.setPath(imageURL);
				if(imgInfo.getName()==null || "".equals(imgInfo.getName().trim())){
					imgInfo.setName(imgFileName.substring(0, imgFileName.lastIndexOf(".")));
				}
				imgInfo.setUser(getBackUser());
				service.save(imgInfo);
			}
		}
		return "listaction";
	}

	@Override
	public String update() throws Exception {
		service.update(imgInfo);
		return "listaction";
	}

	public void setService(ImageInfoService service) {
		this.service = service;
	}
	
	private ImageInfo getQueryImageInfo(){
		if(imgInfo == null)
			imgInfo = new ImageInfo();
		imgInfo.setUser(getBackUser());
		return imgInfo;
	}
	public String list() throws Exception {
		GridPageResponse res = service.getImageInfo(req, getQueryImageInfo());
		getRequest().setAttribute("res", res);
		return LIST;
	}
	
	public String listSel() throws Exception {
		GridPageResponse res = service.getImageInfo(req, getQueryImageInfo());
		getRequest().setAttribute("res", res);
		return "listsel";
	}

	public ImageInfo getImgInfo() {
		return imgInfo;
	}

	public void setImgInfo(ImageInfo imgInfo) {
		this.imgInfo = imgInfo;
	}

	public void setImgFileName(String imgFileName) {
		this.imgFileName = imgFileName;
	}

}
