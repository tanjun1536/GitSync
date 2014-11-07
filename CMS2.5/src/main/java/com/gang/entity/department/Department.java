package com.gang.entity.department;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.Set;

import com.gang.entity.BaseEntity;
import com.gang.entity.user.BackUser;
import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class Department extends BaseEntity implements java.io.Serializable{

	private static final long serialVersionUID = 1L;
	/**
	 * 名称
	 */
	@Expose
	@SerializedName("text")
	private String name;
	/**
	 * 上级
	 */
	private Department parent;
	/**
	 * 子级
	 */
	@Expose
	private Set<Department> children;
	/**
	 * 用户
	 */
	private Set<BackUser> users;
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public Department getParent() {
		return parent;
	}
	public void setParent(Department parent) {
		this.parent = parent;
		getFullName();
	}
	public Set<Department> getChildren() {
		return children;
	}
	public void setChildren(Set<Department> children) {
		this.children = children;
	}
	@Expose
	private String fullName;
	@SuppressWarnings("unchecked")
	public String getFullName(){
		List<String> names = new ArrayList(Arrays.asList(name));
		Department p = getParent(); 
		while(p != null){
			names.add(p.getName());
			p = p.getParent();
		}
		String fullName = names.get(names.size()-1);
		for(int i=names.size()-2; i>=0; i--){
			fullName += "-" + names.get(i);
		}
		setFullName(fullName);
		return this.fullName;
	}
	public void setFullName(String fullName) {
		this.fullName = fullName;
	}
	
	public Integer getParentId(){
		if(getParent() == null)
			return null;
		return getParent().getId();
	}
	
	/**
	 * 获取前缀字符串
	 * @param tag
	 * @param level
	 * @return
	 */
	public String getStartTagStr(String tag){
		String tagStr = tag;
		Department p = getParent();
		while(p != null){
			tagStr += tag;
			p = p.getParent();
		}
		return tagStr;
	}
	public Set<BackUser> getUsers() {
		return users;
	}
	public void setUsers(Set<BackUser> users) {
		this.users = users;
	}
}
