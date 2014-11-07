package com.gang.entity.user;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

public class FeedBack extends BaseEntity {
	@Expose
	private String content;
	@Expose
	private Date createDate = new Date();
	@Expose
	private String linkmethod;
	@Expose
	private String clientType;

	public String getClientType() {
		return clientType;
	}

	public void setClientType(String clientType) {
		this.clientType = clientType;
	}

	public String getContent() {
		return content;
	}

	public Date getCreateDate() {
		return createDate;
	}


	public String getLinkmethod() {
		return linkmethod;
	}

	public void setLinkmethod(String linkmethod) {
		this.linkmethod = linkmethod;
	}

	public void setContent(String content) {
		this.content = content;
	}

	public void setCreateDate(Date createDate) {
		this.createDate = createDate;
	}

}
