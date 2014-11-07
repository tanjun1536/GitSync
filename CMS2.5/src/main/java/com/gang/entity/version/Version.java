package com.gang.entity.version;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

public class Version extends BaseEntity {
	
	private Date createDate = new Date();
	/**
	 * 新版程序下载地址
	 */
	@Expose
	private String downUrl;

	private String equHeight;
	/**
	 * 设备类型
	 */
	@Expose
	private String equType;

	private String equWidth;

	/**
	 * 软件名称
	 */
	@Expose
	private String name;
	/**
	 * 操作系统版本
	 */
	private String osVersion;

	/**
	 * 软件版本
	 */
	@Expose
	private String version;
	@Expose
	private String description;

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public Date getCreateDate() {
		return createDate;
	}

	public String getDownUrl() {
		return downUrl;
	}

	public String getEquHeight() {
		return equHeight;
	}

	public String getEquType() {
		return equType;
	}

	public String getEquWidth() {
		return equWidth;
	}

	public String getName() {
		return name;
	}

	public String getOsVersion() {
		return osVersion;
	}

	public String getVersion() {
		return version;
	}

	public void setCreateDate(Date createDate) {
		this.createDate = createDate;
	}

	public void setDownUrl(String downUrl) {
		this.downUrl = downUrl;
	}

	public void setEquHeight(String equHeight) {
		this.equHeight = equHeight;
	}

	public void setEquType(String equType) {
		this.equType = equType;
	}

	public void setEquWidth(String equWidth) {
		this.equWidth = equWidth;
	}

	public void setName(String name) {
		this.name = name;
	}

	public void setOsVersion(String osVersion) {
		this.osVersion = osVersion;
	}

	public void setVersion(String version) {
		this.version = version;
	}
	

}
