package com.gang.action.orders;

import java.util.ArrayList;

import org.hibernate.Hibernate;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageRequest.AddCglibPropertyHandler;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;
import com.gang.entity.product.Orders;
import com.gang.entity.product.Product;
import com.gang.entity.product.ProductImage;
import com.gang.service.orders.OrdersService;


public class OrdersAction extends DefaultAction {
    private OrdersService service;

    public OrdersService getService() {
        return service;
    }

    public void setService(OrdersService service) {
        this.service = service;
    }

    @Override
    public void getList() throws Exception {
        GridPageRequest gr = new GridPageRequest(getRequest());
        StringBuffer csql = new StringBuffer(" SELECT count(p) FROM Orders p");
        StringBuffer dsql = new StringBuffer(" SELECT p FROM Orders p");
        String productName=getString("productName");
        if(StringHelper.isNotBlank(productName))
        {
        	csql.append(" WHERE p.product.name like '%"+productName+"%'");
        	dsql.append(" WHERE p.product.name like '%"+productName+"%'");
        }
        gr.setTableAlias("p");
        gr.addCglibProperty("getProduct");
        gr.addCglibProperty("getUser");
        gr.setHsql(true);
        gr.setCsql(csql.toString());
        gr.setDsql(dsql.toString());

        GridPageResponse gpr = service.getGridPage(gr);
        String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
        Write(json);
    }

    @Override
    public void ajaxDelete(Integer id) throws Exception {
        // TODO Auto-generated method stub
        service.delete(Orders.class, id);
    }
    public void Complete()
    {
    	String sql="UPDATE orders SET status = '已完成' WHERE id="+getId();
    	service.exec(sql);
    }
}
