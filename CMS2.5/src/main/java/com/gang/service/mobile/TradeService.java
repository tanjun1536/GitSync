package com.gang.service.mobile;

import com.gang.entity.product.Orders;
import com.gang.entity.product.Product;
import com.gang.entity.user.User;

import com.gang.service.BaseService;

import org.hibernate.Hibernate;
import org.hibernate.Query;
import org.hibernate.Session;

import java.util.Date;
import java.util.List;
import java.util.UUID;


public class TradeService extends BaseService {
    public String buy(User user, Product product) {
        Orders order = new Orders();
        //order.setOrderCode(UUID.randomUUID().toString());
        order.setOrderDate(new Date());
        order.setUser(user);
        order.setProduct(product);

        if (product.getTradeType() == 2) {
            order.setStatus("已支付");
        } else {
            order.setStatus("已完成");
        }

        //添加订单
        add(order);

        //
        String code = "000000000000" + order.getId();
        code = "C" + code.substring(code.length() - 12);
        order.setOrderCode(code);

        //扣钱
        user.setMoney(user.getMoney() - product.getPrice());
        save(user);
        //减少库存
        product.setStock(product.getStock() - 1);
        save(product);

        return order.getOrderCode();
    }

    public List<Product> getProducts(Integer page_index, Integer page_count) {
        Integer startIndex = (page_index == 0) ? 0 : ((page_index - 1) * page_count);
        String sql = "SELECT * FROM product order by id desc";
        List<Product> list = getSession().createSQLQuery(sql).addEntity(Product.class).setFirstResult(startIndex).setMaxResults(page_count)
                                 .list();

        return list;
    }

    public List<Product> getBuyList(String user_name, Integer page_index, Integer page_count) {
        Integer startIndex = (page_index == 0) ? 0 : ((page_index - 1) * page_count);
        String sql = "SELECT * FROM product WHERE id IN (SELECT product FROM orders WHERE `user` = (SELECT id FROM `user` WHERE loginName='" +
            user_name + "')) )";
        List<Product> list = getSession().createSQLQuery(sql).addEntity(Product.class).setFirstResult(startIndex).setMaxResults(page_count)
                                 .list();

        return list;
    }

    public List<Orders> getOrders(User user, String status, Integer page_index, Integer page_count) {
        Integer startIndex = (page_index == 0) ? 0 : ((page_index - 1) * page_count);
        String sql = "SELECT * FROM Orders WHERE status='" + status + "' AND user= " + user.getId() + " order by id desc";
        List<Orders> list = getSession().createSQLQuery(sql).addEntity(Orders.class).setFirstResult(startIndex).setMaxResults(page_count)
                                .list();

        if ((list != null) && (list.size() > 0)) {
            for (Orders orders : list) {
                Hibernate.initialize(orders.getUser());
                Hibernate.initialize(orders.getProduct());
            }
        }

        return list;
    }

    public List<Orders> getOrders(User user, Integer page_index, Integer page_count) {
        Integer startIndex = (page_index == 0) ? 0 : ((page_index - 1) * page_count);
        String sql = "SELECT * FROM Orders WHERE  user= " + user.getId() + " order by id desc";
        List<Orders> list = getSession().createSQLQuery(sql).addEntity(Orders.class).setFirstResult(startIndex).setMaxResults(page_count)
                                .list();

        if ((list != null) && (list.size() > 0)) {
            for (Orders orders : list) {
                Hibernate.initialize(orders.getUser());
                Hibernate.initialize(orders.getProduct());
            }
        }

        return list;
    }

    public Integer getBuyCount(User user, Integer product_id) {
        String sql = "SELECT COUNT(*) FROM Orders WHERE  user= " + user.getId() + "  AND product="+product_id;
        Session session = getSession();
        Query q = session.createSQLQuery(sql).setMaxResults(1);
        return Integer.parseInt(q.uniqueResult().toString());
    }
}
