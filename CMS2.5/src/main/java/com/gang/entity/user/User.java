package com.gang.entity.user;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

import java.util.Date;
import java.util.Set;


public class User extends BaseEntity {
    private String activeKey;
    private String age;
    private String birthday;
    private String birthmonth;
    private String birthyear;
    private String city;
    private String company;
    private String country;
    private String favorite;
    private String header;
    private Set<UserImageGroup> imageGroups;
    private String introduction;
    private Date lastLoginTime;
    private Double latestLatitude;
    private Double latestLongitude;
    @Expose private String loginName;
    private String loginPassword;
    @Expose private String nick;
    private String prefession;
    private String province;
    private String school;
    private String sex;
    private String signature;
    private String loginNumber;
    private String email;
    private String loginPasswordSalt;
    private Integer money;

    public Integer getMoney() {
    	if(money==null) money=0;
		return money;
	}

	public void setMoney(Integer money) {
		this.money = money;
	}

	public String getLoginPasswordSalt() {
		return loginPasswordSalt;
	}

	public void setLoginPasswordSalt(String loginPasswordSalt) {
		this.loginPasswordSalt = loginPasswordSalt;
	}

	public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getLoginNumber() {
        return loginNumber;
    }

    public void setLoginNumber(String loginNumber) {
        this.loginNumber = loginNumber;
    }

    public String getActiveKey() {
        return activeKey;
    }

    public String getAge() {
        return age;
    }

    public String getBirthday() {
        return birthday;
    }

    public String getBirthmonth() {
        return birthmonth;
    }

    public String getBirthyear() {
        return birthyear;
    }

    public String getCity() {
        return city;
    }

    public String getCompany() {
        return company;
    }

    public String getCountry() {
        return country;
    }

    public String getFavorite() {
        return favorite;
    }

    public String getHeader() {
        return header;
    }

    public Set<UserImageGroup> getImageGroups() {
        return imageGroups;
    }

    public String getIntroduction() {
        return introduction;
    }

    public Date getLastLoginTime() {
        return lastLoginTime;
    }

    public Double getLatestLatitude() {
        return latestLatitude;
    }

    public Number getLatestLongitude() {
        return latestLongitude;
    }

    public String getLoginName() {
        return loginName;
    }

    public String getLoginPassword() {
        return loginPassword;
    }

    public String getNick() {
        return nick;
    }

    public String getPrefession() {
        return prefession;
    }

    public String getProvince() {
        return province;
    }

    public String getSchool() {
        return school;
    }

    public String getSex() {
        return sex;
    }

    public String getSignature() {
        return signature;
    }

    public void setActiveKey(String activeKey) {
        this.activeKey = activeKey;
    }

    public void setAge(String age) {
        this.age = age;
    }

    public void setBirthday(String birthday) {
        this.birthday = birthday;
    }

    public void setBirthmonth(String birthmonth) {
        this.birthmonth = birthmonth;
    }

    public void setBirthyear(String birthyear) {
        this.birthyear = birthyear;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public void setCompany(String company) {
        this.company = company;
    }

    public void setCountry(String country) {
        this.country = country;
    }

    public void setFavorite(String favorite) {
        this.favorite = favorite;
    }

    public void setHeader(String header) {
        this.header = header;
    }

    public void setImageGroups(Set<UserImageGroup> imageGroups) {
        this.imageGroups = imageGroups;
    }

    public void setIntroduction(String introduction) {
        this.introduction = introduction;
    }

    public void setLastLoginTime(Date lastLoginTime) {
        this.lastLoginTime = lastLoginTime;
    }

    public void setLatestLatitude(Double latestLatitude) {
        this.latestLatitude = latestLatitude;
    }

    public void setLatestLongitude(Double latestLongitude) {
        this.latestLongitude = latestLongitude;
    }

    public void setLoginName(String loginName) {
        this.loginName = loginName;
    }

    public void setLoginPassword(String loginPassword) {
        this.loginPassword = loginPassword;
    }

    public void setNick(String nick) {
        this.nick = nick;
    }

    public void setPrefession(String prefession) {
        this.prefession = prefession;
    }

    public void setProvince(String province) {
        this.province = province;
    }

    public void setSchool(String school) {
        this.school = school;
    }

    public void setSex(String sex) {
        this.sex = sex;
    }

    public void setSignature(String signature) {
        this.signature = signature;
    }
}
