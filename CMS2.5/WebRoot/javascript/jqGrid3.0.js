(function ()
{
    window.jqGrid = {};
    var defaultOptions =
    {
        table: "#list",
        url: "",
        addUrl: "",
        editUrl: "",
        deleteUrl: "",
        datatype: "json",
        mtype: "GET",
        colNames: [],
        colModel: [],
        pager: "#pager",
        rowNum: 15,
        rowList: [15, 30, 60],
        sortname: "id",
        rownumbers: true,
        sortorder: "desc",
        autowidth: true,
        forceFit: true,
        shrinkToFit: true,
        width: "100%",
        viewrecords: true,
        scrollOffset: 0,
        height: "100%",
        caption: "",
        jsonReader: {
            repeatitems: false,
            id: "id"
        }
    };
    window.jqGrid.createJqGrid = function (options)
    {
        $.extend(defaultOptions, options);
        var table = defaultOptions.table;
        var buttons = defaultOptions.buttons;
        if (buttons)
        {
            defaultOptions.gridComplete = function ()
            {
                var ids = jQuery(table).getDataIDs();
                for (var i = 0; i < ids.length; i++)
                {
                    var data = $(table).getRowData(ids[i]);
                    var id = data.id;
                    for (var j = 0; j < buttons.length; j++)
                    {
                        var c = buttons[j].column;
                        var h = buttons[j].html.replace(/{id}/g, id);
                        var t = buttons[j].text;
                        var button = {};
                        button[c] = eval(buttons[j].condition)?t:h;
                        jQuery(table).setRowData(ids[i], button);
                    }
                }
            };
        }
        $(table).jqGrid(defaultOptions);
    };
    function htmlEnCode(str)
    {
        var s = "";
        if (str.length == 0) return "";
        s = str.replace(/&/g, "&gt;");
        s = s.replace(/</g, "&lt;");
        s = s.replace(/>/g, "&gt;");
        s = s.replace(/    /g, "&nbsp;");
        s = s.replace(/\'/g, "'");
        s = s.replace(/\"/g, "&quot;");
        s = s.replace(/\n/g, "<br>");
        return s;
    }
    function htmlDeCode(str)
    {
        var s = "";
        if (str.length == 0) return "";
        s = str.replace(/&gt;/g, "&");
        s = s.replace(/&lt;/g, "<");
        s = s.replace(/&gt;/g, ">");
        s = s.replace(/&nbsp;/g, "    ");
        s = s.replace(/'/g, "\'");
        s = s.replace(/&quot;/g, "\"");
        s = s.replace(/<br>/g, "\n");
        return s;
    }
    window.jqGrid.Add = function ()
    {
        $(location).attr('href', defaultOptions.addUrl);
    };
    window.jqGrid.Edit = function (id)
    {
        var url = defaultOptions.editUrl + id;
        $(location).attr('href', url);
    };
    window.jqGrid.Delete = function (id)
    {
        if (!confirm('确认删除此行数据?')) return;
        jQuery.post(defaultOptions.deleteUrl, { id: id }, function ()
        {
            jQuery(defaultOptions.table).setGridParam({
                url: defaultOptions.url
            }).trigger("reloadGrid");
        }, "json");
    };
    jqGrid.addRow = function (table, object)
    {
        $(table).resetSelection();
        var array = $(table).getDataIDs();
        var id = array.length + 1;
        $(table).addRowData(id, object);
        //$(table).trigger("loadComplete");
        $(table).setSelection(id);
    };
    jqGrid.reLoad = function (table, url)
    {
        jQuery(table).setGridParam({
            url: url
        }).trigger("reloadGrid");

    };
    jqGrid.refresh = function (table)
    {
        jQuery(table).trigger("reloadGrid");
    };
    jqGrid.Clear = function (table)
    {
        var tab = $(table);
        var array = tab.getDataIDs();
        for (var i = 0; i < array.length; i++)
        {
            tab.delRowData(array[i]);
        }
    };
    jqGrid.deleteRow = function (table, id)
    {
        var tab = $(table);
        var array = tab.getDataIDs();
        for (var i = 0; i < array.length; i++)
        {
            if ($(table).getRowData(array[i]).id == id)
                tab.delRowData(array[i]);
        }
    };

    jqGrid.getSelected = function (table)
    {
        var tab = $(table);
        var array = tab.getGridParam("selarrrow");
        var R = "";
        if (array)
        {
            for (var i = 0; i < array.length; i++)
            {
                R += tab.getRowData(array[i]).id;
                if (i < array.length - 1)
                    R += ",";
            }
        }
        return R;
    };
    jqGrid.getSelectedRowsData = function (table)
    {
        var tab = $(table);
        var array = tab.getGridParam("selarrrow");
        var ret = new Array();
        if (array)
        {
            for (var i = 0; i < array.length; i++)
            {
                var data = tab.getRowData(array[i]);
                ret.push(data);
            }
        }
        return ret;
    };
    jqGrid.getSelectedRowData = function (table, clickedid)
    {
        var ids = jQuery(table).getDataIDs();
        var ret = null;
        var row = null;
        for (var i = 0; i < ids.length; i++)
        {
            row = $(table).getRowData(ids[i]);
            if (clickedid == row.id)
                ret = row;
        }
        return ret;
    };

    jqGrid.editRow = function (table, id, b)
    {
        var tab = $(table);
        tab.editRow(id, true);
    };
    jqGrid.restoreRow = function (table, id)
    {
        var tab = $(table);
        tab.restoreRow(id);
    };
})(jQuery);

