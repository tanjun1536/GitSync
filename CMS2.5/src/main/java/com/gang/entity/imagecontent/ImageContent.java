package com.gang.entity.imagecontent;

import java.io.Serializable;
import java.util.Date;
import java.util.Set;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.Article;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.template.Template;
import com.google.gson.annotations.Expose;

public class ImageContent extends Article implements Serializable {

	private static final long serialVersionUID = 1L;

	private Set<SelImage> images;

	public Set<SelImage> getImages() {
		return images;
	}

	public void setImages(Set<SelImage> images) {
		this.images = images;
	}

}
