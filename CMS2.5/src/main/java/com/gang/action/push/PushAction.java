package com.gang.action.push;

import java.util.List;

import javax.servlet.http.HttpServletRequest;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.hot.ArticleMobileHot;
import com.gang.entity.message.Message;
import com.gang.entity.push.Push;
import com.gang.entity.push.PushConfig;
import com.gang.service.push.PushService;

public class PushAction extends DefaultAction {
	private static final long serialVersionUID = 1L;
	public PushService service;
	public Push push;
	public Push getPush() {
		return push;
	}
	public void setPush(Push push) {
		this.push = push;
	}
	public PushService getService() {
		return service;
	}
	public void setService(PushService service) {
		this.service = service;
	}
	@Override
	public void add(HttpServletRequest req) throws Exception {
		List<Message> messages=service.getList("FROM Message ");
		req.setAttribute("messages", messages);
		
	}
	@Override
	public void getList() throws Exception {
		try {
			GridPageRequest gr = new GridPageRequest(getRequest());
			StringBuffer csql = new StringBuffer("SELECT count(p) FROM Push p  ");
			StringBuffer dsql = new StringBuffer("SELECT p FROM Push p ");
			gr.setHsql(true);
			gr.setCsql(csql.toString());
			gr.setDsql(dsql.toString());
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	@Override
	public void doSave() throws Exception {
		service.Push(push);
	}
	@Override
	public void delete(Integer id) throws Exception {
		// TODO Auto-generated method stub
		service.delete(Push.class, id);
	}

	@Override
	public void ajaxDelete(Integer id) throws Exception {
		// TODO Auto-generated method stub
		service.delete(Push.class, id);
	}
	
	public void checkPushPasswrod()
	{
		PushConfig pc = service.get(PushConfig.class, 1);
		String pwd=this.getString("pwd");
		if(pc.getPushPwd().equals(pwd))
		{
			Write(OK);
		}
	}
	
}
