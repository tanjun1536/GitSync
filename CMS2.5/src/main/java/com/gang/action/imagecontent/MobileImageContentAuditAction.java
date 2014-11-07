package com.gang.action.imagecontent;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.BackUserProxy;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.imagecontent.ImageContent;
import com.gang.entity.section.Section;
import com.gang.entity.user.BackUser;
import com.gang.service.imagecontent.MobileImageContentAuditService;
import com.gang.service.process.StateService;

public class MobileImageContentAuditAction extends DefaultAction {

	private static final long serialVersionUID = 1L;
	private MobileImageContentAuditService service;
	private StateService stateService;
	private ImageContent img;
	private String reason;
	private String state;
	private ImageContent imgContent;
	public void setStateService(StateService stateService) {
		this.stateService = stateService;
	}


	public String getReason() {
		return reason;
	}


	public ImageContent getImg() {
		return img;
	}


	public void setImg(ImageContent img) {
		this.img = img;
	}


	public String getState() {
		return state;
	}


	public void setService(MobileImageContentAuditService service) {
		this.service = service;
	}

	public String audit(){
		imgContent = service.getImageContent(getId());
		return "audit";
	}
	public String toReject(){
		img = (ImageContent)service.get(ImageContent.class, getId());
		return "reject";
	}

	@Override
	public void getList() throws Exception {
		BackUser user = getBackUser();
		BackUserProxy proxy = new BackUserProxy(user);
		GridPageRequest gr = new GridPageRequest(getRequest());
		String sids = proxy.joinIds(stateService.getStateIds(proxy.getRoleIds()).toArray(new Integer[]{}));
		gr.setCsql("SELECT COUNT(*) FROM ImageContent WHERE state.id in (" + sids + ")");
		gr.setDsql("FROM ImageContent WHERE state.id in (" + sids + ")");
//		gr.setCsql("SELECT COUNT(*) FROM ImageContent WHERE state.id=" + stateId);
//		gr.setDsql("FROM ImageContent WHERE state.id=" + stateId);
		gr.setHsql(true);
		gr.addCglibProperty("getSection", new GridPageRequest.AddCglibPropertyHandler() {
			@Override
			public void handler(Object unprox) {
				Section section=(Section)unprox;
				section.setChildren(null);
			}
		});
		gr.addCglibProperty("getState");
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}
	
	/**
	 * 审核到下一步
	 */
	public String auditNext(){
		service.next(getId(), getBackUser());
		return LIST;
	}
	
	/**
	 * 驳回
	 */
	public String reject(){
		service.reject(getId(), getBackUser(), getReason());
		return LIST;
	}

	public void getAuditHistory() throws Exception{
		GridPageRequest gr = new GridPageRequest(getRequest());
		gr.setCsql("SELECT COUNT(*) FROM MobileImageContentAudit WHERE img.id=" + getId());
		gr.setDsql("FROM MobileImageContentAudit WHERE img.id=" + getId());
		gr.setHsql(true);
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public void setReason(String reason) {
		this.reason = reason;
	}


	public void setState(String state) {
		this.state = state;
	}


	public ImageContent getImgContent() {
		return imgContent;
	}


	public void setImgContent(ImageContent imgContent) {
		this.imgContent = imgContent;
	}
}
