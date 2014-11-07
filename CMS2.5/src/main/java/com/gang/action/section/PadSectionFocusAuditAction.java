package com.gang.action.section;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.BackUserProxy;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.section.PadSectionFocus;
import com.gang.entity.section.Section;
import com.gang.entity.user.BackUser;
import com.gang.service.process.StateService;
import com.gang.service.section.PadSectionFocusAuditService;

public class PadSectionFocusAuditAction extends DefaultAction {

	private static final long serialVersionUID = 1L;
	private PadSectionFocusAuditService service;
	private StateService stateService;
	private PadSectionFocus focus;
	private String reason;
	private String state;

	public String getReason() {
		return reason;
	}

	public void setReason(String reason) {
		this.reason = reason;
	}
	public PadSectionFocus getFocus() {
		return focus;
	}

	public void setFocus(PadSectionFocus focus) {
		this.focus = focus;
	}


	@Override
	public void getList() throws Exception {
//		String stateId = state;
//		if(stateId == null || stateId.trim().equals("")){
//			System.out.println("state is null, return empty");
//			return;
//		}
//		BackUser user = getBackUser();
//		BackUserProxy proxy = new BackUserProxy(user);
		GridPageRequest gr = new GridPageRequest(getRequest());
//		String sids = proxy.joinIds(stateService.getStateIds(proxy.getRoleIds()).toArray(new Integer[]{}));
		String sids = PAD_SECTIONFOCUS_WAIT_AUDIT+"";
		gr.setCsql("SELECT COUNT(*) FROM PadSectionFocus WHERE state.id in (" + sids + ")");
		gr.setDsql("FROM PadSectionFocus WHERE state.id in (" + sids + ")");
//		gr.setCsql("SELECT COUNT(*) FROM PadSectionFocus WHERE state.id=" + stateId);
//		gr.setDsql("FROM PadSectionFocus WHERE state.id=" + stateId);
		gr.setHsql(true);
		gr.addCglibProperty("getSection",new GridPageRequest.AddCglibPropertyHandler() {
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

	public void setService(PadSectionFocusAuditService service) {
		this.service = service;
	}
	
	/**
	 * 审核到下一步
	 */
	public String auditNext(){
		service.next(getId(), getBackUser());
		return LIST;
	}
	
	/**
	 * 调整驳回界面
	 * @return
	 */
	public String toReject(){
		focus = (PadSectionFocus)service.get(PadSectionFocus.class, getId());
		return "reject";
	}
	
	/**
	 * 驳回
	 */
	public String reject(){
		service.reject(getId(), getBackUser(), getReason());
		return LIST;
	}

	/**
	 * 审核历史
	 * @throws Exception
	 */
	public void getAuditHistory() throws Exception{
		GridPageRequest gr = new GridPageRequest(getRequest());
		gr.setCsql("SELECT COUNT(*) FROM PadSectionFocusAudit WHERE focus.id=" + getId());
		gr.setDsql("FROM PadSectionFocusAudit WHERE focus.id=" + getId());
		gr.setHsql(true);
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public void setStateService(StateService stateService) {
		this.stateService = stateService;
	}

	public String getState() {
		return state;
	}

	public void setState(String state) {
		this.state = state;
	}
	public String audit(){
		focus = (PadSectionFocus)service.get(PadSectionFocus.class, getId());
		return "audit";
	}
}
