package com.gang.service.wssvc;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import com.gang.comms.CollectionHelper;
import com.gang.comms.JSONHelper;
import com.gang.entity.wssvc.HtmlElement;


public class HTMLPraser {
	public static void main(String[] args) throws IOException {
		Document doc = Jsoup.parseBodyFragment("<p><img border=\"0\" src=\"uploads/images/section/d76bc4d9-a0a2-4a13-8994-b1ddef5b1bec.jpg\" alt=\"\" /><br /></p>" +
				"<p>　　“搞啥子的!”昨(17)日零时40分，在市南门坝生态公园巡逻的保安明强、王志勇看到，生态公园防洪堤上有3个身影在夜幕的掩护下，推着一辆三轮车向前走去。出于职业的本能，明强大吼了一声，没想到，那3个人丢下三轮车飞快地消失在夜色中。明强走近一看，三轮车上原来装着两台空调的主机。</p>" +
				"<p>　　“当时，我和同事王志勇在生态公园巡逻，看到那3个人影我心里就怀疑，这么晚了还有谁在搬东西?”昨日上午，记者在南门坝生态公园桓子河大桥保安岗亭见到了吓跑窃贼的保安明强，他告诉记者，“我感到事情有点不对，便用强光手电筒照了照，没想到，那3个人见后面有人，推着三轮车就跑。于是，我和王志勇快速追了上去。在桓子河大桥附近，眼看就要追上了，那3个人放弃三轮车，跳下防洪堤就不见了。”随后，他俩揭开盖在三轮车上的广告布一看，原来车上装着两台空调主机。</p>" +
				"<p>　　明强立即向公司汇报并报警。</p>"); 
//		String title = doc.title();
		Element el = doc.body();
		System.out.println(el.tagName());
		List<HtmlElement> list=new ArrayList<HtmlElement>();
		getList(el.children(),list);
		System.out.println(JSONHelper.Serialize(list));
		//System.out.println(body);
	}
	public static String parseJson(String html)
	{
		return JSONHelper.Serialize(parseList(html));
	}
	public static List<HtmlElement> parseList(String html)
	{
		Document doc = Jsoup.parseBodyFragment(html); 
		Element el = doc.body();
		System.out.println(el.tagName());
		List<HtmlElement> list=new ArrayList<HtmlElement>();
		getList(el.children(),list);
		return list;
	}
	private static void getList(Elements es,List<HtmlElement> list)
	{
		for(Element e:es)
		{
			if("p".equals(e.tagName()))
			{
				if(e.text().length()>0)
				{
					list.add(new HtmlElement("text",e.text()));
					list.add(new HtmlElement("newline","") );
				}
				
			}
			else if("img".equals(e.tagName()))
			{
				list.add(new HtmlElement("image",e.attr("src")));
			}
			else if("br".equals(e.tagName()))
			{
				list.add(new HtmlElement("newline",""));
			}
			Elements cs=e.children();
			if(CollectionHelper.isNotEmpty(cs)) getList(cs,list);
			
		}
	}
}
