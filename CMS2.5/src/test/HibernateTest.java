import java.lang.reflect.InvocationTargetException;
import java.sql.SQLException;
import java.util.ArrayList;

import javax.annotation.Resource;

import org.apache.poi.hssf.record.formula.functions.Pearson;
import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.orm.hibernate3.HibernateCallback;
import org.springframework.test.AbstractTransactionalDataSourceSpringContextTests;
import org.springframework.test.context.ContextConfiguration;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;
import org.springframework.web.context.ContextLoader;
import org.springframework.web.context.WebApplicationContext;

import com.gang.comms.HibernateUpdateCollectionKiller;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.article.ArticleMobileGoods;
import com.gang.entity.article.ArticleMobileGoodsImage;
import com.gang.entity.article.ArticleMobileGoodsImageGroup;
import com.gang.entity.article.ArticleMobileShop;
import com.gang.entity.test.Student;
import com.gang.entity.test.Teacher;
import com.gang.service.article.ArticleService;

@RunWith(SpringJUnit4ClassRunner.class)
@ContextConfiguration(locations = "classpath:applicationContext-test.xml")
public class HibernateTest extends AbstractTransactionalDataSourceSpringContextTests {
	@Resource
	private ArticleService service;

	public void setService(ArticleService service) {
		this.service = service;
	}
	@Test
	public void testGetDocList() {
		WebApplicationContext ctx = ContextLoader.getCurrentWebApplicationContext();
		ctx.getBean("baseService");
	}
	@Test
	public void testHibernateSave() {
		
		Student s=new Student();
		s.setName("学生");
		s.setS1("SS1");
		s.setS2(11);
		service.save(s);
		Teacher t=new Teacher();
		t.setName("教师");
		t.setT1("TT1");
		t.setT2(22);
		service.save(t);
		System.out.println(service);
		s=service.get(Student.class, 11);
		System.out.println(s.getId());
		System.out.println(service.get(Pearson.class, 11));

	}
	@Test
	public void testLoadArticleMobile()
	{
		ArticleMobile shop=service.get(ArticleMobile.class, 6905);
		System.out.println(shop);
	}
	@Test
	public void testMerge() throws SecurityException, IllegalArgumentException, NoSuchMethodException, IllegalAccessException, InvocationTargetException
	{
		ArticleMobileGoods good=new ArticleMobileGoods();
		good.setId(4524);
		ArticleMobileGoodsImageGroup amgig=new ArticleMobileGoodsImageGroup();
		ArticleMobileGoodsImage amgi=new ArticleMobileGoodsImage();
		amgi.setDes("xinjia");
		amgi.setUrl("xinjia");
		amgig.setImages(new ArrayList<ArticleMobileGoodsImage>());
		amgig.getImages().add(amgi);
		good.setImagesGroups(new ArrayList<ArticleMobileGoodsImageGroup>());
		good.getImagesGroups().add(amgig);
		service.update(good,new HibernateUpdateCollectionKiller("getImagesGroups","getVideosGroups"));
	}
	@Test
	public void testLoad()
	{
		final String sql="SELECT a FROM ArticleMobile a where a.id=4524";
		Object obj=service.execute(new HibernateCallback() {
			
			@Override
			public Object doInHibernate(Session s) throws HibernateException, SQLException {
				// TODO Auto-generated method stub
				return s.createQuery(sql).uniqueResult();
			}
		});
		System.out.println(obj.getClass());
	}
}
