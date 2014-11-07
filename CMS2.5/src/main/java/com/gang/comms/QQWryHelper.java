package com.gang.comms;

import java.io.IOException;

import com.gang.service.qqwry.IPZone;
import com.gang.service.qqwry.QQWry;

public class QQWryHelper {
	private static QQWry qqwry;
	static {
		try {
			qqwry = new QQWry(QQWry.class.getClassLoader()
					.getResource("qqwry.dat").getFile());
		} catch (IOException e) {
			e.printStackTrace();
		}

	}

	public static String getLocation(String ip) {
		IPZone zone = qqwry.findIP(ip);
		if (zone != null)
			return zone.getCountry();
		return "";
	}
}
