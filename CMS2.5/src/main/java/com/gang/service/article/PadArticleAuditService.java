package com.gang.service.article;

import java.util.Date;

import org.hibernate.Hibernate;

import com.gang.entity.article.ArticlePad;
import com.gang.entity.process.PadArticleAudit;
import com.gang.entity.process.State;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;

public class PadArticleAuditService extends BaseService{
	public void next(int id, BackUser user){
		State state = null;
		ArticlePad article = (ArticlePad)super.get(ArticlePad.class, id);
		Hibernate.initialize(state = article.getState());
		article.setState(article.getState().getNext());
		addAudit(article, state, user, null);
	}
	
	public void reject(int id, BackUser user, String reason){
		State state = null;
		ArticlePad article = (ArticlePad)super.get(ArticlePad.class, id);
		Hibernate.initialize(state = article.getState());
		article.setState(article.getState().getRejected());
		addAudit(article, state, user, reason);
	}
	
	protected void addAudit(ArticlePad article, State state, BackUser user, String reason){
		PadArticleAudit audit = new PadArticleAudit();
		audit.setArticle(article);
		audit.setState(state);
		audit.setUserId(user.getId());
		audit.setUserName(user.getName());
		audit.setAuditDate(new Date());
		audit.setReason(reason);
		add(audit);
	}
	
	public ArticlePad getArt(int id){
		ArticlePad article = (ArticlePad) get(ArticlePad.class, id);
		Hibernate.initialize(article.getSection());
		return article;
	}
}

