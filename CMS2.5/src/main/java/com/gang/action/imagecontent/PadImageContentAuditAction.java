package com.gang.action.imagecontent;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.BackUserProxy;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.imagecontent.ImageContent;
import com.gang.entity.imagecontent.PadImageContent;
import com.gang.entity.section.Section;
import com.gang.entity.user.BackUser;
import com.gang.service.imagecontent.PadImageContentAuditService;
import com.gang.service.process.StateService;

public class PadImageContentAuditAction extends DefaultAction {

	private static final long serialVersionUID = 1L;
	private PadImageContentAuditService service;
	private StateService stateService;
	private PadImageContent img;
	private String reason;
	private String state;

	public String getReason() {
		return reason;
	}


	public PadImageContent getImg() {
		return img;
	}


	public void setImg(PadImageContent img) {
		this.img = img;
	}


	public String getState() {
		return state;
	}


	public void setService(PadImageContentAuditService service) {
		this.service = service;
	}

	public String toReject(){
		img = (PadImageContent)service.get(PadImageContent.class, getId());
		return "reject";
	}

	@Override
	public void getList() throws Exception {
//		String stateId = state;
//		if(stateId == null || stateId.trim().equals("")){
//			System.out.println("state is null, return empty");
//			return;
//		}
		BackUser user = getBackUser();
		BackUserProxy proxy = new BackUserProxy(user);
		GridPageRequest gr = new GridPageRequest(getRequest());
		String sids = proxy.joinIds(stateService.getStateIds(proxy.getRoleIds()).toArray(new Integer[]{}));
		gr.setCsql("SELECT COUNT(*) FROM PadImageContent WHERE state.id in (" + sids + ")");
		gr.setDsql("FROM PadImageContent WHERE state.id in (" + sids + ")");
//		gr.setCsql("SELECT COUNT(*) FROM PadImageContent WHERE state.id=" + stateId);
//		gr.setDsql("FROM PadImageContent WHERE state.id=" + stateId);
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
		gr.setCsql("SELECT COUNT(*) FROM PadImageContentAudit WHERE img.id=" + getId());
		gr.setDsql("FROM PadImageContentAudit WHERE img.id=" + getId());
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


	public void setStateService(StateService stateService) {
		this.stateService = stateService;
	}
	private PadImageContent imgContent;
	public String audit(){
		imgContent = service.getPadImageContent(getId());
		return "audit";
	}


	public PadImageContent getImgContent() {
		return imgContent;
	}


	public void setImgContent(PadImageContent imgContent) {
		this.imgContent = imgContent;
	}
}
