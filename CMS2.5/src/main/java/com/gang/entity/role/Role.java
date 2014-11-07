package com.gang.entity.role;

import java.util.Set;

import com.gang.entity.BaseEntity;
import com.gang.entity.dict.Dict;
import com.gang.entity.menu.Menu;
import com.gang.entity.section.Section;
import com.google.gson.annotations.Expose;

public class Role extends BaseEntity {
	@Expose
	private String name;
	private Set<Menu> menus;
	@Expose
	private Dict type;
	private Section section;
	private boolean selected;

	public boolean getSelected() {
		return selected;
	}

	public void setSelected(boolean selected) {
		this.selected = selected;
	}

	public Section getSection() {
		return section;
	}

	public void setSection(Section section) {
		this.section = section;
	}

	public Dict getType() {
		return type;
	}

	public void setType(Dict type) {
		this.type = type;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public Set<Menu> getMenus() {
		return menus;
	}

	public void setMenus(Set<Menu> menus) {
		this.menus = menus;
	}
}
