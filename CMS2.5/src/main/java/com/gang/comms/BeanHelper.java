package com.gang.comms;

import java.util.HashSet;
import java.util.Set;

import com.gang.entity.section.Section;
import com.thoughtworks.xstream.XStream;
import com.thoughtworks.xstream.hibernate.converter.HibernatePersistentCollectionConverter;
import com.thoughtworks.xstream.hibernate.converter.HibernatePersistentMapConverter;
import com.thoughtworks.xstream.hibernate.converter.HibernatePersistentSortedMapConverter;
import com.thoughtworks.xstream.hibernate.converter.HibernatePersistentSortedSetConverter;
import com.thoughtworks.xstream.io.xml.DomDriver;
import com.thoughtworks.xstream.mapper.Mapper;

public class BeanHelper {

	public static String toXML(Object bean, BeanClassAlias classAlias) {
		XStream xStream = new XStream(new DomDriver());
		xStream.alias(classAlias.getAlias(), classAlias.getClazz()); 
		xStream.autodetectAnnotations(true);
		xStream.addDefaultImplementation(org.hibernate.mapping.List.class, java.util.List.class);
		xStream.addDefaultImplementation(org.hibernate.mapping.Map.class, java.util.Map.class);
		xStream.addDefaultImplementation(org.hibernate.mapping.Set.class, java.util.Set.class);
		Mapper mapper = xStream.getMapper();   
		xStream.registerConverter(new HibernatePersistentCollectionConverter(mapper));   
		xStream.registerConverter(new HibernatePersistentMapConverter(mapper));  
		xStream.registerConverter(new HibernatePersistentSortedSetConverter(mapper));  
		xStream.registerConverter(new HibernatePersistentSortedMapConverter(mapper));  
		return xStream.toXML(bean);

	}

	public static void main(String[] args) {
		XStream xStream = new XStream(new DomDriver());
		Section s = new Section();
		s.setOrderNumber(1);
		s.setParent(new Section());
		Set<Section> ss = new HashSet<Section>();
		ss.add(new Section());
		s.setChildren(ss);
		xStream.alias("item", Section.class); // 指定class对应的节点名称，默认是完整package名称＋class名称
		xStream.aliasField("item",HashSet.class, "children");
		xStream.autodetectAnnotations(true);
		String str = xStream.toXML(s); // str为生成的xml，值为空的属性不生成节点。
		System.out.println(str);
	}

}
