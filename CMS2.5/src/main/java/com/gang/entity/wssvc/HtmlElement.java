package com.gang.entity.wssvc;

public class HtmlElement {
	private String content;
	private String type;
	public HtmlElement( String type,String content) {
		this.content = content;
		this.type = type;
	}
	public String getContent() {
		return content;
	}
	public String getType() {
		return type;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public void setType(String type) {
		this.type = type;
	}
}
