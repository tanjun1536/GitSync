package com.gang.action.statistics;

import java.util.List;

import com.gang.action.DefaultAction;
import com.gang.comms.ChartHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;
import com.gang.entity.statistics.ActiveUser;
import com.gang.entity.statistics.BackUserSendArticle;
import com.gang.entity.statistics.ChartData;
import com.gang.entity.statistics.ClickRateDetail;
import com.gang.entity.statistics.JSChartData;
import com.gang.entity.user.Terminal;
import com.gang.service.statistics.StatisticsService;

public class StatisticsAction extends DefaultAction {
	// ~ Static fields/initializers
	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private static final long serialVersionUID = 1L;

	// ~ Instance fields
	// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private StatisticsService service;

	// ~ Methods
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public void getClientDistributeChart() {
		List<ChartData> list = service.getClientDistribute();
		String json = ChartHelper.getChart(list);
		Write(json);
	}
	public void getClientDistributeChartByVersion() {
		List<ChartData> list = service.getClientDistributeChartByVersion();
		String json = ChartHelper.getChart(list);
		Write(json);
	}
	
	public void getClientDistributeTable() {
		List<ChartData> list = service.getClientDistribute();
		GridPageResponse gpr = service.getGridPage(list);
		String json = JSONHelper.Serialize(gpr);
		Write(json);
	}

	public void getClientDistributeTableDetail() {
		String detail = getString("detail");
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer(
				" SELECT count(t) FROM Terminal t  WHERE (t.softType='"
						+ detail + "')");
		StringBuffer dsql = new StringBuffer(
				" SELECT t FROM Terminal t  WHERE (t.softType='" + detail
						+ "')");
		gr.setTableAlias("t");
		gr.setHsql(true);
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(Terminal.class);
		gr.setUserResultTransformer(true);

		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.Serialize(gpr);
		Write(json);
	}

	private String getWhere(String alise, boolean hasWhere) {
		String startDate = getString("startDate");
		String endDate = getString("endDate");
		StringBuffer where = new StringBuffer();

		if (StringHelper.isBlank(startDate) && StringHelper.isBlank(endDate)) {
			return where.toString();
		}

		if (hasWhere) {
			where.append(" AND ");
		} else {
			where.append(" WHERE ");
		}

		if (StringHelper.isNotBlank(startDate)) {
			where.append(alise);
			where.append(".`clickDateTime` >='");
			where.append(startDate);
			where.append("'");
		}

		if (StringHelper.isNotBlank(endDate)) {
			if(where.length()>0)
			{	where.append(" AND ");
			} else {
				where.append(" WHERE ");
			}
			where.append(alise);
			where.append(".`clickDateTime` <='");
			where.append(endDate);
			where.append(" 23:59:59'");
		}

		return where.toString();
	}

	public void getClickRateByType() {
		GridPageRequest gr = new GridPageRequest(getRequest());
		String type = getString("type");

		StringBuffer csql = new StringBuffer();
		StringBuffer dsql = new StringBuffer();

		if (("chanel").equals(type)) {
			csql.append("SELECT COUNT(*) FROM ")
					.append("(SELECT ")
					.append(" COUNT(sr.`id`) VALUE,")
					.append(" s.`text` unit ")
					.append("FROM ")
					.append("`sectionclickrate` sr ")
					.append("INNER JOIN section s ")
					.append(" ON sr.`clickId` = s.`id` ")
					.append(" WHERE s.`parentId` = 1 ")
					.append(getWhere("sr", true))
					.append(" GROUP BY s.`text`) z  WHERE z.VALUE IS NOT NULL ");
			dsql.append("SELECT * FROM (")
					.append("SELECT ")
					.append("CONCAT('<a href=\"javascript:void()\" onclick=\"detail(','''',s.`id`,'''',')\" >',s.`text`,'</a>') AS link,")
					.append("COUNT(sr.`clickId`) VALUE,")
					.append(" s.`text` unit ").append("FROM ")
					.append("`sectionclickrate` sr ")
					.append("INNER JOIN section s ")
					.append("ON sr.`clickId` = s.`id` ")
					.append(" WHERE s.`parentId` = 1 ")
					.append(getWhere("sr", true)).append(" GROUP BY s.`text`")
					.append(" ) z");
		} else if (("section").equals(type)) {
			csql.append("SELECT COUNT(*) FROM ").append("(SELECT ")
					.append(" COUNT(sr.`id`) VALUE,").append(" s.`text` unit ")
					.append("FROM").append("`sectionclickrate` sr ")
					.append("INNER JOIN section s ")
					.append(" ON sr.`clickId` = s.`id` ")
					.append(" WHERE s.`parentId` <> 1 and s.`id`<>1 ")
					.append(getWhere("sr", true))
					.append("GROUP BY s.`text`) z  WHERE z.VALUE IS NOT NULL");
			dsql.append("SELECT * FROM (")
					.append("SELECT ")
					.append("CONCAT('<a href=\"javascript:void()\" onclick=\"detail(','''',s.`id`,'''',')\" >',s.`text`,'</a>') AS link,")
					.append("COUNT(sr.`clickId`) VALUE,")
					.append(" s.`text` unit ").append("FROM")
					.append("`sectionclickrate` sr ")
					.append("INNER JOIN section s ")
					.append("ON sr.`clickId` = s.`id` ")
					.append(" WHERE s.`parentId` <> 1 and s.`id`<>1")
					.append(getWhere("sr", true)).append(" GROUP BY s.`text`")
					.append(" ) z");
		} else if (("article").equals(type)) {
			csql.append("SELECT COUNT(*) FROM ( ").append("SELECT ")
					.append("COUNT(ac.`id`) VALUE,").append("am.`title`")
					.append("FROM ").append("articlemobileclickrate ac ")
					.append("INNER JOIN articlemobile am ")
					.append("ON ac.`clickId` = am.`id` ")
					.append(getWhere("ac", false))
					.append(" GROUP BY am.`id`,am.`title`")
					.append(") z WHERE z.VALUE IS NOT NULL");
			dsql.append("SELECT * FROM (")
					.append("SELECT ")
					.append("CONCAT( ")
					.append("'<a href=\"javascript:void()\" onclick=\"detail(',")
					.append(" '''',").append(" am.`id`,").append(" '''',")
					.append(" ')\" >',").append(" am.`title`,")
					.append(" '</a>'").append(") AS link,")
					.append("COUNT(ac.`id`) VALUE,").append("am.`title` unit ")
					.append("FROM ").append("articlemobileclickrate ac ")
					.append("INNER JOIN articlemobile am ")
					.append("ON ac.`clickId` = am.`id` ")
					.append(getWhere("ac", false))
					.append(" GROUP BY am.`title`").append(" ) z");
		} else if (("focus").equals(type)) {
			csql.append("SELECT COUNT(*) FROM ( ").append("SELECT ")
					.append("COUNT(afc.`id`) VALUE,").append("sf.`title`")
					.append(" FROM ")
					.append("articlemobilefocusclickrate afc ")
					.append("INNER JOIN sectionfocus sf ")
					.append("ON afc.`clickId` = sf.`id` ")
					.append(getWhere("afc", false))
					.append(" GROUP BY sf.`title`")
					.append(") z WHERE z.VALUE IS NOT NULL");
			dsql.append("SELECT * FROM ( ")
					.append("SELECT ")
					.append("CONCAT(")
					.append("'<a href=\"javascript:void()\" onclick=\"detail(',")
					.append(" '''',").append(" sf.`id`,").append(" '''',")
					.append(" ')\" >',").append(" sf.`title`,")
					.append(" '</a>'").append(") AS link,")
					.append("COUNT(afc.`id`) VALUE,")
					.append("sf.`title` unit ").append("FROM ")
					.append("articlemobilefocusclickrate afc  ")
					.append("INNER JOIN sectionfocus sf  ")
					.append("ON afc.`clickId` = sf.`id` ")
					.append(getWhere("afc", false))
					.append(" GROUP BY sf.`title`").append(" ) z");
		}

		gr.setTableAlias("z");
		gr.setOrderColumn("VALUE");
		gr.setOrderType("DESC");
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(ChartData.class);
		gr.setUserResultTransformer(true);

		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.Serialize(gpr);
		Write(json);
	}

	public void getClickRateByTypeDetail() {
		GridPageRequest gr = new GridPageRequest(getRequest());
		String type = getString("type");
		String id = getString("id");
		StringBuffer csql = new StringBuffer();
		StringBuffer dsql = new StringBuffer();

		if (("chanel").equals(type) || ("section").equals(type)) {
			csql.append("SELECT ").append("COUNT(*) ").append("FROM ")
					.append("sectionclickrate sc ").append("LEFT JOIN USER u ")
					.append(" ON sc.`activeKey` = u.activekey ")
					.append(" INNER JOIN section s  ")
					.append(" ON sc.`clickId` = s.`id` ")
					.append(" WHERE s.`id` =").append(id)
					.append(getWhere("sc", true));
			dsql.append("SELECT ")
					.append(" s.`text` title,u.`nick` userName,sc.`deviceType`,sc.`clickDateTime` ,sc.activeKey ")
					.append("FROM ").append("sectionclickrate sc ")
					.append("LEFT JOIN USER u ")
					.append(" ON sc.`activeKey` = u.activekey ")
					.append(" INNER JOIN section s  ")
					.append(" ON sc.`clickId` = s.`id` ")
					.append(" WHERE s.`id` =").append(id)
					.append(getWhere("sc", true));
			gr.setTableAlias("s");
		} else if (("article").equals(type)) {
			csql.append("SELECT ").append("COUNT(*) ").append("FROM ")
					.append("articlemobileclickrate amc ")
					.append("LEFT JOIN USER u ")
					.append(" ON amc.`activeKey` = u.activekey ")
					.append(" INNER JOIN articlemobile am  ")
					.append(" ON amc.`clickId` = am.`id` ")
					.append(" WHERE am.`id` =").append(id)
					.append(getWhere("amc", true));
			dsql.append("SELECT ")
					.append(" am.`title` title,u.`nick` userName,amc.`deviceType`,amc.`clickDateTime` ,amc.activeKey ")
					.append("FROM ").append("articlemobileclickrate amc ")
					.append("LEFT JOIN USER u ")
					.append(" ON amc.`activeKey` = u.activekey ")
					.append(" INNER JOIN articlemobile am  ")
					.append(" ON amc.`clickId` = am.`id` ")
					.append(" WHERE am.`id` =").append(id)
					.append(getWhere("amc", true));
			gr.setTableAlias("am");
		} else if (("focus").equals(type)) {
			csql.append("SELECT ").append("COUNT(*) ").append("FROM ")
					.append("articlemobilefocusclickrate smfc ")
					.append("LEFT JOIN USER u ")
					.append(" ON smfc.`activeKey` = u.activekey ")
					.append(" INNER JOIN sectionfocus sf  ")
					.append(" ON smfc.`clickId` = sf.`id` ")
					.append(" WHERE sf.`id` =").append(id)
					.append(getWhere("smfc", true));
			dsql.append("SELECT ")
					.append(" s.`text` title,u.`nick` userName,smfc.`deviceType`,smfc.`clickDateTime` ,smfc.activeKey ")
					.append("FROM ").append("sectionclickrate sc ")
					.append("LEFT JOIN USER u ")
					.append(" ON smfc.`activeKey` = u.activekey ")
					.append(" INNER JOIN sectionfocus sf  ")
					.append(" ON smfc.`clickId` = sf.`id` ")
					.append(" WHERE sf.`id` =").append(id)
					.append(getWhere("sc", true));
			gr.setTableAlias("sf");
		}

		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(ClickRateDetail.class);
		gr.setUserResultTransformer(true);

		try {
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.Serialize(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void getClickRateByTypeChart() {
		String type = getString("type");
		String year = getString("year");
		String month = getString("month");
		String day = getString("day");
		String week=getString("week");
		String id = getString("id");
		StringBuffer sql = new StringBuffer();
		String groupby = getGroupBy(year, month, day, "c", "`clickDateTime`");
		String unit = getUnit(year, month, day, "c", "`clickDateTime`");

		String where = getWhere(year, month,week, day, "c", "`clickDateTime`");
		String table = getTable(year, month, day);
		String outwhere = getOutWhere(year, month, day);

		if (("chanel").equals(type) || ("section").equals(type)) {
			sql.append("SELECT    CONCAT(s.`stat`,'') unit,IFNULL(z.`value`, 0) AS `value`  ");
			sql.append("FROM ");
			sql.append(table).append(" s ");
			sql.append(" LEFT OUTER JOIN ");
			sql.append(" (SELECT ");
			sql.append(unit);
			sql.append(", COUNT(c.id) AS `value` ");
			sql.append(" FROM ");
			sql.append(" section s INNER JOIN sectionclickrate c ");
			sql.append(" ON s.`id` = c.`clickId`  ");
			sql.append("  WHERE s.`id` = ");
			sql.append(id);
			sql.append(where);
			sql.append(" GROUP BY ");
			sql.append(groupby);
			sql.append(" ) z   ON s.`stat` = unit ORDER BY s.`stat`");
			sql.append(outwhere);
		} else if (("article").equals(type)) {
			sql.append("SELECT    CONCAT(s.`stat`,'') unit,IFNULL(z.`value`, 0) AS `value` ");
			sql.append("FROM ");
			sql.append(table).append(" s ");
			sql.append(" LEFT OUTER JOIN ");
			sql.append(" (SELECT ");
			sql.append(unit);
			sql.append(", COUNT(c.id) AS `value` ");
			sql.append(" FROM ");
			sql.append(" articlemobile s INNER JOIN articlemobileclickrate c ");
			sql.append(" ON s.`id` = c.`clickId`  ");
			sql.append("  WHERE s.`id` = ");
			sql.append(id);
			sql.append(where);
			sql.append(" GROUP BY ");
			sql.append(groupby);
			sql.append(" ) z   ON s.`stat` = unit ORDER BY s.`stat`");
			sql.append(outwhere);
		} else if (("focus").equals(type)) {
			sql.append("SELECT    CONCAT(s.`stat`,'') unit,IFNULL(z.`value`, 0) AS `value` ");
			sql.append("FROM ");
			sql.append(table).append(" s ");
			sql.append(" LEFT OUTER JOIN ");
			sql.append(" (SELECT ");
			sql.append(unit);
			sql.append(", COUNT(c.id) AS `value` ");
			sql.append(" FROM ");
			sql.append(" sectionfocus s INNER JOIN articlemobilefocusclickrate c ");
			sql.append(" ON s.`id` = c.`clickId`  ");
			sql.append("  WHERE s.`id` = ");
			sql.append(id);
			sql.append(where);
			sql.append(" GROUP BY ");
			sql.append(groupby);
			sql.append(" ) z   ON s.`stat` = unit ORDER BY s.`stat`");
			sql.append(outwhere);
		}

		try {

			List<ChartData> list = service.getChartDatas(sql.toString());

			Integer vol = service.getInteger("SELECT SUM(`value`) FROM (" + sql
					+ ") z");

			String json = ChartHelper.getChart(list);
			json = json.replace("'", "");
			JSChartData cd = new JSChartData();
			cd.setVol(vol.toString());
			cd.setJson(json);
			String ret=JSONHelper.Serialize(cd);
			Write(ret);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	private String getOutWhere(String year, String month, String day) {
		// TODO Auto-generated method stub
		if (StringHelper.isNotBlank(year) && StringHelper.isNotBlank(month)
				&& StringHelper.isBlank(day)) {
			// return "WHERE s.stat <=";
		}
		return "";
	}

	private String getUnit(String year, String month, String day, String alies,
			String datecolumn) {
		String unit = null;
		if (StringHelper.isNotBlank(year)) {
			unit = "MONTH(" + alies + "." + datecolumn + ") AS unit ";
		}

		if (StringHelper.isNotBlank(month)) {
			unit = "DAY(" + alies + "." + datecolumn + ") AS unit ";
		}

		if (StringHelper.isNotBlank(day)) {
			unit = "HOUR(" + alies + "." + datecolumn + ") AS unit ";
		}
		return unit;
	}

	private String getTable(String year, String month, String day) {
		String table = null;
		if (StringHelper.isNotBlank(year)) {
			table = "stat_month";
		}

		if (StringHelper.isNotBlank(month)) {
			table = "stat_day";
		}

		if (StringHelper.isNotBlank(day)) {
			table = "stat_hour";
		}
		return table;
	}

	private String getWhere(String year, String month,String week, String day,
			String alies, String datecolumn) {
		StringBuffer c = new StringBuffer(" AND CONCAT(");
		StringBuffer v = new StringBuffer("'");

		if (StringHelper.isNotBlank(year)) {
			c.append("YEAR");
			c.append("(");
			c.append(alies);
			c.append(".");
			c.append(datecolumn);
			c.append(")");

			v.append(year);
		}

		if (StringHelper.isNotBlank(month)) {
			c.append(",'-',");
			c.append("MONTH");
			c.append("(");
			c.append(alies);
			c.append(".");
			c.append(datecolumn);
			c.append(")");

			v.append("-");
			v.append(month);
		}
		if(StringHelper.isNotBlank(week) && StringHelper.isBlank(day))
		{
			String se[]=week.split(",");
			String start=se[0];
			String end=se[1];
			StringBuffer sb=new StringBuffer();
			sb.append(" AND ");
			sb.append(alies);
			sb.append(".");
			sb.append(datecolumn);
			sb.append(">=");
			sb.append("'");
			sb.append(start);
			sb.append("'");
			sb.append(" AND ");
			sb.append(alies);
			sb.append(".");
			sb.append(datecolumn);
			sb.append("<=");
			sb.append("'");
			sb.append(end);
			sb.append(" 23:59:59");
			sb.append("'");
			return sb.toString();
		}
		if (StringHelper.isNotBlank(day)) {
			c.append(",'-',");
			c.append("DAY");
			c.append("(");
			c.append(alies);
			c.append(".");
			c.append(datecolumn);
			c.append(")");

			v.append("-");
			v.append(day);
		}

		c.append(") = ");
		v.append("'");

		c.append(v);

		return c.toString();
	}

	private String getGroupBy(String year, String month, String day,
			String alies, String datecolumn) {
		StringBuffer sb = new StringBuffer("CONCAT(");

		if (StringHelper.isNotBlank(year)) {
			sb.append("YEAR");
			sb.append("(");
			sb.append(alies);
			sb.append(".");
			sb.append(datecolumn);
			sb.append(")");
			sb.append(",'-',");
			sb.append("MONTH");
			sb.append("(");
			sb.append(alies);
			sb.append(".");
			sb.append(datecolumn);
			sb.append(")");
		}

		if (StringHelper.isNotBlank(month)) {
			sb.append(",'-',");
			sb.append("DAY");
			sb.append("(");
			sb.append(alies);
			sb.append(".");
			sb.append(datecolumn);
			sb.append(")");
		}

		if (StringHelper.isNotBlank(day)) {
			sb.append(",'-',");
			sb.append("HOUR");
			sb.append("(");
			sb.append(alies);
			sb.append(".");
			sb.append(datecolumn);
			sb.append(")");
		}

		sb.append(")");

		return sb.toString();
	}

	public void getActiveUser() {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer();
		StringBuffer dsql = new StringBuffer();
		csql.append("SELECT COUNT(*) FROM ( ")
				.append("SELECT  COUNT(z.activeKey) activeUsers,")
				.append("CONCAT(")
				.append("'<a href=\"javascript:void()\" onclick=\"detail(',")
				.append("'''',").append("z.clickdatetime,").append("'''',")
				.append("')\" >',").append("z.clickdatetime,")
				.append(" '</a>'").append(" ) AS activeDateTime ")
				.append("FROM ").append("(SELECT  ")
				.append("DATE(m.clickdatetime) clickdatetime, ")
				.append(" m.activekey  ").append(" FROM ").append("(SELECT  ")
				.append("*  ").append(" FROM ")
				.append("articlemobileclickrate amcr  ").append(" UNION ")
				.append("ALL  ").append(" SELECT ").append(" *  ")
				.append("  FROM ").append(" sectionclickrate scr  ")
				.append(" UNION ").append(" ALL  ").append("SELECT ")
				.append("* ").append("FROM")
				.append(" articlemobilefocusclickrate amfcr) m ")
				.append(" GROUP BY DATE(m.clickdatetime),")
				.append("m.activekey) z ").append("GROUP BY z.clickDateTime")
				.append(") zz ");

		dsql.append("SELECT  COUNT(z.clickdatetime) value,")
				.append("CONCAT(")
				.append("'<a href=\"javascript:void()\" onclick=\"detail(',")
				.append("'''',").append("z.clickdatetime,").append("'''',")
				.append("')\" >',").append("z.clickdatetime,")
				.append(" '</a>'").append(" ) AS link ")
				.append("FROM ").append("(SELECT  ")
				.append("DATE(m.clickdatetime) clickdatetime, ")
				.append(" m.activekey  ").append(" FROM ").append("(SELECT  ")
				.append("*  ").append(" FROM ")
				.append("articlemobileclickrate amcr  ").append(" UNION ")
				.append("ALL  ").append(" SELECT ").append(" *  ")
				.append("  FROM ").append(" sectionclickrate scr  ")
				.append(" UNION ").append(" ALL  ").append("SELECT ")
				.append("* ").append("FROM")
				.append(" articlemobilefocusclickrate amfcr) m ")
				.append(" GROUP BY DATE(m.clickdatetime),")
				.append("m.activekey) z ").append("GROUP BY z.clickDateTime")
				.append(" ORDER BY z.clickDateTime DESC  ");
		gr.setOrderBy(false);
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(ChartData.class);
		gr.setUserResultTransformer(true);

		try {
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.Serialize(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	public void getActiveUserDetail() {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer();
		StringBuffer dsql = new StringBuffer();
		String date = getString("date");
		csql.append("SELECT COUNT(*) FROM ( ")
				.append("SELECT * FROM (SELECT ")
				.append(" DATE(m.clickdatetime) clickdatetime,")
				.append(" m.activekey ,m.devicetype")
				.append(" FROM ")
				.append(" (SELECT ")
				.append(" * ")
				.append(" FROM")
				.append(" articlemobileclickrate amcr ")
				.append(" UNION")
				.append(" ALL ")
				.append(" SELECT ")
				.append(" * ")
				.append(" FROM ")
				.append(" sectionclickrate scr ")
				.append(" UNION")
				.append(" ALL ")
				.append(" SELECT ")
				.append("  * ")
				.append(" FROM ")
				.append(" articlemobilefocusclickrate amfcr) m ")
				.append(" GROUP BY DATE(m.clickdatetime),")
				.append(" m.activekey ) z WHERE z.clickdatetime ='" + date
						+ "'").append(" ) z");
		dsql.append("SELECT activekey,devicetype FROM (SELECT ")
				.append(" DATE(m.clickdatetime) clickdatetime,")
				.append(" m.activekey ,m.devicetype")
				.append(" FROM")
				.append(" (SELECT ")
				.append(" * ")
				.append(" FROM")
				.append(" articlemobileclickrate amcr ")
				.append(" UNION")
				.append(" ALL ")
				.append(" SELECT ")
				.append(" * ")
				.append(" FROM")
				.append(" sectionclickrate scr ")
				.append(" UNION")
				.append(" ALL ")
				.append(" SELECT ")
				.append("  * ")
				.append(" FROM ")
				.append(" articlemobilefocusclickrate amfcr) m ")
				.append(" GROUP BY DATE(m.clickdatetime),")
				.append(" m.activekey ) z WHERE z.clickdatetime ='" + date
						+ "'");
		gr.setOrderBy(false);
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(ActiveUser.class);
		gr.setUserResultTransformer(true);

		try {
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.Serialize(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void getActiveUserDetailDetail() {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer();
		StringBuffer dsql = new StringBuffer();
		String id = getString("id");
		csql.append("SELECT COUNT(*) FROM ( ")
				.append("SELECT *,'文章阅读' activityType FROM articlemobileclickrate amcr UNION ALL ")
				.append("SELECT *,'频道阅读' activityType FROM sectionclickrate scr UNION ALL ")
				.append("SELECT *,'焦点阅读' activityType FROM articlemobilefocusclickrate amfcr ) z  ")
				.append("INNER JOIN USER u ON z.activeKey =u.`activeKey` WHERE u.`id` = ")
				.append(id);
		dsql.append(
				"SELECT u.`activeKey`,u.`nick` AS userName,u.`sex`,z.activityType FROM ( ")
				.append("SELECT *,'文章阅读' activityType FROM articlemobileclickrate amcr UNION ALL ")
				.append("SELECT *,'频道阅读' activityType FROM sectionclickrate scr UNION ALL ")
				.append("SELECT *,'焦点阅读' activityType FROM articlemobilefocusclickrate amfcr ) z   ")
				.append("INNER JOIN USER u ON z.activeKey =u.`activeKey` WHERE u.`id` = ")
				.append(id);
		gr.setTableAlias("u");
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(ActiveUser.class);
		gr.setUserResultTransformer(true);

		try {
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.Serialize(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void getBackUserSendArticle() {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer();
		StringBuffer dsql = new StringBuffer();
		String id = getString("id");
		csql.append("SELECT COUNT(*) FROM ( ")
				.append("SELECT COUNT(am.id) c,u.`name` ")
				.append("FROM articlemobile am INNER JOIN backuser u ON am.`sender` = u.`id` ")
				.append("GROUP BY u.`name` )z WHERE c is not null");
		dsql.append("SELECT COUNT(am.id) c,u.`name` ")
				.append("FROM articlemobile am INNER JOIN backuser u ON am.`sender` = u.`id` ")
				.append("GROUP BY u.`name` ");
		gr.setTableAlias("u");
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(BackUserSendArticle.class);
		gr.setUserResultTransformer(true);

		try {
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.Serialize(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void getBackUserSendArticleDetail() {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer();
		StringBuffer dsql = new StringBuffer();
		String id = getString("id");
		csql.append("SELECT COUNT(*) FROM ( ")
				.append("SELECT COUNT(am.id) c,u.`name` ")
				.append("FROM articlemobile am INNER JOIN backuser u ON am.`sender` = u.`id` ")
				.append("GROUP BY u.`name` )z WHERE c is not null");
		dsql.append(
				"SELECT u.`activeKey`,u.`nick` AS userName,u.`sex`,z.activityType FROM ( ")
				.append("SELECT *,'文章阅读' activityType FROM articlemobileclickrate amcr UNION ALL ")
				.append("SELECT *,'频道阅读' activityType FROM sectionclickrate scr UNION ALL ")
				.append("SELECT *,'焦点阅读' activityType FROM articlemobilefocusclickrate amfcr ) z   ")
				.append("INNER JOIN USER u ON z.activeKey =u.`activeKey` WHERE u.`id` = ")
				.append(id);
		gr.setTableAlias("u");
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(ActiveUser.class);
		gr.setUserResultTransformer(true);

		try {
			GridPageResponse gpr = service.getGridPage(gr);
			String json = JSONHelper.Serialize(gpr);
			Write(json);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public StatisticsService getService() {
		return service;
	}

	public void setService(StatisticsService service) {
		this.service = service;
	}
}
