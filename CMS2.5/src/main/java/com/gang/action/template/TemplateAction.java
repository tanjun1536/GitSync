package com.gang.action.template;

import com.gang.action.DefaultAction;
import com.gang.service.template.TemplateService;

public class TemplateAction extends DefaultAction {

	private TemplateService service;

	public TemplateService getService() {
		return service;
	}

	public void setService(TemplateService service) {
		this.service = service;
	}


}
