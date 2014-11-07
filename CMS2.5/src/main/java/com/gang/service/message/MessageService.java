package com.gang.service.message;

import org.hibernate.Session;

import com.gang.entity.message.Message;
import com.gang.service.BaseService;

public class MessageService extends BaseService {
	
	public void deleteMessage(Integer id)
	{
		Session session=getSession();
		session.createSQLQuery("DELETE FROM message_articles WHERE msgId="+id).executeUpdate();
		session.delete(session.get(Message.class, id));
	}
}
