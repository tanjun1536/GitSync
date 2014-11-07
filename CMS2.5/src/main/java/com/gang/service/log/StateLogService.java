package com.gang.service.log;

import java.util.Date;

import com.gang.entity.log.StateLog;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;

public class StateLogService extends BaseService {
	
	public void addLog(int logType, int stateId, String stateName, BackUser user, Integer dataId)
	{
		StateLog log = new StateLog();
		log.setDate(new Date());
		log.setLogType(logType);
		log.setStateId(stateId);
		log.setStateName(stateName);
		log.setUser(user);
		log.setDataId(dataId);
		save(log);
	}
	
}
