package com.gang.action.login;

import com.gang.action.DefaultAction;
import com.gang.entity.user.BackUser;
import com.gang.service.login.LoginService;

public class LoginAction extends DefaultAction {
	private LoginService service;

	public LoginService getService() {
		return service;
	}

	public void setService(LoginService service) {
		this.service = service;
	}
	
	@Override
	public String execute() throws Exception {
		String username = getString("j_username");
		String password = getString("j_password");
		if(username==null||password==null)
		{
			return "login";
		}
		BackUser user=service.login(username, password);
		if (user!=null) {
			getRequest().getSession().setAttribute(SESSION_BACK_USER, user);
			return "index";
		}
		getRequest().setAttribute("F", 1);
		return "login";
	}
	public String logOut()
	{
		getRequest().getSession().invalidate();
		return "login";
	}
}
