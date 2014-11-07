package com.gang.action.product;

import javax.servlet.http.HttpServletRequest;

import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.product.ProductType;
import com.gang.service.product.ProductTypeService;


public class ProductTypeAction extends DefaultAction {
    private ProductTypeService service;
    private ProductType productType;

    @Override
    public void doUpdate() throws Exception {
        service.save(productType);
    }

    public void setService(ProductTypeService service) {
        this.service = service;
    }



    public ProductType getProductType() {
		return productType;
	}

	public void setProductType(ProductType productType) {
		this.productType = productType;
	}

	public ProductTypeService getService() {
		return service;
	}

	@Override
	public void getList() throws Exception {
    	GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer(" SELECT count(p) FROM ProductType p");
		StringBuffer    dsql = new StringBuffer(" SELECT p FROM ProductType p");
		gr.setTableAlias ("p");
		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
    	
	}

	@Override
    public void doSave() throws Exception {
        service.save(productType);
    }

    @Override
    public void edit(Integer id, HttpServletRequest req)
        throws Exception {
        // TODO Auto-generated method stub
    	productType = service.get(ProductType.class, id);
        req.setAttribute("productType", productType);
    }

    @Override
    public void ajaxDelete(Integer id) throws Exception {
        service.delete(ProductType.class, id);
    }
}
