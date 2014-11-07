package com.gang.service.section;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Iterator;
import java.util.LinkedHashSet;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;

import org.hibernate.Hibernate;
import org.hibernate.criterion.Restrictions;
import org.springframework.orm.hibernate3.HibernateTemplate;

import com.gang.comms.BeanClassAlias;
import com.gang.comms.BeanHelper;
import com.gang.comms.CollectionHelper;
import com.gang.comms.JSONHelper;
import com.gang.entity.section.Section;
import com.gang.service.BaseService;

public class SectionService extends BaseService {

	public Section getSection() {
		Section section = (Section) getCriteria(Section.class).add(Restrictions.isNull("parent")).uniqueResult();
		return section;
	}

	public String getSectionTreeXML() {
		Section section = (Section) getCriteria(Section.class).add(Restrictions.isNull("parent")).uniqueResult();
		String xml = BeanHelper.toXML(section, new BeanClassAlias("item", Section.class));
		xml = "<tree id='0'>" + xml + "</tree>";
		return xml;
	}

	public String getSectionTreeJSON() {
		List<Section> sections = getCriteria(Section.class).add(Restrictions.isNull("parent")).list();
		String json = JSONHelper.SerializeWithNeedAnnotation(sections);
		return json;
	}

	public void save(Section section) {
		this.getSession().saveOrUpdate(section);
	}

	public void update(Section section) {
		this.getSession().update(section);
	}

	public void delete(Integer id) {
		//删除文章
		//删除焦点
		//删除
		HibernateTemplate template = getHibernateTemplate();
		Section section = (Section) template.get(Section.class, id);
		try {
			if (section != null) {
				Hibernate.initialize(section.getChildren());
				template.deleteAll(section.getChildren());
				section.setChildren(null);
				template.delete(section);

			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		
	}

	public List<Section> getSectionByRoleIds(Integer[] roleIds) {
		String hql = "SELECT distinct s FROM Section AS s INNER JOIN s.roles AS r WHERE r.id in (:roleIds)";
		List<Section> sections = getHibernateTemplate().findByNamedParam(hql, "roleIds", roleIds);
		if (sections.size() == 1)
			return sections;
		List<Section> uniqueSections = new ArrayList<Section>();
		Map<String, Section> sectionMap = new HashMap<String, Section>();
		for (Section section : sections) {
			String parenrs = getParents(section);
			if (!sectionMap.containsKey(parenrs)) {
				sectionMap.put(parenrs, section);
			}
		}
		List<Map.Entry<String, Section>> list = new ArrayList<Map.Entry<String, Section>>(sectionMap.entrySet());

		Collections.sort(list, new Comparator<Map.Entry<String, Section>>() {
			public int compare(Map.Entry<String, Section> o1, Map.Entry<String, Section> o2) {
				return (o1.getKey()).toString().compareTo(o2.getKey());
			}
		});
		// System.out.println("删除前-------------");
		String currKey = null;
		for (Entry<String, Section> es : list) {
			String key = es.getKey();
			// System.out.println(key);
			if (currKey == null) {
				currKey = key;
			} else {
				if (key.contains(currKey)) {
					sectionMap.remove(key);
				} else {
					currKey = key;
				}
			}
		}
		Iterator<String> iter = sectionMap.keySet().iterator();
		// System.out.println("删除后-------------");
		while (iter.hasNext())
			// System.out.println(iter.next());
			uniqueSections.add(sectionMap.get(iter.next()));
		//排序
		Collections.sort(uniqueSections, new Comparator<Section>() {
			public int compare(Section o1, Section o2) {
				return (o1.getOrderNumber()).compareTo(o2.getOrderNumber());
			}
		});
		return uniqueSections;

	}

	private String getParents(Section section) {
		String p = section.getId().toString();
		Section sec = section.getParent();
		while (sec != null) {
			p = sec.getId() + "-" + p;
			sec = sec.getParent();
		}
		return p;
	}

	public String getSectionsJson(Integer[] roleIds) {
		List<Section> sections = getSectionByRoleIds(roleIds);
		return JSONHelper.SerializeWithNeedAnnotation(sections);
	}
	public String getSectionsJson(Integer[] roleIds,int type) {
		//排序
		List<Section> sections = CollectionHelper.sortList(getSectionByRoleIds(roleIds));
		List<Section> ss=new ArrayList<Section>();
		//根据所有根节点来判定是否应该显示
		for(Section s:sections)
		{
			if(s.getId().equals(1))
			{
				Section root=new Section();
				root.setId(1);
				root.setText("i南充");
				root.setChildren(new LinkedHashSet<Section>());
				//排序
				List<Section> children=CollectionHelper.sortList(s.getChildren());
				for(Section c:children)
				{
					if(c.getSectionType()!=null && c.getSectionType().getId().intValue()==type)
					{
						root.getChildren().add(c);
					}
				}
				ss.add(root);
				
			}
			else
			{
				if(s.getSectionType()!=null && s.getSectionType().getId().intValue()==type)
				{
					ss.add(s);
				}
			}
			
		}
		return JSONHelper.SerializeWithNeedAnnotation(ss);
	}

	public int getSectionType(Integer id) {
		Section s=get(Section.class, id);
		return s.getSectionType().getId();
	}
}
