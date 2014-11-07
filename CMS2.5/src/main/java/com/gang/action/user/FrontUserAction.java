package com.gang.action.user;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.entity.user.FrontUser;
import com.gang.service.user.FrontUserService;
import com.gang.service.wssvc.Result;

public class FrontUserAction extends DefaultAction {

	private FrontUser user;
	private FrontUserService service;

	public void setService(FrontUserService service) {
		this.service = service;
	}

	public FrontUser getUser() {
		return user;
	}

	public void setUser(FrontUser user) {
		this.user = user;
	}


	/**
	 * 注册
	 * 
	 * @return
	 * @throws Exception
	 */
	public String register() throws Exception {
		Result ret = service.regisiter(user.getLoginName(), user.getLoginPassword(), user.getNickName(), null);
		addAttribute("ret", ret);
		if("pad".equals(user.getUserType()))
		return "pad";
		else return "phone";
	}
}
