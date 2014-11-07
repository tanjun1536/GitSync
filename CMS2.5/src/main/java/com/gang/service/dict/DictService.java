package com.gang.service.dict;

import java.util.List;

import com.gang.entity.dict.Dict;
import com.gang.service.BaseService;

public class DictService extends BaseService{
	
	@SuppressWarnings("unchecked")
	public List<Dict> getDictByCategory(String category){
		String hql = "FROM Dict WHERE category=?";
		return super.getHibernateTemplate().find(hql, category);
	}
	
}
