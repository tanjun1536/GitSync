import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStreamWriter;
import java.io.Writer;
import java.util.HashMap;
import java.util.Map;

import javax.script.Bindings;
import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;
import javax.script.ScriptException;

import org.junit.Test;

import freemarker.ext.script.FreeMarkerScriptConstants;
import freemarker.template.Configuration;
import freemarker.template.DefaultObjectWrapper;
import freemarker.template.Template;

public class FreeMarkerTest {
	@Test
	public void testTemplate() throws Exception {
		InputStream is = new FileInputStream("D:\\SystemDevelop\\htfdc\\testFM\\src\\table");
		byte[] b = new byte[is.available()];
		is.read(b, 0, is.available());
		String s = new String(b);
		System.out.println(s);
		Configuration cfg = new Configuration();
		cfg.setDirectoryForTemplateLoading(new File("D:\\SystemDevelop\\htfdc\\testFM\\template"));
		cfg.setObjectWrapper(new DefaultObjectWrapper());
		cfg.setOutputEncoding("UTF-8");
		cfg.setDefaultEncoding("UTF-8");
		Map<String, String> root = new HashMap<String, String>();
		root.put("table", s);
		Template temp = cfg.getTemplate("table.xml");
		temp.setEncoding("UTF-8");
		Writer out = new BufferedWriter(new OutputStreamWriter(new FileOutputStream(new File("D:\\SystemDevelop\\htfdc\\testFM\\template\\testTable.xml")), "UTF-8"));
		temp.process(root, out);
		
		out.flush();
	}
	@Test
	public void testEngine()
	{
		//生成引擎
		ScriptEngineManager manager = new ScriptEngineManager();
		ScriptEngine engine = manager.getEngineByName("FreeMarker");
		        
		//获取模板
		String template=" the 学生 is ${name} ,and 他今年${age}岁,身高:${height}cm!\n"+
		        "他的朋友包括:\n"+
		        "<#list friends as friend>朋友 ${friend}\n</#list>";
		           
		try {
		        //注入参数
		        Bindings params= engine.createBindings();
		        params.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);
		        params.put("name", "tom");
		        params.put("age", 11);
		        params.put("height", 175.2);
		        params.put("friends", new String[]{"jack","linda","better"});

		        //执行模板渲染
		        Object result =engine.eval(template,params);
		        
		        //输出结果
		        System.out.println(result);
		} catch (ScriptException e) {
		    e.printStackTrace();
		}
	}
}
