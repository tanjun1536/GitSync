(function() {
    window.ArrayUtil = {};
    window.ArrayUtil.sort = function(array) {
        var ret = new Array();
        var order = array.sort(function(a, b) {
            if(a.orderNumber < b.orderNumber)
                return -1;
            if(a.orderNumber > b.orderNumber)
                return 1;
            return 0;
        });
        $.each(order, function(index, value) {
            ret.push(value);
        });
        return ret;
    }
    ,
    window.ArrayUtil.isRepeat=function(array)
    {
    	var hash = {}; 
    	for(var i in array) { 
    		if(hash[array[i]]) 
    			return true; 
    		hash[array[i]] = true; 
    	} 
    	return false; 
    }
    window.ArrayUtil.compare = function(src, des) {
        return fn.sort(src).toString() == fn.sort(des).toString();
    },
    window.ArrayUtil.delElement = function(array,data) {
        return $.grep(array, function(value) {
            if(typeof(value)==Object)
            return value.id !=data;
            else 
            return value !=data;
        });
    }
})(jQuery);
