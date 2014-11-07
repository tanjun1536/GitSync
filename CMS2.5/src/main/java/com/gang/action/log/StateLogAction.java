package com.gang.action.log;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.user.BackUser;
import com.gang.service.process.StateService;

public class StateLogAction extends DefaultAction{

	private StateService service;
	private Integer dataId;
	private Integer type;
	public void setService(StateService service) {
		this.service = service;
	}

	private String getWhere(){
		StringBuilder where = new StringBuilder(" WHERE 1=1 ");
		if(getDataId() != null && getType() != null){
			where.append(" AND logType=" + getType() + " AND dataId=" + getDataId());
		}
		return where.toString();
	}
	@Override
	public void getList() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());
		String where = getWhere();
		gr.setCsql("SELECT COUNT(*) FROM StateLog " + where);
		gr.setDsql("FROM StateLog " + where + " ORDER BY date DESC");
		gr.setHsql(true);
		gr.addCglibProperty("getUser", new GridPageRequest.AddCglibPropertyHandler() {
			@Override
			public void handler(Object unprox) {
				BackUser user=(BackUser)unprox;
				user.setDepartment(null);
				user.setRoles(null);
			}
		});
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	public Integer getDataId() {
		return dataId;
	}

	public void setDataId(Integer dataId) {
		this.dataId = dataId;
	}

	public Integer getType() {
		return type;
	}

	public void setType(Integer type) {
		this.type = type;
	}

}
