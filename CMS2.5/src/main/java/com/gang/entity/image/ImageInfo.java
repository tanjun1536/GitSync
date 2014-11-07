package com.gang.entity.image;

import java.io.Serializable;

import com.gang.entity.BaseEntity;
import com.gang.entity.section.Section;
import com.gang.entity.user.BackUser;

public class ImageInfo extends BaseEntity implements Serializable{

	private static final long serialVersionUID = 1L;

	private BackUser user;
	private Section section;
	private String name;
	/**
	 * 图片存储路路径
	 */
	private String path;
	/**
	 * 图片说明
	 */
	private String des;
	/**
	 * 图片描述
	 */
	private Integer sort;
	public String getPath() {
		return path;
	}
	public void setPath(String path) {
		this.path = path;
	}
	public String getDes() {
		return des;
	}
	public void setDes(String des) {
		this.des = des;
	}
	public Integer getSort() {
		return sort;
	}
	public void setSort(Integer sort) {
		this.sort = sort;
	}
	public BackUser getUser() {
		return user;
	}
	public void setUser(BackUser user) {
		this.user = user;
	}
	public Section getSection() {
		return section;
	}
	public void setSection(Section section) {
		this.section = section;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
}
