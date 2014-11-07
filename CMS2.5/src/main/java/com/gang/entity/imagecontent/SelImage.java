package com.gang.entity.imagecontent;

import com.gang.entity.BaseEntity;

public class SelImage extends BaseEntity{

	/**
	 * 图片地址
	 */
	private String path;
	/**
	 * 图片描述
	 */
	private String des;
	/**
	 * 图片内容
	 */
	private ImageContent content;
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
	public ImageContent getContent() {
		return content;
	}
	public void setContent(ImageContent content) {
		this.content = content;
	}
}
