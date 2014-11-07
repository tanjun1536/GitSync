package com.gang.service.section;

import java.util.Date;

import org.hibernate.Hibernate;

import com.gang.entity.process.PadSectionFocusAudit;
import com.gang.entity.process.State;
import com.gang.entity.section.PadSectionFocus;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;

public class PadSectionFocusAuditService extends BaseService {
	public void next(int id, BackUser user){
		State state = null;
		PadSectionFocus focus = (PadSectionFocus)super.get(PadSectionFocus.class, id);
		Hibernate.initialize(state = focus.getState());
		focus.setState(focus.getState().getNext());
		addAudit(focus, state, user, null);
	}
	
	public void reject(int id, BackUser user, String reason){
		State state = null;
		PadSectionFocus focus = (PadSectionFocus)super.get(PadSectionFocus.class, id);
		Hibernate.initialize(state = focus.getState());
		focus.setState(focus.getState().getRejected());
		addAudit(focus, state, user, reason);
	}
	
	protected void addAudit(PadSectionFocus focus, State state, BackUser user, String reason){
		PadSectionFocusAudit audit = new PadSectionFocusAudit();
		audit.setFocus(focus);
		audit.setState(state);
		audit.setUserId(user.getId());
		audit.setUserName(user.getName());
		audit.setAuditDate(new Date());
		audit.setReason(reason);
		add(audit);
	}
}
