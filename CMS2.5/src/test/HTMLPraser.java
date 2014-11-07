import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import com.gang.comms.JSONHelper;
import com.gang.entity.wssvc.HtmlElement;


public class HTMLPraser {
	public static void main(String[] args) throws IOException {
	  String json=	com.gang.service.wssvc.HTMLPraser.parseJson("<p>第一行接回车</p><p>第二行回车2个</p><p><br /></p><p>第三行回车3个</p><p><br /></p><p><br /></p><p>第四行结束<br /> </p>");
	  System.out.println(json);
	}
	
}
