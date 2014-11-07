package com.gang.comms;

public class BeanClassAlias {
	private String alias;
	private Class clazz;

	public String getAlias() {
		return alias;
	}

	public void setAlias(String alias) {
		this.alias = alias;
	}

	public BeanClassAlias(String alias, Class clazz) {
		super();
		this.alias = alias;
		this.clazz = clazz;
	}

	public Class getClazz() {
		return clazz;
	}

	public void setClazz(Class clazz) {
		this.clazz = clazz;
	}
}
