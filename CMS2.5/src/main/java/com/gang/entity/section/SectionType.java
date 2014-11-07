package com.gang.entity.section;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

public class SectionType extends BaseEntity {
	@Expose
	private String name;

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}
}
