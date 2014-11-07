package com.gang.service.imagecontent;

import java.util.Date;

import org.hibernate.Hibernate;

import com.gang.entity.imagecontent.PadImageContent;
import com.gang.entity.process.PadImageContentAudit;
import com.gang.entity.process.State;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;

public class PadImageContentAuditService extends BaseService{
	public void next(int id, BackUser user){
		State state = null;
		PadImageContent img = (PadImageContent)super.get(PadImageContent.class, id);
		Hibernate.initialize(state = img.getState());
		img.setState(img.getState().getNext());
		addAudit(img, state, user, null);
	}
	
	public void reject(int id, BackUser user, String reason){
		State state = null;
		PadImageContent img = (PadImageContent)super.get(PadImageContent.class, id);
		Hibernate.initialize(state = img.getState());
		img.setState(img.getState().getRejected());
		addAudit(img, state, user, reason);
	}
	
	protected void addAudit(PadImageContent img, State state, BackUser user, String reason){
		PadImageContentAudit audit = new PadImageContentAudit();
		audit.setImg(img);
		audit.setState(state);
		audit.setUserId(user.getId());
		audit.setUserName(user.getName());
		audit.setAuditDate(new Date());
		audit.setReason(reason);
		add(audit);
	}
	
	public PadImageContent getPadImageContent(int id){
		PadImageContent content = (PadImageContent)get(PadImageContent.class, id);
		Hibernate.initialize(content.getImages());
		Hibernate.initialize(content.getTemplate());
		Hibernate.initialize(content.getSection());
		return content;
	}
}

