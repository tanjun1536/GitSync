package com.gang.entity.process;

import com.gang.entity.BaseEntity;
import com.gang.entity.role.Role;
import com.google.gson.annotations.Expose;

public class State extends BaseEntity {
	/**
	 * 文章类别
	 */
	public static final int TYPE_ARTICLE = 1;
	public static final int TYPE_ARTICLE_MOBILE = 1;
	public static final int TYPE_CONTENT_MOBILE = 1;
	public static final int TYPE_CONTENT_PAD = 3;
	public static final int TYPE_ARTICLE_PAD = 3;
	public static final int TYPE_IMAGE_ARTICLE_MOBILE = 5;
	public static final int TYPE_IMAGE_ARTICLE_PAD = 6;
	public static final int TYPE_SECTION_MOBILE = 2;
	public static final int TYPE_SECTION_PAD = 4;
	/**
	 * 焦点类别
	 */
	public static final int TYPE_SECTIONFOCUS = 2;
	
	/**
	 * 当前状态名称
	 */
	@Expose
	private String name;

	/**
	 * 下一状态
	 */
	private State next;

	//流程节点类别描述
	private String nodeDesc;
	
	//流程节点类别
	private Integer nodeType;
	
	/**
	 * 上一状态
	 */
	private State prev;
	
	private State rejected;

	/**
	 * 当前状态对应的操作角色
	 */
	private Role role;
	public String getName() {
		return name;
	}

	public State getNext() {
		return next;
	}

	public String getNodeDesc() {
		return nodeDesc;
	}

	public Integer getNodeType() {
		return nodeType;
	}

	public State getPrev() {
		return prev;
	}

	public State getRejected() {
		return rejected;
	}

	public Role getRole() {
		return role;
	}

	public void setName(String name) {
		this.name = name;
	}

	public void setNext(State next) {
		this.next = next;
	}

	public void setNodeDesc(String nodeDesc) {
		this.nodeDesc = nodeDesc;
	}

	public void setNodeType(Integer nodeType) {
		this.nodeType = nodeType;
	}

	public void setPrev(State prev) {
		this.prev = prev;
	}

	public void setRejected(State rejected) {
		this.rejected = rejected;
	}

	public void setRole(Role role) {
		this.role = role;
	}

}
