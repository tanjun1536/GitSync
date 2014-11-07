import org.junit.Test;

import com.gang.service.wssvc.Generator;
import com.gang.service.wssvc.JSONGenerator;

public class JSONGeneratorTest {
	@Test
	public void testGenetator() {
		JSONGenerator mainGenerator = new JSONGenerator();
		JSONGenerator dataGenerator = new JSONGenerator();
		mainGenerator.addGenerator(new Generator("retcode", "1"));
		mainGenerator.addGenerator(new Generator("msg", "用户名已存在"));
		dataGenerator.addGenerator(new Generator("id", "FF"));
		dataGenerator.addGenerator(new Generator("nick", "EEE"));
		dataGenerator.addGenerator(new Generator("image_head", "DDD"));
		dataGenerator.addGenerator(new Generator("sex ", "CCC"));
		dataGenerator.addGenerator(new Generator("signature", "111"));
		mainGenerator.addGenerator(new Generator("data", dataGenerator));
		System.out.println(mainGenerator);
	}
}
