package com.gang.service.section;

import java.util.ArrayList;
import java.util.List;

import org.hibernate.Session;
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Projections;
import org.hibernate.criterion.Restrictions;
import org.springframework.orm.hibernate3.HibernateTemplate;

import com.gang.comms.HibernateUtil;
import com.gang.entity.process.State;
import com.gang.entity.section.PadSectionFocus;
import com.gang.service.BaseService;

public class PadSectionFocusService extends BaseService {
	public void delete(int id) {
		HibernateTemplate template = getHibernateTemplate();
		PadSectionFocus focus = (PadSectionFocus) template.get(PadSectionFocus.class, id);
		template.delete(focus);
	}
	public void save(PadSectionFocus focus){
		this.getSession().save(focus);
	}
	public void update(PadSectionFocus focus){
		Session session = getSession();
		PadSectionFocus oldFocus = (PadSectionFocus) session.get(PadSectionFocus.class, focus.getId());
		oldFocus.setArticle(focus.getArticle());
		oldFocus.setTitle(focus.getTitle());
		oldFocus.setImagePath(focus.getImagePath());
		oldFocus.setSection(focus.getSection());
		oldFocus.setContent(focus.getContent());
		oldFocus.setFocusLink(focus.getFocusLink());
		oldFocus.setState(focus.getState());
//		oldFocus.setOrderNumber(focus.getOrderNumber());
//		this.getSession().update(focus);
	}
	
	/**
	 * 最大的Sort
	 * @return
	 */
	public Integer maxSort(){
		Integer max = null;
		try {
			max = Integer.parseInt(getCriteria(PadSectionFocus.class).setProjection(Projections.max("orderNumber")).uniqueResult() + "");
		} catch (Exception e) {
			e.printStackTrace();
		}
		if(null == max){
			return 1;
		}
		return max + 1;
	}
	
	//按ID查找Sort
	protected Integer getSortById(int id){
		Integer sort = null;
		try {
			sort = Integer.parseInt(getCriteria(PadSectionFocus.class).add(Restrictions.idEq(id)).setProjection(Projections.property("orderNumber")).uniqueResult() + "");
		} catch (Exception e) {
			e.printStackTrace();
		}
		if(null == sort){
			return 1;
		}
		return sort;
	}
	//下一个ID和Sort
	protected PadSectionFocus getToNext(int sortNumber){
		PadSectionFocus res = null;
		try {
			res = (PadSectionFocus)getCriteria(PadSectionFocus.class).add(Restrictions.gt("orderNumber", sortNumber)).add(Restrictions.isNotNull("orderNumber")).setMaxResults(1).addOrder(Order.asc("orderNumber")).list().get(0);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return res;
	}
	//上一个ID和Sort
	protected PadSectionFocus getToUp(int sortNumber){
		PadSectionFocus res = null;
		try {
			res = (PadSectionFocus)getCriteria(PadSectionFocus.class).add(Restrictions.lt("orderNumber", sortNumber)).add(Restrictions.isNotNull("orderNumber")).setMaxResults(1).addOrder(Order.desc("orderNumber")).list().get(0);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return res;
	}
	//设置Sort
	protected int setPosition(int id, int sortNumber){
		String hql = "UPDATE PadSectionFocus SET orderNumber=? WHERE id=?";
		return getHibernateTemplate().bulkUpdate(hql, new Object[]{sortNumber, id});
	}
	/**
	 * 上一步
	 * @param id
	 */
	public void up(int id){
		int formSort = getSortById(id);
		PadSectionFocus up = getToUp(formSort);
		int upId, upSort;
		//res[0] : ID
		if(up != null){
			upId = up.getId();
			upSort = up.getOrderNumber();
			setPosition(id, upSort);
			setPosition(upId, formSort);
		}
	}
	/**
	 * 下一步
	 * @param id
	 */
	public void next(int id){
		int formSort = getSortById(id);
		PadSectionFocus next= getToNext(formSort);
		int nextId, nextSort;
		//res[0] : ID
		if(next != null){
			nextId = next.getId();
			nextSort = next.getOrderNumber();
			System.out.println("update id " + id + " next " + nextSort);
			System.out.println("update nextId " + nextId + " formSort " + formSort);
			setPosition(id, nextSort);
			setPosition(nextId, formSort);
		}
	}
	/**
	 * 设置排序位置
	 * @param id
	 * @param strategy
	 */
	public void setPositions(int id, int strategy) {
		switch (strategy) {
		case -1:
			up(id);
			break;
		case 1:
			next(id);
			break;
		}
	}
	
	public List<State> getStates(int type) {
		List<State> states = new ArrayList<State>();
		State s = (State) getCriteria(State.class).add(Restrictions.eq("nodeType", type)).addOrder(Order.asc("id")).list().get(0);
		states.add((State) HibernateUtil.getUnproxiedValue(s));
		states.add((State) HibernateUtil.getUnproxiedValue(s.getNext()));
		return states;
	}
}
