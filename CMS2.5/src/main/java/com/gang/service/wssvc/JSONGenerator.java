package com.gang.service.wssvc;

import java.util.ArrayList;
import java.util.List;

public class JSONGenerator {
	private List<Generator> properties = new ArrayList<Generator>();

	public JSONGenerator addGenerator(Generator generator) {
		this.properties.add(generator);
		return this;
	}

	public String toString() {
		StringBuffer sb = new StringBuffer("{");
		int len = properties.size();
		for (int i = 0; i < len; i++) {
			Generator generator = properties.get(i);
			sb.append(generator);
			if (i < len - 1)
				sb.append(",");
		}
		sb.append("}");
		return sb.toString();
	}
}
