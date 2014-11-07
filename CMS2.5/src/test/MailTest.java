import org.apache.commons.mail.EmailException;
import org.apache.commons.mail.SimpleEmail;
import org.junit.Test;


public class MailTest {
	@Test
	public void testSendEmail() throws EmailException
	{
		SimpleEmail email = new SimpleEmail();
		email.setHostName("smtp.gmail.com");
		email.addTo("254527732@qq.com", "测试COMMON EMAIL");
		email.setSSL(true);
		email.setSmtpPort(465);
		email.setAuthentication("tanjun1536", "147369");
		email.setFrom("tanjun1536@gmail.com", "灵辰科技无限公司");
		email.setSubject("Test message");
		email.setMsg("This is a simple test of commons-email");
		email.send();
	}
}
