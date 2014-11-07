package com.gang.action.user;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.user.FeedBack;
import com.gang.service.user.FeedBackService;
import com.gang.service.wssvc.Result;

public class FeedBackAction extends DefaultAction {

	private FeedBack fd;
	private FeedBackService service;

	@Override
	public void ajaxDelete(Integer id) throws Exception {
		service.delete(FeedBack.class, id);
	}
	public FeedBack getFd() {
		return fd;
	}

	@Override
	public void getList() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer(" SELECT count(a) FROM FeedBack a");
		StringBuffer dsql = new StringBuffer(" SELECT a FROM FeedBack a");
		gr.setHsql(true);
		gr.setTableAlias("a");
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(FeedBack.class);
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);

	}

	public FeedBackService getService() {
		return service;
	}

	@Override
	public String save() throws Exception {
		// TODO Auto-generated method stub
		return null;
	}

	public void setFd(FeedBack fd) {
		this.fd = fd;
	}

	public void setService(FeedBackService service) {
		this.service = service;
	}

	@Override
	public String update() throws Exception {
		// TODO Auto-generated method stub
		return null;
	}

	public String addFeedBack() {
		Result ret = new Result();
		try {
			service.add(fd);
			ret.setMsg("操作成功!");
		} catch (Exception e) {
			ret.setMsg("操作失败!");
		}
		addAttribute("ret", ret);
		if ("pad".equals(fd.getClientType()))
			return "pad";
		else
			return "phone";
	}

}
