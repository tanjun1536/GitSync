package com.gang.service.imagecontent;

import java.util.ArrayList;
import java.util.List;

import org.hibernate.Hibernate;
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.HibernateUtil;
import com.gang.entity.imagecontent.ImageContent;
import com.gang.entity.imagecontent.PadImageContent;
import com.gang.entity.process.State;
import com.gang.service.BaseService;

public class PadImageContentService extends BaseService{

	public void update(PadImageContent entity){
		PadImageContent old = (PadImageContent)get(PadImageContent.class, entity.getId());
		old.setTitle(entity.getTitle());
		old.setSubTitle(entity.getSubTitle());
		old.setEditor(entity.getEditor());
		old.setKeywords(entity.getKeywords());
		old.setSection(entity.getSection());
		old.setSummary(entity.getSummary());
		old.setSource(entity.getSource());
		old.setTemplate(entity.getTemplate());
		Hibernate.initialize(old.getImages());
		old.getImages().clear();
		old.getImages().addAll(entity.getImages());
		old.setState(entity.getState());
	}
	
	public PadImageContent getPadImageContent(int id){
		PadImageContent content = (PadImageContent)get(PadImageContent.class, id);
		Hibernate.initialize(content.getImages());
		Hibernate.initialize(content.getTemplate());
		return content;
	}
	
	public void delete(int id){
		PadImageContent entity = getPadImageContent(id);
		getHibernateTemplate().delete(entity);
	}
	
	public List<State> getStates(int type) {
		List<State> states = new ArrayList<State>();
		State s = (State) getCriteria(State.class).add(Restrictions.eq("nodeType", type)).addOrder(Order.asc("id")).list().get(0);
		states.add((State) HibernateUtil.getUnproxiedValue(s));
		states.add((State) HibernateUtil.getUnproxiedValue(s.getNext()));
		return states;
	}
}
