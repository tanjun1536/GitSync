package com.gang.entity.statistics;

import com.google.gson.annotations.SerializedName;

public class Chart {
	@SerializedName("JSChart")
	private JSChart jSChart;

	public JSChart getjSChart() {
		return jSChart;
	}

	public void setjSChart(JSChart jSChart) {
		this.jSChart = jSChart;
	}
}
