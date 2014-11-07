package com.gang.comms;

import java.util.Collection;

import com.google.gson.annotations.Expose;

public class GridPageResponse {

	@Expose
	private int page;
	@Expose
	private int total;
	@Expose
	private int records;
	@Expose
	private Collection rows;
	public int getPage() {
		return page;
	}
	public int getRecords() {
		return records;
	}

	public Collection getRows() {
		return rows;
	}

	public int getTotal() {
		return total;
	}

	public void setPage(int page) {
		this.page = page;
	}

	public void setRecords(int records) {
		this.records = records;
	}

	public void setRows(Collection rows) {
		this.rows = rows;
	}
	public void setTotal(int total) {
		this.total = total;
	}

}
