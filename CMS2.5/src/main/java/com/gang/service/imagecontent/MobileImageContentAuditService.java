package com.gang.service.imagecontent;

import java.util.Date;

import org.hibernate.Hibernate;

import com.gang.entity.imagecontent.ImageContent;
import com.gang.entity.process.MobileImageContentAudit;
import com.gang.entity.process.State;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;

public class MobileImageContentAuditService extends BaseService{
	public void next(int id, BackUser user){
		State state = null;
		ImageContent img = (ImageContent)super.get(ImageContent.class, id);
		Hibernate.initialize(state = img.getState());
		img.setState(img.getState().getNext());
		addAudit(img, state, user, null);
	}
	
	public void reject(int id, BackUser user, String reason){
		State state = null;
		ImageContent img = (ImageContent)super.get(ImageContent.class, id);
		Hibernate.initialize(state = img.getState());
		img.setState(img.getState().getRejected());
		addAudit(img, state, user, reason);
	}
	
	protected void addAudit(ImageContent img, State state, BackUser user, String reason){
		MobileImageContentAudit audit = new MobileImageContentAudit();
		audit.setImg(img);
		audit.setState(state);
		audit.setUserId(user.getId());
		audit.setUserName(user.getName());
		audit.setAuditDate(new Date());
		audit.setReason(reason);
		add(audit);
	}
	
	public ImageContent getImageContent(int id){
		ImageContent content = (ImageContent)get(ImageContent.class, id);
		Hibernate.initialize(content.getImages());
		Hibernate.initialize(content.getTemplate());
		Hibernate.initialize(content.getSection());
		return content;
	}
}

