package com.gang.service.statistics;

import java.util.List;

import com.gang.entity.statistics.ChartData;
import com.gang.entity.user.Terminal;
import com.gang.service.BaseService;

public class StatisticsService extends BaseService {
	@SuppressWarnings("unchecked")
	public List<ChartData> getClientDistribute() {
		List<ChartData> list = null;
		final String sql = "SELECT softType as unit, CONCAT('<a href=\"javascript:void()\" onclick=\"detail(','''',softType,'''',')\" >',softType,'</a>') AS link  ,COUNT(id) AS VALUE  FROM terminal  WHERE softType !=''  GROUP BY softType";
		try {
			list = execute(ChartData.class, sql);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return list;
	}

	@SuppressWarnings("unchecked")
	public List<ChartData> getChartDatas(String sql) {
		List<ChartData> list = null;
		try {
			list = execute(ChartData.class, sql);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return list;
	}

	public List<Terminal> getClientDistributeDetail(String detail) {
		return getList(Terminal.class, "softType", detail);
	}

	public List<ChartData> getClientDistributeChartByVersion() {
		List<ChartData> list = null;
		final String sql = "SELECT softVersion as unit, COUNT(id) AS VALUE  FROM terminal  WHERE softVersion !=''  GROUP BY softVersion";
		try {
			list = execute(ChartData.class, sql);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return list;
	}
}
