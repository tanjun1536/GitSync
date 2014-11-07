package com.gang.entity;

import java.io.Serializable;

import com.google.gson.annotations.Expose;
import com.thoughtworks.xstream.annotations.XStreamAsAttribute;

public class BaseEntity implements Serializable{
	@XStreamAsAttribute
	@Expose
	private Integer id=0;

	public Integer getId() {
		return id;
	}

	public BaseEntity() {
		super();
	}

	public BaseEntity(Integer id) {
		super();
		this.id = id;
	}

	public void setId(Integer id) {
		this.id = id;
	}
	private Integer orderNumber;

	public Integer getOrderNumber() {
		return orderNumber;
	}

	public void setOrderNumber(Integer orderNumber) {
		this.orderNumber = orderNumber;
	}

}
