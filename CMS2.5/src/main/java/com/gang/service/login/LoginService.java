package com.gang.service.login;

import org.hibernate.Hibernate;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.HibernateUtil;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;

public class LoginService extends BaseService {
	public BackUser login(String username, String password) {
		BackUser user = (BackUser) getCriteria(BackUser.class)
				.add(Restrictions.eq("loginName", username))
				.add(Restrictions.eq("loginPassword", password))
				.add(Restrictions.eq("disabled", false))
				.uniqueResult();
		if (user != null) {
			Hibernate.initialize(user.getRoles());
			HibernateUtil.getUnproxiedValue(user.getRoles());
		}
		return user;
	}
}
