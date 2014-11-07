package com.gang.service.distribute;

import java.util.Date;

import com.gang.entity.process.State;
import com.gang.entity.section.PadSectionFocus;
import com.gang.entity.section.SectionFocus;
import com.gang.service.BaseService;

public class SectionFocusPadDistributeService extends BaseService {
	public void distribute(int id){
		PadSectionFocus focus = get(PadSectionFocus.class, id);
		focus.setState(focus.getState().getNext());
	}
	
	/**
	 * 上线
	 */
	public void display(int id){
		PadSectionFocus focus = get(PadSectionFocus.class, id);
		State state = getState("上线");
		focus.setState(state);
	}
	
	/**
	 * 下线
	 */
	public void hidden(int id){
		PadSectionFocus focus = get(PadSectionFocus.class, id);
		State state = getState("下线");
		focus.setState(state);
	}
	
	private State getState(String name){
		String hql = "FROM State WHERE name=?";
		return (State)getSession().createQuery(hql).setString(0, name).uniqueResult();
	}

	public void toTop(Integer id) {
		PadSectionFocus sf=get(PadSectionFocus.class,id);
		sf.setTopDate(new Date());
		
	}
}
