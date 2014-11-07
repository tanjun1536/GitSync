<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head> 
		<meta name="generator" content="HTML Tidy, see www.w3.org">
		<base href="<%=basePath%>">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="javascript/jquery-easyui-1.2.5/themes/default/easyui.css" />
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="javascript/jquery/js/jquery.json-2.3.min.js"></script>
		<script type="text/javascript" src="javascript/jquery-easyui-1.2.5/jquery.easyui.min.js"></script>
		<!--引入Grid样式		-->
		<link href="javascript/jquery.jqGrid-4.2.0/css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
		<script src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/i18n/grid.locale-zh_CN.js" type="text/javascript"></script>
		<script src="javascript/jquery.jqGrid-4.2.0/js/jquery.jqGrid.min.js" type="text/javascript"></script>
		<!--弹出窗口-->
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<script src="javascript/jqGrid.js" type="text/javascript"></script>
		<script src="javascript/array.js" type="text/javascript"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript">
	$(function() {
		//创建选项卡
		//$("#tabs").tabs({ fx: { opacity: 'toggle' } });
		
		var headers="编号,添加,分类,标题,时间";
		//创建列
		var columns = new Array();
		columns.push("{'n':'id','s':'int','w':10,'h':true}");
		columns.push("{'n':'add', 'w':35}");
		columns.push("{'n':'section.name', 'w':120,'a':'left'}");
		columns.push("{'n':'title','a':'left',w:200}");
		columns.push("{'n':'createDate'}");
		
		var buttons=new Array();
		buttons.push({"gc":"add","showName":"添加","action":"add","width":"16px","height":"16px"});
		//创建Grid
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTable","gridPager", "ArticlePadDistributeAction!getArticlePadPrepareDistribute.action?sectionId=${param.section==null?layout.section:param.section}", "json",headers, columns, 10,"平板文章列表",undefined,buttons);
		
//		$('#tabs').bind('tabsselect', function(event, ui) {
//		 //  ui.tab     // 被选中（点击后）的选项卡元素
//		  // ui.panel   //这个元素包含被选中（点击后）的选项卡的内容
//		  // ui.index   //返回一个被选中（或点击后）选项卡的索引值（从0开始）
//			  if(ui.index==1)
//			  {
//				
//			  }
//		});
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTableImage","#gridPagerImagePager", "ArticlePadDistributeAction!getPadImageContentPrepareDistribute.action?section=${param.section==null?layout.section:param.section}", "json",headers, columns, 10,"iPad图片文章列表",undefined,buttons);
		
		//创建已经选择的表格  上移,下移,
		var h="编号,删除,分类,标题,类别,序号";
		var cols= new Array();
		cols.push("{'n':'article','s':'int','w':10,'h':true}");
		cols.push("{'n':'del', 'w':40}");
	//	cols.push("{'n':'up', 'w':40}");
	//	cols.push("{'n':'down', 'w':40}");
		cols.push("{'n':'section','a':'left'}");
		cols.push("{'n':'title','a':'left'}");
		cols.push("{'n':'type','f':formatter}");
		cols.push("{'n':'orderNumber'}");
		var btns=new Array();
		btns.push({"gc":"del","showName":"删除","action":"del","width":"16px","height":"16px"});
	//	btns.push({"gc":"up","showName":"上移","action":"view","width":"16px","height":"16px"});
	//	btns.push({"gc":"down","showName":"下移","action":"edit","width":"16px","height":"16px"});
		window.jqGrid.createJqGridNoCheckBoxSeparateButton("#gridTableSelected","gridPagerSelectedPager", "PadPageLayoutAction!getLayoutArticle.action?id=${layout.id}", "json",h, cols, 10,"已选择文章", undefined,btns);
		
		// {name:'ship',label:'Ship Via',width:90, editable: true,formatter:'select', edittype:"select",editoptions: value:"2:FedEx;1:InTime;3:TNT;4:ARK;5:ARAMEX"}},         
		setTimeout(changeOrderNumberToSelect,1000);
		//changeOrderNumberToSelect();
	
	});
	function changeOrderNumberToSelect()
	{
		var tab = $("#gridTableSelected");
		var array = tab.getDataIDs();
		//模版定义的文章数目
		var defineCount=$("input[name='layout\\.template\\.id']:checked").attr("c");
		for ( var i = 0; i < array.length; i++) {
			var data=tab.getRowData(array[i]);
			tab.setCell(array[i],'orderNumber',createSelectOnLoad(defineCount,data.orderNumber));
			var deleteButton="<input width='16px' type='button' height='16px' onclick='del("+data.article+")' value='删除'>";
			tab.setCell(array[i],'del',deleteButton);
		}
	}
	function formatter(value)
	{
		return value==0?"图文":"纯图";
	}
	function selrow(id,table){
		return function(){$(table).setSelection(id, false);}
	}	
	//发布
	function view() {
		var tab = $("#gridTableSelected");
		var array = tab.getDataIDs();
		var datas=new Array();
		var orders=new Array();
		for ( var i = 0; i < array.length; i++) {
			var data=tab.getRowData(array[i]);
			var d=new Object();
			d.article=data.article;
			d.type=data.type=="图文"?"0":"1";
			d.orderNumber=$(data.orderNumber).val();  
			datas.push(d);
			orders.push(d.orderNumber);
		}
		if(checkOrder(orders))
		{
			alert("排版序号有重复，请修正");
			return false;
		}
		datas=ArrayUtil.sort(datas);
	    if(datas.length==0)
	    {
	    	alert("请选择文章后再预览");
	    	return;
	    }
	    var json=$.toJSON(datas);
		$.dialog({
		id:'preview',
		content:"url:<%=basePath%>jsp/article/ArticlePadListPreview.jsp?S="+json+"&templateId="+$("#layout\\.template\\.id").val(),
			max : false,
			min : false,
			width : 800,
			height : 500,
			drag : false,
			resize : false,
			cancelVal:"关闭",
			cancel:function(){}
			
		});
	}
	function checkOrder(array)
	{
		return ArrayUtil.isRepeat(array);
	}
	function check()
	{
		//模版定义的文章数目
		var defineCount=$("input[name='layout\\.template\\.id']:checked").attr("c");
		//列表中已经选择的数量
		var selectedCount=$("#gridTableSelected").getGridParam("reccount");
		//如果选择的数量超过或者等于定义的数量
		if(parseInt(selectedCount)<parseInt(defineCount))
		{
			if(!confirm("选择的文章数量小于模版定义的文章数量：【"+defineCount+"】!是否继续保存!"))
			return false;
		}
		//把选择的文章生成JSON数据
		var datas=new Array();
		var tab = $("#gridTableSelected");
		var array = tab.getDataIDs();
		var orders=new Array();
		for ( var i = 0; i < array.length; i++) {
			var data=tab.getRowData(array[i]);
			var d=new Object();
			d.article=data.article;
			d.type=data.type=="图文"?"0":"1";
			d.orderNumber=$(data.orderNumber).val(); 
			d.title=data.title;
			d.section=data.section;
			datas.push(d);
			orders.push(d.orderNumber);
		}
		if(checkOrder(orders))
		{
			alert("排版序号有重复，请修正");
			return false;
		}
		var json=$.toJSON(datas);
		$("#articles").val(json);
		return true;
	}
	function add(id)
	{
		//模版定义的文章数目
		var defineCount=$("input[name='layout\\.template\\.id']:checked").attr("c");
		if(defineCount==undefined)
		{
			alert("请选择模版!");
			return ;
		}
		
		//列表中已经选择的数量
		var selectedCount=$("#gridTableSelected").getGridParam("reccount");
		//如果选择的数量超过或者等于定义的数量
		if(parseInt(selectedCount)>=parseInt(defineCount))
		{
			alert("选择的模版只能够展示【"+defineCount+"】篇文章!");
			return ;
		}
		var deleteButton="<input width='16px' type='button' height='16px' onclick='del("+id+")' value='删除'>";
	//	var upButton="<input width='16px' type='button' height='16px' onclick='up("+id+")' value='上移'>";
	//	var downButton="<input width='16px' type='button' height='16px' onclick='down("+id+")' value='下移'>";
		var data=window.jqGrid.getSelectedRowData("#gridTable",id);
		data.del=deleteButton;
	//	data.up=upButton;
	//	data.down=downButton;
		data.article=id;
		data.type="0";
		data.section=data["section.name"];
		data.orderNumber=createSelect(defineCount,selectedCount);//$("#gridTableSelected").getGridParam("reccount")+1;
		window.jqGrid.addRow("#gridTableSelected",data);
		
		//alert(data["section.name"]);
	}
	function createSelectOnLoad(defineCount,orderNumber)
	{
		var id="order"+orderNumber;
		var select ="<select id='"+id+"' onchange='changeSelect(\""+id+"\","+defineCount+",this.options[this.selectedIndex].text)'>";
		for(var i=0;i<defineCount;i++)
		{
			if((i+1)==orderNumber)
				select+="<option selected='selected' value='"+orderNumber+"'>"+orderNumber+"</option>";
			else
				select+="<option value='"+(i+1)+"'>"+(i+1)+"</option>";
		}
		select+="</select>";
		return select;
	}
	function createSelect(defineCount,selectedCount)
	{
		var id="order"+selectedCount;
		var select ="<select id='"+id+"' onchange='changeSelect(\""+id+"\","+defineCount+",this.options[this.selectedIndex].text)'>";
		for(var i=0;i<defineCount;i++)
		{
			if(i==selectedCount)
				select+="<option selected='selected' value='"+(i+1)+"'>"+(i+1)+"</option>";
			else
				select+="<option value='"+(i+1)+"'>"+(i+1)+"</option>";
		}
		select+="</select>";
		return select;
	}
	function createSelectOnChange(id,defineCount,selectedCount)
	{
		var select ="<select id='"+id+"' onchange='changeSelect(\""+id+"\","+defineCount+",this.options[this.selectedIndex].text)'>";
		for(var i=0;i<defineCount;i++)
		{
			if(i==selectedCount)
				select+="<option selected='selected' value='"+(i+1)+"'>"+(i+1)+"</option>";
			else
				select+="<option value='"+(i+1)+"'>"+(i+1)+"</option>";
		}
		select+="</select>";
		return select;
	}
	function changeSelect(select,defineCount,selectValue)
	{
		$('#'+select).parent().empty().append(createSelectOnChange(select,defineCount,parseInt(selectValue)-1));
	}
	function del(id)
	{
//		alert(id);
		var tab = $("#gridTableSelected");
		var array = tab.getDataIDs();
		for ( var i = 0; i < array.length; i++) {
			if(tab.getRowData(array[i]).article==id)
				tab.delRowData(array[i]);
		}
	}
	function up(id)
	{
		var tab = $("#gridTableSelected");
		var array = tab.getDataIDs();
		for ( var i = 0; i < array.length; i++) {
			var data=tab.getRowData(array[i]);
			var preData=tab.getRowData(array[i-1]);
			if(data.article==id)
			{
				if(i>0)
				{
					data.article=preData.article;
					preData.id=id;
					//修改点击行的数据
					tab.setCell(array[i],"article",data.article);
					tab.setCell(array[i],"section.name",preData["section.name"]);
					tab.setCell(array[i],"title",preData.title);
					tab.setCell(array[i],"type",preData.type);
					
					//进行数据交换 修改上一行的数据
					tab.setCell(array[i-1],"article",id);
					tab.setCell(array[i-1],"section.name",data["section.name"]);
					tab.setCell(array[i-1],"title",data.title);
					tab.setCell(array[i-1],"type",data.type);
					//tab.setCell(array[i-1],"orderNumber",rrrrrrdata.orderNumber);
					//tab.setCell(array[i],"orderNumber",preData.orderNumber);
					
				}
				break;
			}
			
		}
	}
	function down(id)
	{
		var tab = $("#gridTableSelected");
		var array = tab.getDataIDs();
		for ( var i = 0; i < array.length; i++) {
			var data=tab.getRowData(array[i]);
			var nextData=tab.getRowData(array[i+1]);
			if(data.article==id)
			{
				if(i<$("#gridTableSelected").getGridParam("reccount")-1)
				{
					data.articled=nextData.id;
					nextData.id=id;
					//修改点击行的数据
					tab.setCell(array[i],"article",nextData.article);
					tab.setCell(array[i],"section.name",nextData["section.name"]);
					tab.setCell(array[i],"title",nextData.title);
					tab.setCell(array[i],"type",nextData.type);
					data.article=nextData.article;
					nextData.article=id;
					//tab.setCell(array[i],"orderNumber",preData.orderNumber);
					//进行数据交换 修改下一行的数据
					tab.setCell(array[i+1],"article",id);
					tab.setCell(array[i+1],"section.name",data["section.name"]);
					tab.setCell(array[i+1],"title",data.title);
					tab.setCell(array[i+1],"type",data.type);
					//tab.setCell(array[i+1],"orderNumber",data.orderNumber);
					
					
				}
				break;
			}
			
		}
	}
	
</script>
	</head>
	<body>
	<header>
		<div class="header_a">
		</div>
		<div class="header_b">
		</div>
		<div class="header_c">
			当前位置：采编管理 > 平板文章列表版面管理
		</div>
		<div class="clear"></div>
		</header>
		<form name="form1" enctype="multipart/form-data" onsubmit="return check();" action="PadPageLayoutAction!save.action" method="post">

			<input type="hidden" name="layout.id" id="layout.id" value="${layout.id }" />
			<input type="hidden" name="articles" id="articles" />
			<input type="hidden" name="layout.section" id="layout.section" value="${param.section==null?layout.section:param.section}" />
			<input type="hidden" name="layout.state" id="layout.state" value="${layout.state==null?0:layout.state }" />
			<div class="formdiv">

				<ol>
					<li>
						<label class="label">
							选择模板:
						</label>
						<div class="domexz">
							<dl>
							<c:forEach var="item" items="${templates }">
								<c:choose>
									<c:when test="${item.id==layout.template.id }">
										<dt>
											<img src="${item.image}" width="81" height="100">
											<p style="width:100px">
												<input name="layout.template.id" type="radio" checked="checked" c="${item.articleCount }"  value="${item.id }">
													${item.name }
											</p>
										</dt>
									</c:when>
									<c:otherwise>
										<dt>
											<img src="${item.image}" width="81" height="100">
											<p style="width:100px">
												<input name="layout.template.id" type="radio" c="${item.articleCount }"  value="${item.id }">
													${item.name }
											</p>
										</dt>
									</c:otherwise>
								</c:choose>

							</c:forEach>
							</dl>
						</div>
					</li>
					<li>
						<label class="label">
							名称:
						</label>
						<input type="text" name="layout.title" style="width: 200px" value="${layout.title }" required="true">
					</li>
				</ol>

				<div>
					<table id="gridTable">
					</table>
					<div id="gridPager"></div>
				</div>
				<div>
					<table id="gridTableSelected">
					</table>
					<div id="gridPagerSelectedPager"></div>
				</div>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" id="btnSave" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" " id="btnSave" value="预览" onclick="view()" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" id="btnBack" onclick="fn.openURL('<%=basePath%>jsp/layout/PadPageLayoutList.jsp')" value="返回" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />

				</div>
			</div>


		</form>
	</body>
</html>


					
					
					
