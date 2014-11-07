package com.gang.entity.user;

import com.gang.entity.BaseEntity;
import com.gang.entity.department.Department;
import com.gang.entity.role.Role;

import com.google.gson.annotations.Expose;

import java.util.Set;


public class BackUser extends BaseEntity {
    @Expose
    private String name;
    @Expose
    private String loginName;
    @Expose
    private Boolean disabled=false;
    private String loginPassword;
    private Set<Role> roles;
    @Expose
    private Department department;

    public Boolean getDisabled() {
        return disabled;
    }

    public void setDisabled(Boolean disabled) {
        this.disabled = disabled;
    }

    public Department getDepartment() {
        return department;
    }

    public void setDepartment(Department department) {
        this.department = department;
    }

    public String getName() {
        return name;
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

    public Set<Role> getRoles() {
        return roles;
    }

    public void setRoles(Set<Role> roles) {
        this.roles = roles;
    }
}
