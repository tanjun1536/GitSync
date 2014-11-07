package com.gang.entity.statistics;

import java.util.ArrayList;
import java.util.List;

public class JSChart {
	private List<String> colorset=new ArrayList<String>();
	public List<String> getColorset() {
		return colorset;
	}

	public void setColorset(List<String> colorset) {
		this.colorset = colorset;
	}

	private List<ChartDataSet> datasets;
	private List<ChartOptionSet> optionset;

	public List<ChartDataSet> getDatasets() {
		return datasets;
	}

	public List<ChartOptionSet> getOptionset() {
		return optionset;
	}
	public void setDatasets(List<ChartDataSet> datasets) {
		this.datasets = datasets;
	}

	public void setOptionset(List<ChartOptionSet> optionset) {
		this.optionset = optionset;
	}
}
