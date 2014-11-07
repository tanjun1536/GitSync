package com.gang.comms;

import java.util.ArrayList;
import java.util.List;

public class LazyKiller {
	private List<String> cglibProperties = new ArrayList<String>();
	private List<String> lazyProperties = new ArrayList<String>();

	public List<String> getCglibProperties() {
		return cglibProperties;
	}

	public void setCglibProperties(List<String> cglibProperties) {
		this.cglibProperties = cglibProperties;
	}

	public List<String> getLazyProperties() {
		return lazyProperties;
	}

	public void setLazyProperties(List<String> lazyProperties) {
		this.lazyProperties = lazyProperties;
	}

	public LazyKiller addCglibProperty(String cglib) {
		this.cglibProperties.add(cglib);
		return this;
	}

	public LazyKiller addLazyProperty(String lazy) {
		this.lazyProperties.add(lazy);
		return this;
	}
}
