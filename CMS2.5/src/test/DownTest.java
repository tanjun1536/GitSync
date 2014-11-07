import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;

public class DownTest {
	public static void main(String[] args) throws Exception {
		StringBuffer sb=new StringBuffer("FUCK");
		System.out.println(sb.deleteCharAt(sb.length()-1));
		downloadNet("http://localhost:8080/CMS/services/padservices/getDoc?docId=3877","D:\\res.zip");
	}
	public static void downloadNet(String remoteFile,String localFile) throws MalformedURLException {
		// 下载网络文件
		int bytesum = 0;
		int byteread = 0;

		URL url = new URL(remoteFile);
		try {
			URLConnection conn = url.openConnection();
			InputStream inStream = conn.getInputStream();
			FileOutputStream fs = new FileOutputStream(localFile);

			byte[] buffer = new byte[1204];
			int length;
			while ((byteread = inStream.read(buffer)) != -1) {
				bytesum += byteread;
				System.out.println(bytesum);
				fs.write(buffer, 0, byteread);
			}
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}

}
