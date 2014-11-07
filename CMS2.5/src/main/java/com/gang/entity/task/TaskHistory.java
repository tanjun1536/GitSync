package com.gang.entity.task;

import com.gang.entity.BaseEntity;

import java.util.Date;


public class TaskHistory extends BaseEntity {
    private Integer taskId;
    private Date doDate;
    private Integer userId;
    private String userName;
    private Integer doCount;

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public Integer getDoCount() {
        return doCount;
    }

    public void setDoCount(Integer doCount) {
        this.doCount = doCount;
    }

    public Integer getTaskId() {
        return taskId;
    }

    public void setTaskId(Integer taskId) {
        this.taskId = taskId;
    }

    public Date getDoDate() {
        return doDate;
    }

    public void setDoDate(Date doDate) {
        this.doDate = doDate;
    }

    public Integer getUserId() {
        return userId;
    }

    public void setUserId(Integer userId) {
        this.userId = userId;
    }
}
