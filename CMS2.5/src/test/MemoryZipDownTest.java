import java.io.ByteArrayInputStream;
import java.io.IOException;
import java.io.InputStream;

import com.gang.comms.ZipHelper;


public class MemoryZipDownTest {
	public static void main(String[] args) throws IOException {
		byte buf[]=ZipHelper.doZipFolder("C:\\Users\\tanjun1536\\Desktop\\Hohsin");
		InputStream is=new ByteArrayInputStream(buf, 0, buf.length);
		System.out.println(is);
	}
}
