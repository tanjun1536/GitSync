package com.gang.service.screen;

import org.hibernate.criterion.Order;
import org.hibernate.criterion.Restrictions;

import com.gang.entity.screen.Picture;
import com.gang.service.BaseService;

public class PictureService extends BaseService{
	public Picture getNew(Integer type){
		return (Picture)getCriteria(Picture.class).add(Restrictions.eq("type", type)).addOrder(Order.desc("date")).setMaxResults(1).uniqueResult();
	}
}
