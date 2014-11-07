package com.gang.service.process;

import java.util.List;

import com.gang.service.BaseService;

public class StateService extends BaseService {
	public List<Integer> getStateIds(Integer[] roleIds){
		String hql = "SELECT id FROM State WHERE role.id in (:ids)";
		return getHibernateTemplate().findByNamedParam(hql, new String[]{"ids"}, new Object[]{roleIds});
	}
}
