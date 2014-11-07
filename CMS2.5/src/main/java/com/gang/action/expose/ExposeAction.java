package com.gang.action.expose;

import java.io.File;
import java.util.List;
import java.util.Set;

import com.gang.action.DefaultAction;
import com.gang.comms.FileHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.expose.UserExpose;
import com.gang.service.expose.ExposeService;
import com.opensymphony.xwork2.ModelDriven;

public class ExposeAction extends DefaultAction {

	private static final long serialVersionUID = 1L;

	private UserExpose expose;

	public UserExpose getExpose() {
		return expose;
	}

	public void setExpose(UserExpose expose) {
		this.expose = expose;
	}

	private ExposeService service;

	public ExposeService getService() {
		return service;
	}

	public void setService(ExposeService service) {
		this.service = service;
	}

	private List<File> images;

	public List<File> getImages() {
		return images;
	}

	public void setImages(List<File> images) {
		this.images = images;
	}
	
	public String view()
	{
		Integer id=getId();
		UserExpose expose=this.service.get(UserExpose.class, id);
		this.addAttribute("expose", expose);
		return "view";
	}
	
	@Override
	public void getList() throws Exception {
		try {
			GridPageRequest gr = new GridPageRequest(getRequest());
			StringBuffer csql = new StringBuffer(" SELECT count(a) FROM UserExpose a");
			StringBuffer dsql = new StringBuffer(" SELECT a FROM UserExpose a");
			gr.setHsql(true);
			gr.setTableAlias("a");
			gr.setOrderType("DESC");
			gr.setCsql(csql.toString());
			gr.setDsql(dsql.toString());
			gr.setClazz(UserExpose.class);
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
			Write(json);
		} catch (Exception e) {
			// TODO: handle exception
			e.printStackTrace();
		}
		

	}
	public void ajaxUpload() {
		try {
			String vp = "exposeimages/";
			String lp = getRealPath("exposeimages");
			Set<String> imgs = FileHelper.saveFiles(images, vp, lp);
			this.expose.setImages(imgs);
			this.service.save(expose);
			this.Write(OK);
		} catch (Exception e) {
			this.Write(NO);
		}

	}

	@Override
	public void ajaxDelete(Integer id) throws Exception {
		// TODO Auto-generated method stub
		service.deleteObject(UserExpose.class, id);
	}
	
	


}
