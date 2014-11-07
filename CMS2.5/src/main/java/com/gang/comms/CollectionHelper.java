package com.gang.comms;

import java.util.ArrayList;
import java.util.Collection;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;
import java.util.Set;

import org.apache.commons.collections.CollectionUtils;

import com.gang.entity.BaseEntity;

public class CollectionHelper {
	public static <T> List<T> getList(Collection<T> c) {
		List<T> list = new ArrayList<T>(c);
		Collections.sort(list, new Comparator<T>() {

			@Override
			public int compare(T o1, T o2) {
				IOrder io = (IOrder) o1;
				IOrder iio = (IOrder) o2;
				return io.getOrderNumber() - iio.getOrderNumber();
			}
		});
		return list;
	}
	public static <T> List<T> sortList(Collection<T> c) {
		List<T> list = new ArrayList<T>(c);
		Collections.sort(list, new Comparator<T>() {

			@Override
			public int compare(T o1, T o2) {
				BaseEntity io = (BaseEntity) o1;
				BaseEntity iio = (BaseEntity) o2;
				return io.getId() - iio.getId();
			}
		});
		return list;
	}
	public static Boolean isEmpty(Collection coll)
	{
		return CollectionUtils.isEmpty(coll);
	}
	public static Boolean isNotEmpty(Collection coll)
	{
		return CollectionUtils.isNotEmpty(coll);
	}
}
