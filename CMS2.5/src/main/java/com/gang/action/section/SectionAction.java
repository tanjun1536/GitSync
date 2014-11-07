package com.gang.action.section;

import java.util.List;
import java.util.Set;

import javax.servlet.http.HttpServletRequest;

import org.hibernate.Hibernate;

import com.gang.action.DefaultAction;
import com.gang.comms.BackUserProxy;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.section.Section;
import com.gang.entity.section.SectionAdapter;
import com.gang.entity.section.SectionShowType;
import com.gang.entity.section.SectionType;
import com.gang.service.section.SectionService;

public class SectionAction extends DefaultAction {
	// ~ Instance fields
	// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private SectionService service;
	private Section section;

	// ~ Methods
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public Section getSection() {
		return section;
	}

	public void setSection(Section section) {
		this.section = section;
	}

	public SectionService getService() {
		return service;
	}

	public void setService(SectionService service) {
		this.service = service;
	}

	public void getSectionTreeXML() throws Exception {
		String xml = service.getSectionTreeXML();
		WriteXml(xml);
	}

	public void getSectionTreeJSON() throws Exception {
		Object json = getSession().getAttribute(SESSION_SECTION_ALL);

		if (json == null) {
			json = service.getSectionTreeJSON();
			getSession().setAttribute(SESSION_SECTION_ALL, json);
		}

		Write(json.toString());
	}

	@Override
	public void add(HttpServletRequest req) throws Exception {
		List<SectionAdapter> adapters = service.getList(SectionAdapter.class);
		req.setAttribute("adapters", adapters);

		List<SectionType> types = service.getList(SectionType.class);
		req.setAttribute("types", types);

		List<SectionShowType> showtypes = service
				.getList(SectionShowType.class);
		req.setAttribute("showtypes", showtypes);
	}

	@Override
	public void getList() {
		GridPageRequest gr = new GridPageRequest(getRequest());
		String name = getString("name");

		if ((name != null) && !"".equals(name)) {
			gr.setCsql("SELECT COUNT(*) FROM Section WHERE  (text like '%"
					+ name
					+ "%' OR parentId in (select id from Section where text like '%"
					+ name + "%'))");
			gr.setDsql("SELECT s.isHot,s.id,s.commentAudit,s.text,s.open,s.orderNumber,s.foucusImage,s.shown,s.createDate,s.adapterTerminal,s.parentId,s.sectionType,s.showType,S.MOBILETITLEIMAGE,S.PADTITLEIMAGE,s.articleCount FROM section s WHERE  (s.text like '%"
					+ name
					+ "%' OR s.parentid in (select id from Section where text like '%"
					+ name + "%'))");
		} else {
			gr.setCsql("SELECT COUNT(*) FROM Section  ");
			gr.setDsql("SELECT s.isHot,s.id,s.commentAudit,s.text,s.open,s.orderNumber,s.foucusImage,s.shown,s.createDate,s.adapterTerminal,s.parentId,s.sectionType,s.showType,S.MOBILETITLEIMAGE,s.PADTITLEIMAGE,s.articleCount FROM section s  ");
		}

		gr.setClazz(Section.class);
		gr.addCglibProperty("getAdapterTerminal")
				.addCglibProperty("getSectionType")
				.addCglibProperty("getShowType");
		gr.addLazyProperty("getChildren",
				new GridPageRequest.AddLazyPropertyHandler() {
					@Override
					public void handler(Object o) {
						Section s = (Section) o;
						loadChildren(s);
					}
				});

		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	private void loadChildren(Section s) {
		Set<Section> ss = s.getChildren();

		for (Section sec : ss) {
			Hibernate.initialize(sec.getChildren());

			if (sec.getChildren() != null) {
				loadChildren(sec);
			}
		}
	}

	@Override
	public String edit() throws Exception {
		Integer id = getId();
		Object section = service.get(Section.class, id);
		getRequest().setAttribute("section", section);

		return add();
	}

	@Override
	public void doSave() throws Exception {
		service.save(section);
		reloadSectionTree();
	}

	@Override
	public String update() throws Exception {
		return save();
	}

	@Override
	public void ajaxDelete() throws Exception {
		try {
			Integer id = getId();
			service.delete(id);
			reloadSectionTree();
			Write(OK);
		} catch (Exception e) {
			e.printStackTrace();
			Write(NO);
		}
	}

	public void getSectionType() {
		try {
			Integer id = getId();
			int type = service.getSectionType(id);
			Write(type + "");
		} catch (Exception e) {
			e.printStackTrace();
			Write("2");
		}
	}

	public void getSections() {
		BackUserProxy proxy = new BackUserProxy(getBackUser());
		String json = service.getSectionsJson(proxy.getRoleIds());
		System.out.println(json);
		Write(json);
	}

	public void getSectionsByType() {
		Object json = getSession().getAttribute(SESSION_SECTION_USER);
		if (json == null) {
			Integer type = getInteger("type");
			BackUserProxy proxy = new BackUserProxy(getBackUser());
			json = service.getSectionsJson(proxy.getRoleIds(), type);
			getSession().setAttribute(SESSION_SECTION_USER, json);
		}
		Write(json.toString());
	}

	private void reloadSectionTree() {
		getSession().setAttribute(SESSION_SECTION_ALL, null);
		getSession().setAttribute(SESSION_SECTION_USER, null);
	}
}
