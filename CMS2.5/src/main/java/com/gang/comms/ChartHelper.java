package com.gang.comms;

import java.lang.reflect.Field;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.List;

import org.springframework.util.StringUtils;

import com.gang.entity.statistics.Chart;
import com.gang.entity.statistics.ChartData;
import com.gang.entity.statistics.ChartDataSet;
import com.gang.entity.statistics.JSChart;

public class ChartHelper {
	public static Chart getChart(String id, String type, List<ChartData> datas, List<String> colors) {
		Chart c = new Chart();
		JSChart jSChart = new JSChart();
		jSChart.setColorset(colors);
		List<ChartDataSet> datasets = new ArrayList<ChartDataSet>();
		ChartDataSet cds = new ChartDataSet();
		cds.setType(type);
		cds.setId(id);
		cds.setData(datas);
		datasets.add(cds);
		jSChart.setDatasets(datasets);
		c.setjSChart(jSChart);
		return c;

	}

	public static Chart getChart(String id, String type, List<ChartData> datas) {
		Chart c = new Chart();
		JSChart jSChart = new JSChart();
		List<ChartDataSet> datasets = new ArrayList<ChartDataSet>();
		ChartDataSet cds = new ChartDataSet();
		cds.setType(type);
		cds.setId(id);
		cds.setData(datas);
		datasets.add(cds);
		jSChart.setDatasets(datasets);
		c.setjSChart(jSChart);
		return c;

	}

	public static Chart getChart(String type, List<ChartData> datas) {
		Chart c = new Chart();
		JSChart jSChart = new JSChart();
		List<ChartDataSet> datasets = new ArrayList<ChartDataSet>();
		ChartDataSet cds = new ChartDataSet();
		cds.setType(type);
		cds.setData(datas);
		datasets.add(cds);
		jSChart.setDatasets(datasets);
		c.setjSChart(jSChart);
		return c;

	}

	public static String getChart(List<ChartData> list) {
		StringBuilder sb = new StringBuilder();
		int i = 0;
		sb.append("[");
		for (ChartData c : list) {
			sb.append("[");
			sb.append("'");
			sb.append(c.getUnit());
			sb.append("'");
			sb.append(",");
			sb.append(c.getValue());
			if (i < list.size() - 1)
				sb.append("],");
			else
				sb.append("]");
			i++;

		}
		sb.append("]");
		return sb.toString();
	}
}
