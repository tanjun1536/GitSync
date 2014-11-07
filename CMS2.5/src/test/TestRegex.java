import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.List;

import org.apache.oro.text.regex.MalformedPatternException;
import org.apache.oro.text.regex.MatchResult;
import org.apache.oro.text.regex.Pattern;
import org.apache.oro.text.regex.PatternMatcherInput;
import org.apache.oro.text.regex.Perl5Compiler;
import org.apache.oro.text.regex.Perl5Matcher;
import org.apache.struts2.views.util.UrlHelper;

import com.gang.comms.Base64;
import com.gang.comms.StringHelper;

public class TestRegex {
	public static void main(String[] args) throws Exception {

		//Code();
		String s="<img src=\"/userfiles/files/images/meiju/DSC_0132(1).jpg\" alt=\"\" border=\"0\" />";
		String v=s.replace("/userfiles/files/images/meiju/DSC_0132(1).jpg", "/DSC_0132(1).jpg");
		System.out.println(v);
	}

	public static List<String> getHTMLFile(String html) throws MalformedPatternException {
		List<String> paths=new ArrayList<String>();
		String regex = "<img [^>]* />";
		String srcRegex = "src\\s*=\\s*\"([^\"]*)\"";
		Perl5Compiler compiler = new Perl5Compiler();
		Pattern pattern = compiler.compile(regex, Perl5Compiler.CASE_INSENSITIVE_MASK);
		Pattern srcPattern = compiler.compile(srcRegex, Perl5Compiler.CASE_INSENSITIVE_MASK);
		Perl5Matcher matcher = new Perl5Matcher();
		PatternMatcherInput matcherInput = new PatternMatcherInput(html);
		while (matcher.contains(matcherInput, pattern)) {
			MatchResult result = matcher.getMatch();
			System.out.println(result.toString());
			PatternMatcherInput input = new PatternMatcherInput(result.toString());
			if (matcher.contains(input, srcPattern)) {
				MatchResult src = matcher.getMatch();
				if(StringHelper.isNotBlank(src.group(1)))
					paths.add(src.group(1));
			}
		}

		return paths;
	}
	public static void FK()
	{
		String s="9Y/u000A/u000DaX";
		String z=Base64.encode(s.getBytes());
		System.out.println(s);
		System.out.println(z.replaceAll("\r", "").replaceAll("\r\n", "").replaceAll("\n", "").length());
	}
	public static void Code() throws Exception
	{
		String s="/CMS/userfiles/files/images/%E4%B8%AD%E6%96%87%E8%B7%AF%E5%BE%84/btn_login.jpg";
		String z=URLDecoder.decode(s);
		System.out.println(z);
	}
}
