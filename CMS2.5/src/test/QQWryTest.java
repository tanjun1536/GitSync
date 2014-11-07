import java.io.IOException;

import com.gang.service.qqwry.IPZone;
import com.gang.service.qqwry.QQWry;


public class QQWryTest {
	public static void main(String[] args) throws IOException {
		QQWry qqwry = new QQWry(QQWry.class.getClassLoader().getResource("qqwry.dat").getFile());
		IPZone zone=qqwry.findIP("118.122.87.53");
		System.out.println(zone);
		
//		for (int a = 0; a <= 255; a++) {
//			for (int b = 0; b <= 255; b++) {
//				for (int c = 0; c <= 255; c++) {
//					for (int d = 0; d <= 255; d++) {
//						final String ipstr = String.format("%d.%d.%d.%d", a, b,
//								c, d);
//						final IPZone zone = qqwry.findIP(ipstr);
//						if (zone.getCountry() != null) {
//							System.out.println(zone);
//						}
//						Thread.yield();
//					}
//				}
//			}
//		}
	}
}
