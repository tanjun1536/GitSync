package com.gang.entity.product;

import com.gang.entity.BaseEntity;

public class ProductImage extends BaseEntity{
	private String url;
	private String description;
	public String getUrl() {
		return url;
	}
	public void setUrl(String url) {
		this.url = url;
	}
	public String getDescription() {
		return description;
	}
	public void setDescription(String description) {
		this.description = description;
	}
}
