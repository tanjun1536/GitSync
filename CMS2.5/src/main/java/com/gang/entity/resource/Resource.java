package com.gang.entity.resource;

import com.gang.entity.BaseEntity;

public class Resource extends BaseEntity{
	public static String RES_CSS="css";
	public static String RES_JS="js";
	public static String RES_SOFT="soft";
	public static String RES_SKIN="skin";
	/**
	 * 下载地址
	 */
	private String link;
	/**
	 * 资源名称
	 */
	private String name;
	/**
	 * 资源类别
	 */
	private String type;
	/**
	 * 资源版本
	 */
	private Double version;
	public String getLink() {
		return link;
	}
	public String getName() {
		return name;
	}
	public String getType() {
		return type;
	}
	public Double getVersion() {
		return version;
	}
	public void setLink(String link) {
		this.link = link;
	}
	public void setName(String name) {
		this.name = name;
	}
	public void setType(String type) {
		this.type = type;
	}
	public void setVersion(Double version) {
		this.version = version;
	}
}
