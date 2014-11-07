package com.gang.entity.resource;

import com.gang.entity.BaseEntity;

public class UserResource extends BaseEntity{
	/**
	 * 资源编号
	 */
	private Integer resourceId;
	/**
	 * 资源名字
	 */
	private String resourceName;
	/**
	 * 资源类别
	 */
	private String resourceType;
	/**
	 * 资源版本
	 */
	private String resourceVersion;
	/**
	 * 设备唯一号
	 */
	private String uniqueCode;
	/**
	 * 用户编号
	 */
	private Integer userId;
	/**
	 * 用户名称
	 */
	private String userName;
	public Integer getResourceId() {
		return resourceId;
	}
	public String getResourceName() {
		return resourceName;
	}
	public String getResourceType() {
		return resourceType;
	}
	public String getResourceVersion() {
		return resourceVersion;
	}
	public String getUniqueCode() {
		return uniqueCode;
	}
	public Integer getUserId() {
		return userId;
	}
	public String getUserName() {
		return userName;
	}
	public void setResourceId(Integer resourceId) {
		this.resourceId = resourceId;
	}
	public void setResourceName(String resourceName) {
		this.resourceName = resourceName;
	}
	public void setResourceType(String resourceType) {
		this.resourceType = resourceType;
	}
	public void setResourceVersion(String resourceVersion) {
		this.resourceVersion = resourceVersion;
	}
	public void setUniqueCode(String uniqueCode) {
		this.uniqueCode = uniqueCode;
	}
	public void setUserId(Integer userId) {
		this.userId = userId;
	}
	public void setUserName(String userName) {
		this.userName = userName;
	}
}
