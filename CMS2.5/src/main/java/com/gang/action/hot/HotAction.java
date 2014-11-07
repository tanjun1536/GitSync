package com.gang.action.hot;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;
import com.gang.entity.hot.ArticleMobileHot;
import com.gang.entity.section.Section;
import com.gang.service.hot.HotService;

public class HotAction extends DefaultAction {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private HotService service;

	public HotService getService() {
		return service;
	}

	public void setService(HotService service) {
		this.service = service;
	}

	@Override
	public void getList() throws Exception {
		try {
			GridPageRequest gr = new GridPageRequest(getRequest());
			StringBuffer csql = new StringBuffer("SELECT COUNT(*) FROM (SELECT hot.id FROM articlemobilehot  hot INNER JOIN articlemobile article ON hot.articleId=article.id) c ");
			StringBuffer dsql = new StringBuffer("SELECT hot.id,article.`title`,article.`createDate` FROM articlemobilehot  hot INNER JOIN articlemobile article ON hot.articleId=article.id  order by hot.ordernumber asc");
			gr.setHsql(false);
			gr.setOrderBy(false);
			gr.setCsql(csql.toString());
			gr.setDsql(dsql.toString());
			gr.setClazz(ArticleMobileHot.class);
			gr.setUserResultTransformer(true);
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
		
	}
	public void getArticleMobile()
			throws Exception
		{
			GridPageRequest gr = new GridPageRequest(getRequest ());
			StringBuffer    csql = new StringBuffer("SELECT count(a) FROM ArticleMobile a WHERE a.id not in (SELECT h.articleId from ArticleMobileHot h)");
			StringBuffer    dsql = new StringBuffer("SELECT a FROM ArticleMobile a WHERE a.id not in (SELECT h.articleId from ArticleMobileHot h)");
			Integer         sectionId = getInteger ("sectionId");

			if ((sectionId != null) && (sectionId != 0))
			{
				csql.append (" AND a.section.id=" + sectionId);
				dsql.append (" AND a.section.id=" + sectionId);
			}

			dsql.append (" order by a.createDate desc ");

			gr.setHsql (true);
			gr.setCsql (csql.toString ());
			gr.setDsql (dsql.toString ());
			gr.addCglibProperty ("getSection",
			  new GridPageRequest.AddCglibPropertyHandler()
				{
					@Override
					public void handler(Object unprox)
					{
						Section section = (Section) unprox;

						if (section != null)
						{
							section.setChildren (null);
						}
					}
				});
			gr.addCglibProperty ("getState");

			GridPageResponse gpr = service.getGridPage (gr);
			String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
			Write (json);
		}
	@Override
	public void doSave() throws Exception {
		String idx = getString("idx");
		if (StringHelper.isNotBlank(idx)) {
			for (String id : idx.split(",")) {
				ArticleMobileHot hot = new ArticleMobileHot();
				hot.setArticleId(Integer.parseInt(id));
				service.addHot(hot);
			}
		}
	}

	@Override
	public void ajaxDelete(Integer id) throws Exception {
		// TODO Auto-generated method stub
		service.delete(ArticleMobileHot.class, id);
	}
	
	public void ChangeOrder()
	{
		try {
			Integer id =getId();
			Integer ord=getInteger("order");
			String sql="UPDATE articlemobilehot SET orderNumber="+ord+" WHERE id="+id;
			service.exec(sql);
		} catch (Exception e) {
			e.printStackTrace();
		}
		
	}

}
