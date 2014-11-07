package com.gang.comms;

import java.util.Iterator;
import java.util.LinkedList;

import com.gang.entity.role.Role;
import com.gang.entity.user.BackUser;

public class BackUserProxy {
	
	private BackUser user;

	public BackUserProxy(BackUser user) {
		super();
		this.user = user;
	}

	public BackUser getUser() {
		return user;
	}
	
	public Integer[] getRoleIds(){
		LinkedList<Integer> ids = new LinkedList<Integer>();
		Iterator<Role> roles = user.getRoles().iterator();
		while(roles.hasNext()){
			Integer id;
			ids.add(id=roles.next().getId());
			System.out.println("rid" + id);
		}
		
		return ids.toArray(new Integer[]{});
	}
	
	public String joinIds(Integer[] ids){
		StringBuffer idsStr = new StringBuffer("");
		for (Integer integer : ids) {
			idsStr.append(integer).append(",");
		}
		return idsStr.delete(idsStr.lastIndexOf(","), idsStr.length()).toString();
	}
}
