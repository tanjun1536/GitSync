package com.gang.service.hot;

import com.gang.entity.hot.ArticleMobileHot;
import com.gang.service.BaseService;

public class HotService extends BaseService{
	public void addHot(ArticleMobileHot hot)
	{
		exec("update articlemobilehot set ordernumber=ordernumber+1");
		this.add(hot);
		hot.setOrderNumber(1);
	}
}
