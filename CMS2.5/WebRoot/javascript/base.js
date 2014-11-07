(function() {
	window.fn = new Object();
	window.fn.getNumber=function(d)
	{
		var v = parseFloat(d);
		if (isNaN(v)) {
			v = 0.0;
		}
		return v;
	}
	window.fn.getFloat = function(m, v) {
		var d = parseFloat(m);
		if (isNaN(d)) {
			d = 0.0;
		}
		return d * v;
	}
	window.fn.formatFloat = function(src, pos) {
		return Math.round(src * Math.pow(10, pos)) / Math.pow(10, pos);
	}
	//v被除数
	//p除数
	fn.getDivide=function(p,v)
	{
		var d=parseFloat(p);
		var y=parseFloat(v);
		if(isNaN(d)) d=0.0;
		if(isNaN(y)) y=0.0;
		if(d==0.0) return 0;
		return fn.formatFloat(y/d,2);
	}
	fn.getMultiplication=function()
	{
		var m=1;
		for(var i=0;i<arguments.length;i++)
		{
			var d=parseFloat(arguments[i]);
			if(isNaN(d)) return 0;
			m=m*d;
		}
		return fn.formatFloat(m,4);
	}
	fn.openURL=function(url)
	{
		if(url.indexOf('?')>0)url=url+'&d='+new Date().toString();
		else url=url+'?d='+new Date().toString();
		//if(url.indexOf('http')==-1)url=<%=basePath%>url;
		//alert(url);
		//$(location).attr('href',url);
		parent.changeLocation(url);
	}
	fn.openParentURL=function(url)
	{
		if(url.indexOf('?')>0)url=url+'&d='+new Date().toString();
		else url=url+'?d='+new Date().toString();
		//if(url.indexOf('http')==-1)url=<%=basePath%>url;
		//alert(url);
		//$(location).attr('href',url);
		parent.parent.changeLocation(url);
	}

})(jQuery);

function changeJqGridWidth(w)
{
	$("#gridTable").setGridWidth($("#gridTable").width()+w);
}
function fitJqGridWidth(w)
{
	$("#gridTable").setGridWidth(w);
}
