package com.gang.service.comment;

import java.util.Iterator;

import org.hibernate.Hibernate;
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Projections;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.HibernateUtil;
import com.gang.comms.JSONHelper;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.comment.ArticleMobileComment;
import com.gang.entity.section.Section;
import com.gang.service.BaseService;

public class ArticleMobileCommentService extends BaseService {
	
	public String getDoAuditComments(GridPageRequest req){
		GridPageResponse gpr = new GridPageResponse();
		String hqlC = "SELECT COUNT(a.id) FROM ArticleMobile a WHERE (SELECT COUNT(c.id) FROM ArticleMobileComment c WHERE a=c.article AND auditStatus='" + ArticleMobileComment.AUDIT_ING + "') > 0";
		String hql = "FROM ArticleMobile a WHERE (SELECT COUNT(c.id) FROM ArticleMobileComment c WHERE a=c.article AND auditStatus='" + ArticleMobileComment.AUDIT_ING + "') > 0";
		int count = Integer.parseInt(getSession().createQuery(hqlC).uniqueResult().toString());
		if(count > 0){
			gpr.setRows(getSession().createQuery(hql).setFirstResult(req.getStartNumber()).setMaxResults(req.getPageSize()).list());
		}
		else if(count == 0){
			//假设有1条数据
			count = 1;
		}
		Iterator<ArticleMobile> ams = gpr.getRows().iterator();
		while(ams.hasNext()){
			ArticleMobile pada = ams.next();
			Hibernate.initialize(pada.getSection());
			pada.setSection((Section)HibernateUtil.getUnproxiedValue(pada.getSection()));
		}
		gpr.setPage(req.getPageIndex());
		gpr.setRecords(count);
		gpr.setTotal((int)Math.ceil((float)count/req.getPageSize()));
		return JSONHelper.SerializeWithNeedAnnotation(gpr);
	}
	
	public GridPageResponse getComments(Integer articleId, GridPageRequest req){
		GridPageResponse gpr = new GridPageResponse();
		int count = Integer.parseInt(getCriteria(ArticleMobileComment.class).add(Restrictions.or(Restrictions.eq("auditStatus", ArticleMobileComment.AUDIT_PASS), Restrictions.eq("auditStatus", ArticleMobileComment.AUDIT_NONE))).setProjection(Projections.count("id")).uniqueResult().toString());
		if(count > 0){
			gpr.setRows(getCriteria(ArticleMobileComment.class).add(org.hibernate.criterion.Restrictions.eq("article.id", articleId)).add(Restrictions.or(Restrictions.eq("auditStatus", ArticleMobileComment.AUDIT_PASS), Restrictions.eq("auditStatus", ArticleMobileComment.AUDIT_NONE))).setFirstResult(req.getStartNumber()).setMaxResults(req.getPageSize()).addOrder(Order.desc("postDate")).list());
		}
		else if(count == 0){
			//假设有1条数据
			count = 1;
		}
		gpr.setPage(req.getPageIndex());
		gpr.setRecords(count);
		gpr.setTotal((int)Math.ceil((float)count/req.getPageSize()));
		return gpr;
	}
	
	public String getAuditComments(Integer articleId, GridPageRequest req){
		GridPageResponse gpr = new GridPageResponse();
		int count = Integer.parseInt(getCriteria(ArticleMobileComment.class).add(Restrictions.eq("auditStatus", ArticleMobileComment.AUDIT_ING)).setProjection(Projections.count("id")).uniqueResult().toString());
		if(count > 0){
			gpr.setRows(getCriteria(ArticleMobileComment.class).add(org.hibernate.criterion.Restrictions.eq("article.id", articleId)).add(Restrictions.eq("auditStatus", ArticleMobileComment.AUDIT_ING)).setFirstResult(req.getStartNumber()).setMaxResults(req.getPageSize()).addOrder(Order.desc("postDate")).list());
		}
		else if(count == 0){
			//假设有1条数据
			count = 1;
		}
		gpr.setPage(req.getPageIndex());
		gpr.setRecords(count);
		gpr.setTotal((int)Math.ceil((float)count/req.getPageSize()));
		return JSONHelper.SerializeWithNeedAnnotation(gpr);
	}
	
	
	public void add(ArticleMobileComment entity) {
		ArticleMobile am = get(ArticleMobile.class, entity.getArticle().getId());
		if(am.getSection().getCommentAudit() != null && am.getSection().getCommentAudit()){
			entity.setAuditStatus(ArticleMobileComment.AUDIT_ING);
		}
		else{
			entity.setAuditStatus(ArticleMobileComment.AUDIT_NONE);
		}
		super.add(entity);
	}
	
	public void changeStatus(String[] ids, String audit){
		Integer[] idsi = new Integer[ids.length];
		for (int i = 0; i < idsi.length; i++) {
			idsi[i] = Integer.parseInt(ids[i]);
		}
		String hql = "UPDATE ArticleMobileComment SET auditStatus=:s WHERE id in (:ids)";
		getSession().createQuery(hql).setString("s", audit).setParameterList("ids", idsi).executeUpdate();
	}
}
