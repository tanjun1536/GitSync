package com.gang.entity.menu;

import java.util.Set;

import com.gang.comms.IOrder;
import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class Menu extends BaseEntity implements IOrder{
	@Expose
	@SerializedName("text")
	private String name;
	private String link;
	private String image;
	private Menu parent;
	private boolean selected;
	@Expose
	private boolean checked;
	@Expose
	private Set<Menu> children;

	public Set<Menu> getChildren() {
		return children;
	}

	public void setChildren(Set<Menu> children) {
		this.children = children;
	}

	public Menu getParent() {
		return parent;
	}

	public void setParent(Menu parent) {
		this.parent = parent;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getLink() {
		return link;
	}

	public void setLink(String link) {
		this.link = link;
	}

	public String getImage() {
		return image;
	}

	public void setImage(String image) {
		this.image = image;
	}

	public boolean getSelected() {
		return selected;
	}

	public void setSelected(boolean selected) {
		this.selected = selected;
	}

	public boolean isChecked() {
		return checked;
	}

	public void setChecked(boolean checked) {
		this.checked = checked;
	}
}
