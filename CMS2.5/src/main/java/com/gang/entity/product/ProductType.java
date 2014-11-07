package com.gang.entity.product;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

public class ProductType extends BaseEntity {
	@Expose private String name;
	
	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}
}
