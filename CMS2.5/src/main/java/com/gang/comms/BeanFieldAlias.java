package com.gang.comms;

public class BeanFieldAlias {
	private String field;
	private String alias;
	private Class clazz;

	public String getField() {
		return field;
	}

	public void setField(String field) {
		this.field = field;
	}

	public String getAlias() {
		return alias;
	}

	public BeanFieldAlias(String field, Class clazz, String alias) {
		super();
		this.field = field;
		this.alias = alias;
		this.clazz = clazz;
	}

	public void setAlias(String alias) {
		this.alias = alias;
	}

	public Class getClazz() {
		return clazz;
	}

	public void setClazz(Class clazz) {
		this.clazz = clazz;
	}
}
