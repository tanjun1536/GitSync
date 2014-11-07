package com.gang.service.image;

import java.util.List;

import org.hibernate.Criteria;
import org.hibernate.Hibernate;
import org.hibernate.Session;
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Projections;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.entity.department.Department;
import com.gang.entity.image.ImageInfo;
import com.gang.service.BaseService;

public class ImageInfoService extends BaseService{

	public ImageInfo getImageInfoById(int id){
		ImageInfo img = (ImageInfo)get(ImageInfo.class, id);
		Hibernate.initialize(img.getSection());
		return img;
	}
	public void delete(ImageInfo image){
		super.delete(ImageInfo.class, image.getId());
	}
	public void save(ImageInfo image){
		super.save(image);
	}
	
	public GridPageResponse getImageInfo(GridPageRequest req, ImageInfo image){
		GridPageResponse res = new GridPageResponse();
		res.setRows(getImageInfoListByPage(req, image));
		res.setRecords(getImageInfoCount(image));
		res.setTotal((int)Math.ceil((double)res.getRecords()/req.getPageSize()));
		return res;
	}
	
	public List<ImageInfo> getImageInfoListByPage(GridPageRequest req, ImageInfo image){
		Criteria c = super.getCriteria(ImageInfo.class);
		buildWhere(c, image);
		c.addOrder(Order.desc("id"));
		c.setFirstResult(req.getStartNumber());
		c.setMaxResults(req.getPageSize());
		return c.list();
	}
	
	public Integer getImageInfoCount(ImageInfo image){
		Criteria c = super.getCriteria(ImageInfo.class);
		c.setProjection(Projections.count("id"));
		buildWhere(c, image);
		return Integer.parseInt(c.uniqueResult().toString());
	}
	
	private void buildWhere(Criteria c, ImageInfo image){
		if(image != null){
			if(image.getUser() != null && image.getUser().getId() != null){
				c.add(Restrictions.eq("user.id", image.getUser().getId()));
			}
			if(image.getSection() != null && image.getSection().getId() != null){
				c.add(Restrictions.eq("section.id", image.getSection().getId()));
			}
		}
	}
	
	public void update(ImageInfo image){
		Session session = getSession();
		ImageInfo oldImage = (ImageInfo)session.get(ImageInfo.class, image.getId());
		oldImage.setName(image.getName());
		oldImage.setSort(image.getSort());
		oldImage.setDes(image.getDes());
	}
}
