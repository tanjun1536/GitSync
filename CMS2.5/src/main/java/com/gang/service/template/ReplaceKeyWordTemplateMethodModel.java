package com.gang.service.template;

import java.util.List;

import org.apache.oro.text.regex.MalformedPatternException;
import org.apache.oro.text.regex.MatchResult;
import org.apache.oro.text.regex.Pattern;
import org.apache.oro.text.regex.PatternMatcherInput;
import org.apache.oro.text.regex.Perl5Compiler;
import org.apache.oro.text.regex.Perl5Matcher;

import com.gang.comms.StringHelper;

import freemarker.template.TemplateMethodModel;
import freemarker.template.TemplateModelException;
public class ReplaceKeyWordTemplateMethodModel implements TemplateMethodModel {

	@Override
	public Object exec(List list) throws TemplateModelException {
		// TODO Auto-generated method stub
		String html=list.get(0).toString();
		String regex = "<img [^>]* />";
		String srcRegex = "src\\s*=\\s*\"([^\"]*)\"";
		Perl5Compiler compiler = new Perl5Compiler();
		Pattern pattern=null;
		Pattern srcPattern=null;
		try {
			pattern = compiler.compile(regex, Perl5Compiler.CASE_INSENSITIVE_MASK);
			srcPattern = compiler.compile(srcRegex, Perl5Compiler.CASE_INSENSITIVE_MASK);
		} catch (MalformedPatternException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		Perl5Matcher matcher = new Perl5Matcher();
		PatternMatcherInput matcherInput = new PatternMatcherInput(html);
		while (matcher.contains(matcherInput, pattern)) {
			MatchResult result = matcher.getMatch();
			PatternMatcherInput input = new PatternMatcherInput(result.toString());
			if (matcher.contains(input, srcPattern)) {
				MatchResult src = matcher.getMatch();
				String img = src.group(1);
				if (StringHelper.isNotBlank(img)) {
					// 同时替换路径
					String fileName = img.substring(img.lastIndexOf("/")); // 带
					html = html.replace(img, "images" + fileName);
				}
			}
		}
		return html;
		//return src.replace("\r\n", "<br/>").replaceAll("uploads/images/section", "images");
	}

}
