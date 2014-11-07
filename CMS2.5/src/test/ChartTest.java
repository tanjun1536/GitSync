import java.util.ArrayList;
import java.util.List;

import com.gang.comms.JSONHelper;
import com.gang.entity.statistics.Chart;
import com.gang.entity.statistics.ChartColorSet;
import com.gang.entity.statistics.ChartData;
import com.gang.entity.statistics.ChartDataSet;
import com.gang.entity.statistics.ChartOptionSet;
import com.gang.entity.statistics.JSChart;


public class ChartTest {
	public static void main(String[] args) {
		System.out.println(TestChartDataFormat());
	}
	public static String  TestChartDataFormat()
	{
		Chart c=new Chart();
		JSChart jSChart=new JSChart();
		ChartDataSet cds=new ChartDataSet();
		cds.setType("pie");
		cds.setId("blue");
		ChartData cd=new ChartData();
		cd.setUnit("FUCK");
//		cd.setValue("123");
		
		List<ChartData> l=new ArrayList<ChartData>();
		l.add(cd);
		cds.setData(l);
		List<ChartDataSet> ll=new ArrayList<ChartDataSet>();
		ll.add(cds);
		jSChart.getColorset().add("#001122");
		jSChart.getColorset().add("#112233");
		jSChart.getColorset().add("#223344");
		
		ChartOptionSet cos=new ChartOptionSet();
		cos.setSet("setSize");
		cos.setValue("600, 300");
		List<ChartOptionSet> lcos=new ArrayList<ChartOptionSet>();
		lcos.add(cos);
		jSChart.setDatasets(ll);
		jSChart.setOptionset(lcos);
		c.setjSChart(jSChart);
		
		return JSONHelper.Serialize(c);
	}
}
