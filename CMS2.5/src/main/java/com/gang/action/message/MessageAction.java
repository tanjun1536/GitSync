package com.gang.action.message;

import javax.servlet.http.HttpServletRequest;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.LazyKiller;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.message.Message;
import com.gang.entity.section.Section;
import com.gang.service.message.MessageService;

public class MessageAction extends DefaultAction {
	private MessageService service;
	public MessageService getService() {
		return service;
	}

	public void setService(MessageService service) {
		this.service = service;
	}

	public Message getMessage() {
		return message;
	}

	public void setMessage(Message message) {
		this.message = message;
	}

	private Message message;
	
	@Override
	public void getList() throws Exception {
		try {
			GridPageRequest gr = new GridPageRequest(getRequest());
			StringBuffer csql = new StringBuffer("SELECT COUNT(m) FROM  Message m ");
			StringBuffer dsql = new StringBuffer("SELECT m FROM Message m");
			gr.setHsql(true);
			gr.setCsql(csql.toString());
			gr.setDsql(dsql.toString());
			gr.setClazz(Message.class);
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
		
	}
	
	public void getArticleList()
	{
		Integer msgId=getInteger("msgId");
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer("SELECT COUNT(article.id) FROM  Message  m inner join m.articles article WHERE m.id = "+msgId);
		StringBuffer dsql = new StringBuffer("SELECT article FROM Message  m inner join m.articles article WHERE m.id = "+msgId);
		gr.setHsql(true);
		gr.setCsql(csql.toString());
		gr.setTableAlias("article");
		gr.setDsql(dsql.toString());
		gr.setClazz(ArticleMobile.class);
		gr.setGetAll(true);
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}
	
	@Override
	public void doSave() throws Exception {
		service.save(message);
	}
	@Override
	public void edit(Integer id, HttpServletRequest req) throws Exception {
		// TODO Auto-generated method stub
		
		 message=service.get(Message.class, id,new LazyKiller().addLazyProperty("getArticles"));
		 req.setAttribute("message", message);
		 
	}
	@Override
	public void ajaxDelete(Integer id) throws Exception {
		// TODO Auto-generated method stub
		service.deleteMessage(id);
	}
	
	public void getArticleMobile()
			throws Exception
		{
			GridPageRequest gr = new GridPageRequest(getRequest ());
			StringBuffer    csql = new StringBuffer("SELECT count(a) FROM ArticleMobile a WHERE  (1=1)");
			StringBuffer    dsql = new StringBuffer("SELECT a FROM ArticleMobile a WHERE  (1=1)");
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
}
