package com.gang.action.article;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.BackUserProxy;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.section.Section;
import com.gang.entity.user.BackUser;
import com.gang.service.article.PadArticleAuditService;
import com.gang.service.process.StateService;

public class PadArticleAuditAction extends DefaultAction {

	private static final long serialVersionUID = 1L;
	private PadArticleAuditService service;
	private StateService stateService;
	private ArticlePad article;
	private String reason;

	public String getReason() {
		return reason;
	}

	public void setReason(String reason) {
		this.reason = reason;
	}

	public ArticlePad getArticle() {
		return article;
	}

	public void setArticle(ArticlePad article) {
		this.article = article;
	}

	public void setService(PadArticleAuditService service) {
		this.service = service;
	}

	public String toReject(){
		article = (ArticlePad)service.get(ArticlePad.class, article.getId());
		return "reject";
	}

	@Override
	public void getList() throws Exception {
//		BackUser user = getBackUser();
//		BackUserProxy proxy = new BackUserProxy(user);
		GridPageRequest gr = new GridPageRequest(getRequest());
//		String sids = proxy.joinIds(stateService.getStateIds(proxy.getRoleIds()).toArray(new Integer[]{}));
		String sids = PAD_WAIT_AUDIT+"";
		gr.setCsql("SELECT COUNT(*) FROM ArticlePad WHERE state.id in (" + sids + ")");
		gr.setDsql("FROM ArticlePad WHERE state.id in (" + sids + ")");
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
	
	/**
	 * 审核到下一步
	 */
	public String auditNext(){
		service.next(getArticle().getId(), getBackUser());
		return LIST;
	}
	
	/**
	 * 驳回
	 */
	public String reject(){
		service.reject(getArticle().getId(), getBackUser(), getReason());
		return LIST;
	}

	public void getAuditHistory() throws Exception{
		GridPageRequest gr = new GridPageRequest(getRequest());
		gr.setCsql("SELECT COUNT(*) FROM PadArticleAudit WHERE article.id=" + getId());
		gr.setDsql("FROM PadArticleAudit WHERE article.id=" + getId());
		gr.setHsql(true);
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public void setStateService(StateService stateService) {
		this.stateService = stateService;
	}
	
	public String audit(){
		Integer id = getArticle().getId();
		getRequest().setAttribute("article", service.getArt(id));
		return "audit";
	}
}
