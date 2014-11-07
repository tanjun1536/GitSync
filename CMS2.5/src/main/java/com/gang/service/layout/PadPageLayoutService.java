package com.gang.service.layout;

import java.util.List;
import java.util.Set;

import org.hibernate.Hibernate;

import com.gang.entity.article.Article;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.imagecontent.PadImageContent;
import com.gang.entity.layout.PadPageLayout;
import com.gang.entity.layout.PadPageLayoutArticle;
import com.gang.entity.process.State;
import com.gang.service.BaseService;

public class PadPageLayoutService extends BaseService {
	public List<PadPageLayoutArticle> getLayoutArticles(Integer id)
	{
		String hql=" FROM PadPageLayoutArticle p WHERE p.layout.id=? order by p.orderNumber";
		return  getSession().createQuery(hql).setInteger(0, id).list();
	}
	@Override
	public void save(Object o)
	{
		PadPageLayout layout=(PadPageLayout)o;
		if(layout.getId()!=null)
		{
			//删除原来的选择
			String hql="DELETE FROM PadPageLayoutArticle p WHERE p.layout.id="+layout.getId();
			execHql(hql);
		}
		super.save(layout);
	}
	public void OffLinePadPage(Integer id) {
		PadPageLayout layout=get(PadPageLayout.class, id);
		layout.setState(-1);
		if(layout.getArticles()!=null && layout.getArticles().size()>0)
		{
			State statePad=getPrepareDistributeState(State.TYPE_ARTICLE_PAD);
			State statePadImage=getPrepareDistributeState(State.TYPE_IMAGE_ARTICLE_PAD);
			for(PadPageLayoutArticle padPageLayoutArticle:layout.getArticles())
			{
				Article article=null;
				if("0".equals(padPageLayoutArticle.getType()))
				{
					article=get(ArticlePad.class, padPageLayoutArticle.getArticle());
					article.setState(statePad);
				}
				else
				{
					article=get(PadImageContent.class, padPageLayoutArticle.getArticle());
					article.setState(statePadImage);
				}
				
			}
		}
		//getSession().saveOrUpdate(layout);
		
	}
}
