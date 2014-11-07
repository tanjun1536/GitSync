import org.hibernate.cfg.Configuration;
import org.hibernate.tool.hbm2ddl.SchemaUpdate;

public class SU {
	public static void main(String[] args) {

		Configuration config =new Configuration().configure("hibernate.cfg.xml");
		SchemaUpdate update = new SchemaUpdate(config);
		update.execute(true, true);
	}
}
