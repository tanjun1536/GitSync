package com.gang.action.system;

import com.gang.action.DefaultAction;
import com.gang.service.system.SystemService;

public class SystemAction extends DefaultAction {
	private SystemService service;

	public SystemService getService() {
		return service;
	}

	public void setService(SystemService service) {
		this.service = service;
	}

}
