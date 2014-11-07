package com.gang.service.user;

import java.util.List;

import org.hibernate.Session;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.JSONHelper;
import com.gang.entity.user.FrontUser;
import com.gang.service.BaseService;
import com.gang.service.wssvc.Result;

public class FrontUserService extends BaseService {

	/**
	 * 后台操作失败返回的字符串-false
	 */
	String NO = "false";
	/**
	 * 后台操作成功返回的字符串-true
	 */
	String OK = "true";

	public Result regisiter(String name, String pwd, String nickname, String activeKey) {
		Session session = getSession();
		Result result = new Result();

		// 检查用户名是否存在
		List<FrontUser> list = getCriteria(FrontUser.class).add(Restrictions.eq("loginName", name)).list();
		if (list.size() > 0) {
			result.setRet(NO);
			result.setMsg("该用户名已经被使用.");
		} else {
			FrontUser user = new FrontUser();
			user.setLoginName(name);
			user.setLoginPassword(pwd);
			user.setUniqueCode(activeKey);
			user.setNickName(nickname);
			session.save(user);
			result.setRet(OK);
			result.setMsg("注册成功!");
		}
		return result;
	}

}
