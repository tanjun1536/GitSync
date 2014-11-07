package com.gang.entity.statistics;

import java.util.List;

public class ChartDataSet {
	private List<ChartData> data;
	private String id;
	private String type;
	public List<ChartData> getData() {
		return data;
	}
	public String getId() {
		return id;
	}
	public String getType() {
		return type;
	}
	public void setData(List<ChartData> data) {
		this.data = data;
	}
	public void setId(String id) {
		this.id = id;
	}
	public void setType(String type) {
		this.type = type;
	}
}
