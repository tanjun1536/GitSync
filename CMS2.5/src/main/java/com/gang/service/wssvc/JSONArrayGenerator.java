package com.gang.service.wssvc;

import java.util.ArrayList;
import java.util.List;

public class JSONArrayGenerator {
	private List<JSONGenerator> jsonGenerators = new ArrayList<JSONGenerator>();

	public JSONArrayGenerator addGenerator(JSONGenerator generator) {
		this.jsonGenerators.add(generator);
		return this;
	}

	public String toString() {
		StringBuffer sb = new StringBuffer("[");
		int len = jsonGenerators.size();
		for (int i = 0; i < len; i++) {
			JSONGenerator generator = jsonGenerators.get(i);
			sb.append(generator);
			if (i < len - 1)
				sb.append(",");
		}
		sb.append("]");
		return sb.toString();
	}
}
