package com.gang.action.product;

import com.gang.action.DefaultAction;

import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.HibernateUpdateCollectionKiller;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;

import com.gang.entity.product.Product;
import com.gang.entity.product.ProductType;

import com.gang.service.product.ProductService;

import java.util.List;

import javax.servlet.http.HttpServletRequest;


public class ProductAction extends DefaultAction {
    private ProductService service;
    private Product product;

    public ProductService getService() {
        return service;
    }

    public void setService(ProductService service) {
        this.service = service;
    }

    public Product getProduct() {
        return product;
    }

    public void setProduct(Product product) {
        this.product = product;
    }

    @Override
    public void add(HttpServletRequest req) throws Exception {
        List<ProductType> types = service.getList(ProductType.class);
        req.setAttribute("types", types);
    }

    @Override
    public void getList() throws Exception {
        GridPageRequest gr = new GridPageRequest(getRequest());
        StringBuffer csql = new StringBuffer(" SELECT count(p) FROM Product p");
        StringBuffer dsql = new StringBuffer(" SELECT p FROM Product p");
        String productName=getString("productName");
        if(StringHelper.isNotBlank(productName))
        {
        	csql.append(" WHERE p.name like '%"+productName+"%'");
        	dsql.append(" WHERE p.name like '%"+productName+"%'");
        }
        
        gr.setTableAlias("p");
        gr.addLazyProperty("getImages");
        gr.addCglibProperty("getType");
        gr.setHsql(true);
        gr.setCsql(csql.toString());
        gr.setDsql(dsql.toString());

        GridPageResponse gpr = service.getGridPage(gr);
        String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
        Write(json);
    }

    @Override
    public void doSave() throws Exception {
        service.save(product);
    }

    @Override
    public void doUpdate() throws Exception {
        // TODO Auto-generated method stub
        service.update(product, new HibernateUpdateCollectionKiller("getImages"));
    }

    @Override
    public void edit(Integer id, HttpServletRequest req)
        throws Exception {
        add(req);
        product = service.get(Product.class, id, "getImages");
        req.setAttribute("product", product);
    }

    @Override
    public void ajaxDelete(Integer id) throws Exception {
        // TODO Auto-generated method stub
        service.delete(Product.class, id);
    }
}
