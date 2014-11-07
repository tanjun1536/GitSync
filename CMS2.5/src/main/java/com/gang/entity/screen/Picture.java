package com.gang.entity.screen;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

public class Picture extends BaseEntity {

	/**
	 * 路径
	 */
	@Expose private String path;
	/**
	 * 时间
	 */
	@Expose private Date date;
	//1手机 2平板
	@Expose private Integer type;
	public String getPath() {
		return path;
	}
	public void setPath(String path) {
		this.path = path;
	}
	public Date getDate() {
		return date;
	}
	public void setDate(Date date) {
		this.date = date;
	}
	public Integer getType() {
		return type;
	}
	public void setType(Integer type) {
		this.type = type;
	}
}
