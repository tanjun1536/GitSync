package com.gang.entity.product;

import java.util.Date;
import java.util.List;
import com.gang.entity.BaseEntity;
import com.gang.entity.user.User;
import com.google.gson.annotations.Expose;


public class Orders extends BaseEntity {
    //订单编号
	@Expose
    private String orderCode;

    //订单日期
	@Expose
    private Date orderDate;

    //订单状态
	@Expose
    private String status;

    //订单用户
	@Expose
    private User user;

    //订单产品
	@Expose
    private Product product;

    public Product getProduct() {
		return product;
	}

	public void setProduct(Product product) {
		this.product = product;
	}

	public String getOrderCode() {
        return orderCode;
    }

    public void setOrderCode(String orderCode) {
        this.orderCode = orderCode;
    }

    public Date getOrderDate() {
        return orderDate;
    }

    public void setOrderDate(Date orderDate) {
        this.orderDate = orderDate;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

}
