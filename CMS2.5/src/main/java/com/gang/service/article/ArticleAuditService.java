package com.gang.service.article;

import java.util.Date;

import org.hibernate.Hibernate;

import com.gang.entity.article.ArticleMobile;
import com.gang.entity.log.StateLog;
import com.gang.entity.process.ArticleAudit;
import com.gang.entity.process.State;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;
import com.gang.service.log.StateLogService;

public class ArticleAuditService extends BaseService{
	
	private StateLogService logService;
	
	public StateLogService getLogService() {
		return logService;
	}

	public void setLogService(StateLogService logService) {
		this.logService = logService;
	}
	
	public void next(int id, BackUser user){
		State state = null;
		ArticleMobile article = (ArticleMobile)super.get(ArticleMobile.class, id);
		Hibernate.initialize(state = article.getState());
		article.setState(article.getState().getNext());
		addAudit(article, state, user, null);
	}
	
	public void reject(int id, BackUser user, String reason){
		State state = null;
		ArticleMobile article = (ArticleMobile)super.get(ArticleMobile.class, id);
		Hibernate.initialize(state = article.getState());
		article.setState(article.getState().getRejected());
		addAudit(article, state, user, reason);
	}
	
	protected void addAudit(ArticleMobile article, State state, BackUser user, String reason){
		ArticleAudit audit = new ArticleAudit();
		audit.setArticle(article);
		audit.setState(state);
		audit.setUserId(user.getId());
		audit.setUserName(user.getName());
		audit.setAuditDate(new Date());
		audit.setReason(reason);
		add(audit);
		//添加日志
		logService.addLog(StateLog.Mobile_Article, state.getId(), state.getName(), user, article.getId());
	}
	
	public ArticleMobile getArt(int id){
		ArticleMobile article = (ArticleMobile) get(ArticleMobile.class, id);
		Hibernate.initialize(article.getSection());
		return article;
	}
}

