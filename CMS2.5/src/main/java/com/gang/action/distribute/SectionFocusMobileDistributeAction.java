package com.gang.action.distribute;

import java.util.UUID;

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
import com.gang.service.distribute.ArticlePadDistributeService;
import com.gang.service.distribute.SectionFocusMobileDistributeService;
import com.gang.service.template.TemplateService;

public class SectionFocusMobileDistributeAction extends DefaultAction {

	private static final long serialVersionUID = 1L;
	private SectionFocusMobileDistributeService service;
	private TemplateService templateService;

	public TemplateService getTemplateService() {
		return templateService;
	}

	public void setTemplateService(TemplateService templateService) {
		this.templateService = templateService;
	}

	public void getSectionFocusMobilePrepareDistribute() {
		// SELECT * FROM articlePad WHERE state=(SELECT id FROM state WHERE
		// previd IS NOT NULL AND nextid IS NULL AND nodetype=3)
		String section = getString("section");
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer(" SELECT count(p) FROM SectionFocus p  WHERE p.state.next.next is null  and p.state.nodeType=" + State.TYPE_SECTION_MOBILE);
		StringBuffer dsql = new StringBuffer(" SELECT p FROM SectionFocus p WHERE p.state.next.next is null  and p.state.nodeType=" + State.TYPE_SECTION_MOBILE);
		gr.setHsql(true);
		StringBuffer sb = new StringBuffer();
		if (StringHelper.isNotBlank(section)) {
			sb.append(" AND p.section=").append(section);
		}
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
	
	public void getSectionFocusMobileHasDistribute() {
		// SELECT * FROM articlePad WHERE state=(SELECT id FROM state WHERE
		// previd IS NOT NULL AND nextid IS NULL AND nodetype=3)
		String section = getString("section");
		GridPageRequest gr = new GridPageRequest(getRequest());
//		StringBuffer csql = new StringBuffer(" SELECT count(p) FROM SectionFocus p  WHERE p.state.next is null  and p.state.nodeType=" + State.TYPE_SECTION_MOBILE);
//		StringBuffer dsql = new StringBuffer(" SELECT p FROM SectionFocus p WHERE p.state.next is null  and p.state.nodeType=" + State.TYPE_SECTION_MOBILE);
		StringBuffer csql = new StringBuffer(" SELECT count(p) FROM SectionFocus p WHERE p.state.name ='上线' ");
		StringBuffer dsql = new StringBuffer(" SELECT p FROM SectionFocus p WHERE  p.state.name ='上线' ");
		gr.setHsql(true);
		StringBuffer sb = new StringBuffer();
		if (StringHelper.isNotBlank(section)) {
			sb.append(" AND p.section=").append(section);
		}
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
		sb.append(" order by p.topDate desc,p.distributeDate desc");
		gr.setCsql(csql.append(sb).toString());
		gr.setDsql(dsql.append(sb).toString());
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}
	public void getSectionFocusMobileHasOffline() {
		// SELECT * FROM articlePad WHERE state=(SELECT id FROM state WHERE
		// previd IS NOT NULL AND nextid IS NULL AND nodetype=3)
		String section = getString("section");
		GridPageRequest gr = new GridPageRequest(getRequest());
//		StringBuffer csql = new StringBuffer(" SELECT count(p) FROM SectionFocus p  WHERE p.state.next is null  and p.state.nodeType=" + State.TYPE_SECTION_MOBILE);
//		StringBuffer dsql = new StringBuffer(" SELECT p FROM SectionFocus p WHERE p.state.next is null  and p.state.nodeType=" + State.TYPE_SECTION_MOBILE);
		StringBuffer csql = new StringBuffer(" SELECT count(p) FROM SectionFocus p WHERE p.state.name ='下线' ");
		StringBuffer dsql = new StringBuffer(" SELECT p FROM SectionFocus p WHERE p.state.name = '下线' ");
		gr.setHsql(true);
		StringBuffer sb = new StringBuffer();
		if (StringHelper.isNotBlank(section)) {
			sb.append(" AND p.section=").append(section);
		}
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

	public void distribute() {
		try {
			service.distribute(getId());
			Write("OK");
		} catch (Exception e) {
			e.printStackTrace();
			Write("NO");
		}
	}

	public SectionFocusMobileDistributeService getService() {
		return service;
	}

	public void setService(SectionFocusMobileDistributeService service) {
		this.service = service;
	}

	public void display() {
		try {
			service.display(getId());
			Write("OK");
		} catch (Exception e) {
			e.printStackTrace();
			Write("NO");
		}
	}
	
	public void hidden() {
		try {
			service.hidden(getId());
			Write("OK");
		} catch (Exception e) {
			e.printStackTrace();
			Write("NO");
		}
	}
	public void ajaxToTop() {
		Integer id = getId();
		try {
			service.toTop(id);
			Write(OK);
		} catch (Exception e) {
			e.printStackTrace();
			Write(NO);
		}
	}
}
