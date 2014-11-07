var Week = {};
var Month = {};
Date.prototype.format = function (format)
{
    /*
    * eg:format="YYYY-MM-dd hh:mm:ss";
    */
    var o = {
        "M+": this.getMonth() + 1, // month
        "d+": this.getDate(), // day
        "h+": this.getHours(), // hour
        "m+": this.getMinutes(), // minute
        "s+": this.getSeconds(), // second
        "q+": Math.floor((this.getMonth() + 3) / 3), // quarter
        "S": this.getMilliseconds()
        // millisecond
    };

    if (/(y+)/.test(format))
    {
        format = format.replace(RegExp.$1, (this.getFullYear() + "")
            .substr(4 - RegExp.$1.length));
    }

    for (var k in o)
    {
        if (new RegExp("(" + k + ")").test(format))
        {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k]
                : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;
};
var WeekOfDay = function ()
{
    this.Week = '';
    this.Start = '';
    this.End = '';
    this.toString = function ()
    {
        return this.Week + '(' + this.Start.format('MM月dd日') + '-' + this.End.format('MM月dd日') + ')';
    };
};
//得到一个月的第一天返回日期
Month.GetFirstDay = function (year, month)
{
    return new Date(year, month, 1);
};
//得到一个月最后一天返回整数天
Month.GetLastDay = function (year, month)
{
    return new Date(year, month + 1, 0).getDate();
};
Week.GetFirstDay = function (date)
{
    var week = date.getDay();
    if (week == 0)
        week = 7;
    var sdate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - week + 1);
    return sdate;
};

Week.GetLastDay = function (date)
{
    var week = date.getDay();
    if (week == 0)
        week = 7;
    var edate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 6 - week + 1);
    return edate;
};
Week.GetWeeks = function (year, month)
{
    var weeks = [];
    var index = 1;

    var weekOfDay = new WeekOfDay();
    weekOfDay.Week = 1;
    var date = Month.GetFirstDay(year, month);
    weekOfDay.Start = Week.GetFirstDay(date);
    weekOfDay.End = Week.GetLastDay(date);
    weeks.push(weekOfDay);

    var startDay = weekOfDay.End.getDate();
    startDay++;
    var endDay = Month.GetLastDay(year, month);

    for (var i = startDay; i <= endDay; i++)
    {
        var nextDate = new Date(year, month, i);
        if (nextDate.getDay() == 1)
        {
            index++;
            weekOfDay = new WeekOfDay();
            weekOfDay.Week = index;
            weekOfDay.Start = Week.GetFirstDay(nextDate);
            weekOfDay.End = Week.GetLastDay(nextDate);
            weeks.push(weekOfDay);
        }
    }
    return weeks;
};
