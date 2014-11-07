package com.gang.entity.dict;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;


/**
 * Sysdict entity.
 * 
 * @author MyEclipse Persistence Tools
 */

public class Dict extends BaseEntity implements java.io.Serializable {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private String category;
	@Expose
	private String name;
	private String defaultValue;
	private String value1;
	private String value2;
	private String value3;
	private String value4;
	private String note;
	private Integer state;

	// Constructors

	/** default constructor */
	public Dict() {
	}

	/** minimal constructor */
	public Dict(String category) {
		this.category = category;
	}

	/** full constructor */
	public Dict(String category, String name, String defaultValue,
			String value1, String value2, String value3, String value4,
			String note, Integer state) {
		this.category = category;
		this.name = name;
		this.defaultValue = defaultValue;
		this.value1 = value1;
		this.value2 = value2;
		this.value3 = value3;
		this.value4 = value4;
		this.note = note;
		this.state = state;
	}

	// Property accessors

	public String getCategory() {
		return this.category;
	}

	public void setCategory(String category) {
		this.category = category;
	}

	public String getName() {
		return this.name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getDefaultValue() {
		return this.defaultValue;
	}

	public void setDefaultValue(String defaultValue) {
		this.defaultValue = defaultValue;
	}

	public String getValue1() {
		return this.value1;
	}

	public void setValue1(String value1) {
		this.value1 = value1;
	}

	public String getValue2() {
		return this.value2;
	}

	public void setValue2(String value2) {
		this.value2 = value2;
	}

	public String getValue3() {
		return this.value3;
	}

	public void setValue3(String value3) {
		this.value3 = value3;
	}

	public String getValue4() {
		return this.value4;
	}

	public void setValue4(String value4) {
		this.value4 = value4;
	}

	public String getNote() {
		return this.note;
	}

	public void setNote(String note) {
		this.note = note;
	}

	public Integer getState() {
		return this.state;
	}

	public void setState(Integer state) {
		this.state = state;
	}
}