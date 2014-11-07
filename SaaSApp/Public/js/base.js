(function() {
    window.validator = new Object();
    window.fn = new Object();
    window.validator.empty = function(sector, msg) {
        if($('#' + sector).val() == '') {
            alert(msg);
            $('#' + sector).trigger('focus');
            return false;
        }
        return true;
    }
    window.validator.index = function(sector, msg) {
        if($('#' + sector).get(0).selectedIndex == 0) {
            alert(msg);
            $('#' + sector).trigger('focus');
            return false;
        }
        return true;

    }
    window.validator.length = function(msg) {
        if($("input[type=checkbox]:checked").length == 0) {
            alert(msg);
            return false;
        }
        return true;
        
    }
    fn.getCheckedValue = function(split) {
        var len = $("input[type=checkbox]:checked").length;
        if(len == 0)
            return '';
        var ret = "";
        if(split == undefined)
            split = ",";
        for(var i = 0; i < len; i++) {
            var cb = $("input[type=checkbox]:checked")[i];
            ret += cb.value;
            if(i < len - 1)
                ret += split;
        }
        return ret;
    }
    fn.getFloat=function(v)
    {
        var ret=parseFloat(v);
        if(isNaN(ret)) ret=0;
        
        return Math.round(ret);
    }
})(jQuery);
function delAwoke() {
    if($("input[type=checkbox]:checked").length == 0) {
        alert("請選擇要刪除的數據!");
        return false;
    }
    if(!confirm("確認要刪除選擇的數據嗎？")) {
        return false;
    }
    return true;

}