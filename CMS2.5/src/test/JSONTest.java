import java.util.ArrayList;
import java.util.List;

import org.junit.AfterClass;
import org.junit.BeforeClass;
import org.junit.Test;
import org.springframework.test.AbstractTransactionalDataSourceSpringContextTests;

import com.gang.comms.JSONHelper;
import com.gang.entity.section.Section;
import com.gang.service.section.SectionService;

public class JSONTest extends AbstractTransactionalDataSourceSpringContextTests {
	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@AfterClass
	public static void tearDownAfterClass() throws Exception {
	}

	@Override
	protected String[] getConfigLocations() {
		String[] config = new String[] { "classpath:applicationContext.xml" };
		return null;
	}

	@Test
	public void testJson() {
		Section s = new Section();
		s.setId(1);
		List<Section> l = new ArrayList<Section>();
		l.add(s);
		s = new Section();
		s.setId(2);
		l.add(s);
		System.out.println(JSONHelper.SerializeWithNeedAnnotation(l));

	}

	public void testGetSection() {
		SectionService service = (SectionService) applicationContext.getBean("SectionServie");
		Integer[] roleIds = { 1, 2, 3, 4, 5, 6 };
		service.getSectionByRoleIds(roleIds);
	}
}
