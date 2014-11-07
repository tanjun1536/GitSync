package com.gang.service.article;

import com.gang.comms.CollectionHelper;
import com.gang.comms.LazyKiller;

import com.gang.entity.article.Article;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.comment.ArticleMobileComment;
import com.gang.entity.layout.PadPageLayout;
import com.gang.entity.layout.PadPageLayoutArticle;
import com.gang.entity.log.StateLog;
import com.gang.entity.process.State;
import com.gang.entity.user.BackUser;

import com.gang.service.BaseService;
import com.gang.service.log.StateLogService;

import org.hibernate.Hibernate;
import org.hibernate.HibernateException;
import org.hibernate.Query;
import org.hibernate.Session;

import org.hibernate.criterion.Restrictions;

import org.springframework.orm.hibernate3.HibernateCallback;

import java.sql.SQLException;

import java.util.Date;
import java.util.List;


public class ArticleService
  extends BaseService
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private StateLogService logService;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public StateLogService getLogService()
	{
		return logService;
	}

	public void setLogService(StateLogService logService)
	{
		this.logService = logService;
	}

	public void saveMobile(
	  Article  entity,
	  BackUser user)
	{
		try
		{
			State state = get(State.class, entity.getState().getId());
			entity.setState(state);
			save(entity);

			if (CollectionHelper.isNotEmpty(entity.getRelatedArticles()))
			{
				for (ArticleMobile am : entity.getRelatedArticles())
				{
					am = get(ArticleMobile.class, am.getId());
					am.setVersion(am.getVersion() + 1);
				}
			}
			logService.addLog(StateLog.Mobile_Article, entity.getState().getId(), entity.getState().getName(), user, entity.getId());
		}
		catch (Exception e)
		{
			e.printStackTrace();
		}
	}

	public void savePad(
	  Article  entity,
	  BackUser user)
	{
		State state = get(State.class, entity.getState().getId());
		entity.setState(state);
		save(entity);

		logService.addLog(StateLog.Pad_Article, entity.getState().getId(), entity.getState().getName(), user, entity.getId());
	}

	public List<Article> getArticles()
	{
		List<Article> as = getCriteria(Article.class)
			                   .list();

		return as;
	}

	public List<Article> getArtListBySectionId(int sectionId)
	{
		List<Article> as = getCriteria(Article.class)
			                   .add(Restrictions.eq("section.id", sectionId))
			                   .list();

		return as;
	}

	public List<ArticleMobile> getMobileArticle(int sectionId)
	{
		List<ArticleMobile> ams = getCriteria(ArticleMobile.class)
			                          .add(Restrictions.eq("section.id", sectionId))
			                          .list();

		for (ArticleMobile articleMobile : ams)
		{
			Hibernate.initialize(articleMobile.getSection());
		}

		return ams;
	}

	public List<ArticlePad> getPadArticle(int sectionId)
	{
		List<ArticlePad> aps = getCriteria(ArticlePad.class)
			                       .add(Restrictions.eq("section.id", sectionId))
			                       .list();

		for (ArticlePad articlePad : aps)
		{
			Hibernate.initialize(articlePad.getSection());
		}

		return aps;
	}

	public PadPageLayout getLayout(Integer articleId)
	{
		PadPageLayoutArticle layoutArticle = get(PadPageLayoutArticle.class, articleId);

		if (layoutArticle != null)
		{
			return layoutArticle.getLayout();
		}

		return null;
	}

	public void toTop(
	  Integer id,
	  Class   clazz)
	{
		Article article = get(clazz, id);
		article.setTopDate(new Date());
	}

	public void changeToEditState(
	  Integer id,
	  Class   clazz)
	{
		Article article = get(clazz, id);
		article.setState(getEditState(State.TYPE_ARTICLE_MOBILE));
	}

	public void next(
	  Integer id,
	  Class   clazz)
	{
		Article article = get(clazz, id);
		article.setVersion(article.getVersion() + 1);
		article.setState(article.getState().getNext());
	}
	
	public List<ArticleMobileComment> getComments(Integer doc_id,Integer page_index,Integer page_size)
	{
		String sql="SELECT * FROM ArticleMobileComment WHERE ArticleId="+doc_id+" order by id desc";
		Session session=getSession();
		Query q=session.createSQLQuery(sql).addEntity(ArticleMobileComment.class).setFirstResult((page_index-1)*page_size).setMaxResults(page_size);
		List<ArticleMobileComment> list=q.list();
		if(list!=null && list.size()>0)
		{
			for(ArticleMobileComment comment:list)
			{
				Hibernate.initialize(comment.getArticle());
			}
			
		}
		
		return list;
	}
	
	public Integer getCommentsCount(Integer doc_id)
	{
		String sql="SELECT COUNT(*) FROM ArticleMobileComment WHERE ArticleId="+doc_id;
		Session session=getSession();
		Query q=session.createSQLQuery(sql).setMaxResults(1);
		
		return Integer.parseInt(q.uniqueResult().toString());
		
	}
}
