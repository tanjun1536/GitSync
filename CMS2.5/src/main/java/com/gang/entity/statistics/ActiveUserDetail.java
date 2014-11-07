package com.gang.entity.statistics;

public class ActiveUserDetail extends ActiveUser{
	public String getActivityType() {
		return activityType;
	}

	public void setActivityType(String activityType) {
		this.activityType = activityType;
	}

	private String activityType;
}
