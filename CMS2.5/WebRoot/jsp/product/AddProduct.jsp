<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="generator" content="HTML Tidy, see www.w3.org">
		<base href="<%=basePath%>">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
			<!--引入jquery	-->
		<script type="text/javascript" src="javascript/jquery/js/jquery-1.7.min.js"></script>
		<link rel="stylesheet" type="text/css" media="screen" href="javascript/jquery/css/jquery-ui-1.8.18.custom.css" />
		<script type="text/javascript" src="javascript/jquery/js/jquery-ui-1.8.18.custom.min.js"></script>
		<script src="javascript/base.js" type="text/javascript"></script>
		<script type="text/javascript" src="javascript/ckfinder/ckfinder.js"></script>
		<script type="text/javascript" src="javascript/lhgdialog/lhgdialog.min.js?skin=blue"></script>
		<script src="javascript/finder.js" type="text/javascript"></script>
		<script src="javascript/jcarousellite_1.0.1.js" type="text/javascript"></script>
		<script src="javascript/jquery.easing.1.2.js" type="text/javascript"></script>
		<script src="javascript/jquery.mousewheel.min.js" type="text/javascript"></script>
		 <style>
		 ul
		 {
		 	height: 120px;
		 }
         ul li {
             margin: 5px;
             border:solid 1px #ccc;
             
         }
        .anyClass {
            border: solid 1px #ccc;
        }
    </style>
		<script type="text/javascript">
			$(function() {
				nav();
				//for update
				$("#product\\.type\\.id").val("${product.type.id}");
				$("#product\\.tradeType").val("${product.tradeType}");
				$("#product\\.userLimit").val("${product.userLimit}");
			});
			function nav()
			{
			 $(".anyClass").jCarouselLite({
			                circular: false,
			                visible: 5,
			                btnPrev: ".prev",
			        		btnNext: ".next",
			                mouseWheel: true});
			}
			var appendFn=function(url,desc)
			{
				$(".anyClass ul").append('<li style="position: relative;"><div style="z-index: 11; display: block; position: absolute;right: 5px; top:5px;"><img onclick="delImage(this);" title="删除图片" src="images/close.png" style="cursor:pointer;" /> </div> <div style="z-index: 10;"> <img width="120" height="80" src="'+url+'" alt="picture" ondblclick="editImage(this)" /><br/> <span>'+desc+'</span> </div> </li>');
				nav();
			}
			function addImage() {
				$.dialog.data('imageObj', null);
				$.dialog.data('fn', appendFn);
				
				var url = 'url:jsp/selector/MovingBoxImageSelctor.jsp';
				$.dialog({
					title : '图片选择',
					width : '450px',
					height : '400px',
					content : url,
					max : false,
					min : false
				});
			}
			function editImage(imageObj)
			{
				$.dialog.data('imageObj', imageObj);
				$.dialog.data('fn', appendFn);
				var url = 'url:jsp/selector/MovingBoxImageSelctor.jsp';
				$.dialog({
					title : '图片选择',
					width : '450px',
					height : '400px',
					content : url,
					max : false,
					min : false
				});
			}
			function delImage(imageObj)
			{
				$(imageObj).parent().parent().remove();
				nav();
			}
			function adjustImageFile() {
				$(".anyClass ul li").each(function(j) {
						var url = $(this).find("img:last").attr("src");
						var desc = $(this).find("span").html();
						$('<input type="hidden" name="product.images[' + j + '].url" value="' + url + '"/>').appendTo(this);
						$('<input type="hidden" name="product.images[' + j + '].description" value="' + desc + '"/>').appendTo(this);
				});
				return true;
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
			当前位置：商品管理 > 添加/编辑商品
		</div>
		<div class="clear"></div>
		</header>
			<c:choose>
				<c:when test="${product==null }"><form  action="ProductAction!save.action" method="post" onsubmit="return adjustImageFile();"></c:when>
				<c:otherwise><form  action="ProductAction!update.action" method="post" onsubmit="return adjustImageFile();"></c:otherwise>
			</c:choose>
			<input type="hidden" value="${product.id }" name="product.id">
			<div class="formdiv">
				<ol>
					
					<li>
						<label  class="label">
							名称:
						</label>
						<input id="product.name" name="product.name" type="text"  value="${product.name }" style="width: 200px;">
					</li>
					<li>
						<label class="label">
							类型：
						</label>
						<select id="product.type.id" name="product.type.id" style="width: 208px;">
							<c:forEach var="item" items="${types }">
								<option value="${item.id }" >${item.name }</option>
							</c:forEach>
						</select>
					</li>
					<li>
						<label for="product.price" class="label">
							价格：
						</label>
						<input id="product.price" name="product.price" type="text" value="${product.price}" >
					</li>
					<li>
						<label class="label">
							数量：
						</label>
						<input id="product.stock" name="product.stock" value="${product.stock }" type="text"  required>
					</li>
					<li>
						<label  class="label">
							交易状态：
						</label>
						<select id="product.tradable" name="product.tradable">
							<option value="true" >是</option>
							<option value="false" >否</option>
						</select>
					</li>
					<li>
						<label for="product.type" class="label">
							交易类型：
						</label>
						<select id="product.tradeType" name="product.tradeType">
							<option value="1" >支付-->结束</option>
							<option value="2" >支付-->发放-->结束</option>
						</select>
					</li>
					<li>
						<label for="product.type" class="label">
							兑换限制：
						</label>
						<select id="product.userLimit" name="product.userLimit">
							<option value="0" >无限制</option>
							<option value="1" >1</option>
							<option value="2" >2</option>
							<option value="3" >3</option>
							<option value="4" >4</option>
							<option value="5" >5</option>
							<option value="6" >6</option>
							<option value="7" >7</option>
							<option value="8" >8</option>
							<option value="9" >9</option>
							<option value="10" >10</option>
						</select>
					</li>
					<li>
						<label  class="label">
							商品介绍：
						</label>
						<textarea id="product.description" name="product.description" rows="3" style="width: 570px">${product.description}</textarea>
						<label  id="charCount">
							当前字数：0 个
						</label>
					</li>
					<li>
						<label class="label">
							图片：<br/><font color="blue">(60px*60px) </font>
						</label>
						<c:choose>
							<c:when test="${product==null||product.image=='' }">
								<img src="images/img60_60.png" id="titleImagePreview" width="60" height="60" alt="标题图片" overflow: hidden; background-color: #FFFFFF; padding: 2px; border: 1px solid #CCC" />
							</c:when>
							<c:otherwise>
								<img src="${product.image}" id="titleImagePreview" width="60" height="60" alt="标题图片" overflow: hidden; background-color: #FFFFFF; padding: 2px; border: 1px solid #CCC"/>
							</c:otherwise>
						</c:choose>
						<input type="button" value="浏览图库" onclick="window.sector.open('images','#product\\.image','#titleImagePreview')" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
						<input type="button" value="删除图片" onclick="$('#titleImagePreview').attr('src','images/imgOccupying.png');$('#product\\.image').val('images/imgOccupying.png')" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
						
						<input type="hidden" id="product.image" name="product.image" value="${product.image }" />
					</li>
					<li><label class="label"> 组图: </label><input type="button" value="添加图片" onclick="addImage()" class="btnSmall" onfocus="this.blur()" onMouseOver="this.className='btnSmall_over'" onMouseOut="this.className='btnSmall'" style="vertical-align: top" />
						
						<div id="images" style="margin-left: 104px;margin-right: 218px; width: 200px;" >
						<br/>
					<table>
						<tr>
							<td><span class="prev" style="cursor: pointer;"><img src="images/arrow_L.jpg" width="19" height="60"></span></td>
							<td><div class="anyClass">
				            <ul>
							<c:forEach var="item" items="${product.images }">
								<li style="position: relative;">
									<div
										style="z-index: 11; display: block; position: absolute;right: 5px; top:5px;">
										<img onclick="delImage(this);" title="删除图片"
											src="images/close.png"
											style="cursor:pointer;" />
									</div>
									<div style="z-index: 10;">
										<img width="120" height="80" src="${item.url }" alt="picture"
											ondblclick="editImage(this)" /><br/> <span>${item.description}</span>
									</div>
								</li>
							</c:forEach>
						</ul>
				        </div></td>
							<td><span class="next" style="cursor: pointer;"><img src="images/arrow_R.jpg" width="19" height="60"></span></td>
						</tr>
					</table>
					
						
						
						</div>
					</li>
			</ol>
				<div style="padding: 40px 110px; border-top: 1px dotted #CCC">
					<input type="submit" value="保存" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
					<input type="button" value="返回" onclick="window.fn.openURL('jsp/product/ProductList.jsp');" class="btn" onfocus="this.blur()" onMouseOver="this.className='btn_over'" onMouseOut="this.className='btn'" style="vertical-align: top" />
				</div>
			</div>
			</form>
	</body>
</html>