package com.gang.entity.user;

import com.gang.entity.BaseEntity;

import java.util.Date;


public class Terminal extends BaseEntity {
    private String deviceCode;
    private int height;
    private int width;
    private String osCode;
    private String osType;
    private String osVersion;
    private String softType;
    private String softVersion;
    private String spreadCode;
    private String uniqueCode;
    private String activeKey;
    private Date createDate=new Date();

    public Date getCreateDate() {
        return createDate;
    }

    public void setCreateDate(Date createDate) {
        this.createDate = createDate;
    }

    public String getActiveKey() {
        return activeKey;
    }

    public void setActiveKey(String activeKey) {
        this.activeKey = activeKey;
    }

    public String getSpreadCode() {
        return spreadCode;
    }

    public void setSpreadCode(String spreadCode) {
        this.spreadCode = spreadCode;
    }

    public String getSoftType() {
        return softType;
    }

    public void setSoftType(String softType) {
        this.softType = softType;
    }

    public String getDeviceCode() {
        return deviceCode;
    }

    public void setDeviceCode(String deviceCode) {
        this.deviceCode = deviceCode;
    }

    public int getHeight() {
        return height;
    }

    public void setHeight(int height) {
        this.height = height;
    }

    public int getWidth() {
        return width;
    }

    public void setWidth(int width) {
        this.width = width;
    }

    public String getOsCode() {
        return osCode;
    }

    public void setOsCode(String osCode) {
        this.osCode = osCode;
    }

    public String getOsType() {
        return osType;
    }

    public void setOsType(String osType) {
        this.osType = osType;
    }

    public String getOsVersion() {
        return osVersion;
    }

    public void setOsVersion(String osVersion) {
        this.osVersion = osVersion;
    }

    public String getSoftVersion() {
        return softVersion;
    }

    public void setSoftVersion(String softVersion) {
        this.softVersion = softVersion;
    }

    public String getUniqueCode() {
        return uniqueCode;
    }

    public void setUniqueCode(String uniqueCode) {
        this.uniqueCode = uniqueCode;
    }
}
