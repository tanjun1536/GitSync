import java.net.URL;
import java.net.URLEncoder;
import java.security.SignatureException;
import javax.crypto.Mac;
import javax.crypto.spec.SecretKeySpec;

import org.junit.Test;

import com.gang.comms.Base64;

public class ClassTest {
	private static final String HMAC_SHA1_ALGORITHM = "HmacSHA1";

	@Test
	public void testClassName() throws Exception {
		// System.out.println(Content.class.getName());
		String s = hash_hmac(
				"http://open.weather.com.cn/data/?areaid=101010100&type=observe&date=201406231819&appid=43789d97ddcb036d",
				"59f3f1_SmartWeatherAPI_2caea35");
		 s=URLEncoder.encode(s);
		System.out.println(s);
	}

	public String hash_hmac(String data, String key)
			throws Exception {
		String result;
		// get an hmac_sha1 key from the raw key bytes
		SecretKeySpec signingKey = new SecretKeySpec(key.getBytes(),
				HMAC_SHA1_ALGORITHM);

		// get an hmac_sha1 Mac instance and initialize with the signing key
		Mac mac = Mac.getInstance(HMAC_SHA1_ALGORITHM);
		mac.init(signingKey);

		// compute the hmac on input data bytes
		byte[] rawHmac = mac.doFinal(data.getBytes());

		// base64-encode the hmac
		result = Base64.encode(rawHmac);
		return result;
	}
}
