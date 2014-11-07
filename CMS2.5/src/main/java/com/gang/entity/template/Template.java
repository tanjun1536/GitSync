package com.gang.entity.template;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;
public class Template extends BaseEntity {
	/**
	 * 是否启用
	 */
	private Boolean actived;
	/**
	 * 模版中文章的数量
	 */
	private Integer articleCount;

	/**
	 * 模版内容
	 */
	private String html;

	/**
	 * 模版缩略图片
	 */
	private String image;

	/**
	 * 模版中图片数量
	 */
	private Integer imageCount;

	/**
	 * 模版名字
	 */
	@Expose
	private String name;

	/**
	 * 模版路径
	 */
	private String path;
	
	/**
	 * 模版使用类型
	 */
	private String type;
	
	private String previewHtml;
	
	public String getPreviewHtml() {
		return previewHtml;
	}

	public void setPreviewHtml(String previewHtml) {
		this.previewHtml = previewHtml;
	}

	public Boolean getActived() {
		return actived;
	}

	public Integer getArticleCount() {
		return articleCount;
	}

	public String getHtml() {
		return html;
	}

	public String getImage() {
		return image;
	}

	public Integer getImageCount() {
		return imageCount;
	}

	public String getName() {
		return name;
	}

	public String getPath() {
		return path;
	}

	public String getType() {
		return type;
	}

	public void setActived(Boolean actived) {
		this.actived = actived;
	}

	public void setArticleCount(Integer articleCount) {
		this.articleCount = articleCount;
	}

	public void setHtml(String html) {
		this.html = html;
	}

	public void setImage(String image) {
		this.image = image;
	}

	public void setImageCount(Integer imageCount) {
		this.imageCount = imageCount;
	}

	public void setName(String name) {
		this.name = name;
	}

	public void setPath(String path) {
		this.path = path;
	}

	public void setType(String type) {
		this.type = type;
	}
}
