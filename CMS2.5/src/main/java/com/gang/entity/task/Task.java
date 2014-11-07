package com.gang.entity.task;

import com.gang.entity.BaseEntity;


public class Task extends BaseEntity {
    private String type;
    private String name;
    private String description;
    private Integer times_perday;
    private Boolean enable;
    private String status;
    private Integer reward;

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Integer getTimes_perday() {
        return times_perday;
    }

    public void setTimes_perday(Integer times_perday) {
        this.times_perday = times_perday;
    }

    public Boolean getEnable() {
        return enable;
    }

    public void setEnable(Boolean enable) {
        this.enable = enable;
    }

    public Integer getReward() {
        return reward;
    }

    public void setReward(Integer reward) {
        this.reward = reward;
    }
}
