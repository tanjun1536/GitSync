(function() {
	if (window.fn == undefined)
		window.fn = {};

	fn.sort = function(array) {
		var ret = new Array();
		var order = array.sort(function(a, b) {
			if (a < b)
				return -1;
			if (a > b)
				return 1;
			return 0;
		});
		$.each(order, function(index, value) {
			ret.push(value);
		});
		return ret;
	}
	fn.compare = function(src, des) {
		return fn.sort(src).toString() == fn.sort(des).toString();
	}
	fn.delElement = function(array, data) {
		return $.grep(array, function(value) {
			if (typeof (value) == Object)
				return value.id != data;
			else
				return value != data;
		});
	}
})(jQuery);

Array.prototype.contains = function(item) {
	return RegExp("\\b" + item + "\\b").test(this);
};
