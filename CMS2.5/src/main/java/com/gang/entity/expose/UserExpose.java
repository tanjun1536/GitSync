package com.gang.entity.expose;

import java.util.Date;
import java.util.Set;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

public class UserExpose extends BaseEntity {
	
	@Expose
	private String content;
	@Expose
	private Date createDate = new Date();
	@Expose
	private String linkmethod;
	@Expose
	private String clientType;
	
	private Set<String> images;

	public Set<String> getImages() {
		return images;
	}

	public void setImages(Set<String> images) {
		this.images = images;
	}

	public String getClientType() {
		return clientType;
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

	public void setClientType(String clientType) {
		this.clientType = clientType;
	}

	public void setContent(String content) {
		this.content = content;
	}

	public void setCreateDate(Date createDate) {
		this.createDate = createDate;
	}


	public void setLinkmethod(String linkmethod) {
		this.linkmethod = linkmethod;
	}
}
