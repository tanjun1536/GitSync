package com.gang.action.sectiontype;

import javax.servlet.http.HttpServletRequest;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.section.SectionType;
import com.gang.service.sectiontype.SectionTypeService;


public class SectionTypeAction
  extends DefaultAction
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private SectionTypeService service;
	private SectionType        sectionType;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public SectionType getSectionType()
	{
		return sectionType;
	}

	public void setSectionType(SectionType sectionType)
	{
		this.sectionType = sectionType;
	}

	public void setService(SectionTypeService service)
	{
		this.service = service;
	}

	@Override
	public void getList()
		throws Exception
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		gr.setCsql ("SELECT COUNT(*) FROM SectionType ");
		gr.setDsql ("SELECT * FROM SectionType");
		gr.setGetAll (true);
		gr.setClazz (SectionType.class);
		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}
	@Override
	public void doSave() throws Exception {
		service.add(sectionType);
	}
	@Override
	public void edit(
	  Integer            id,
	  HttpServletRequest req)
		throws Exception
	{
		sectionType=service.get(SectionType.class, id);
		req.setAttribute("sectionType", sectionType);
	}
	@Override
	public void ajaxDelete(Integer id)
		throws Exception
	{
		try {
			service.delete(SectionType.class, id);
			Write(OK);
		} catch (Exception e) {
			Write(NO);
		}
		
	}
}
