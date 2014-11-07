package com.gang.service.mobile;

import com.gang.entity.task.TaskHistory;
import com.gang.entity.user.User;
import com.gang.service.BaseService;

public class TaskService extends BaseService {
	public void saveTaskHistory(TaskHistory history,String userName,Integer reward)
	{
		save(history);
		User user=get(User.class,"loginName",userName);
		if(user!=null)
		{
			user.setMoney(user.getMoney()+reward);
		}
	}
}
