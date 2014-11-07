package com.gang.entity.user;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

public class FrontUser extends BaseEntity {
	/**
	 * 真实姓名
	 */
	@Expose private String name;
	/**
	 * 登录名
	 */
	@Expose private String loginName;
	/**
	 * 登录密码
	 */
	private String loginPassword;
	/**
	 * 设备好
	 */
	private String uniqueCode;
	/**
	 * 注册时间
	 */
	private Date registerTime = new Date();
	/**
	 * 头像图片
	 */
	private String headImage;
	/**
	 * 上次登录时间
	 */
	private Date lastLoginTime = new Date();

	/**
	 * 上次登出时间
	 */
	private Date lastLogoutTime;

	/**
	 * 邮箱地址
	 */
	private String email;
	
	/**
	 *昵称 
	 */
	private String nickName;
	
	/**
	 * 用户类型 phone / pad
	 */
	private String userType;

	public String getUserType() {
		return userType;
	}

	public void setUserType(String userType) {
		this.userType = userType;
	}

	public String getNickName() {
		return nickName;
	}

	public void setNickName(String nickName) {
		this.nickName = nickName;
	}

	public FrontUser() {
	}

	public FrontUser(Integer id) {
		super(id);
	}

	public String getName() {
		return name;
	}

	public String getUniqueCode() {
		return uniqueCode;
	}

	public void setUniqueCode(String uniqueCode) {
		this.uniqueCode = uniqueCode;
	}

	public Date getRegisterTime() {
		return registerTime;
	}

	public void setRegisterTime(Date registerTime) {
		this.registerTime = registerTime;
	}

	public Date getLastLoginTime() {
		return lastLoginTime;
	}

	public void setLastLoginTime(Date lastLoginTime) {
		this.lastLoginTime = lastLoginTime;
	}

	public Date getLastLogoutTime() {
		return lastLogoutTime;
	}

	public void setLastLogoutTime(Date lastLogoutTime) {
		this.lastLogoutTime = lastLogoutTime;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getLoginName() {
		return loginName;
	}

	public void setLoginName(String loginName) {
		this.loginName = loginName;
	}

	public String getLoginPassword() {
		return loginPassword;
	}

	public void setLoginPassword(String loginPassword) {
		this.loginPassword = loginPassword;
	}

	public String getHeadImage() {
		return headImage;
	}

	public void setHeadImage(String headImage) {
		this.headImage = headImage;
	}
}
