package com.gang.entity.product;

import java.util.List;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;


public class Product extends BaseEntity {
    @Expose private String name;
    @Expose private Integer price;
    @Expose private Integer stock;
    @Expose private Integer tradeType;
    @Expose private ProductType type;
    @Expose private String description;
    @Expose private String image;
    @Expose private String url;
     private List<ProductImage> images;
    @Expose private Boolean tradable;
    @Expose private Integer userLimit;

    public Integer getUserLimit() {
    	if(userLimit==null)
    		userLimit=0;
		return userLimit;
	}

	public void setUserLimit(Integer userLimit) {
		this.userLimit = userLimit;
	}

	public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public Integer getPrice() {
        return price;
    }

    public void setPrice(Integer price) {
        this.price = price;
    }

    public Integer getStock() {
        return stock;
    }

    public void setStock(Integer stock) {
        this.stock = stock;
    }

    public Integer getTradeType() {
        return tradeType;
    }

    public void setTradeType(Integer tradeType) {
        this.tradeType = tradeType;
    }

    public ProductType getType() {
        return type;
    }

    public void setType(ProductType type) {
        this.type = type;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public String getUrl() {
        return url;
    }

    public void setUrl(String url) {
        this.url = url;
    }

    public List<ProductImage> getImages() {
        return images;
    }

    public void setImages(List<ProductImage> images) {
        this.images = images;
    }

    public Boolean getTradable() {
        return tradable;
    }

    public void setTradable(Boolean tradable) {
        this.tradable = tradable;
    }
}
