/*
 *  name--------------n
 *  sorttype--------------s
 *  width--------------w
 *  hidden--------------h
 *  align--------------a
 *  eidtable--------------e
 * */

(function() {
	window.jqGrid = {};
	window.jqGrid.jqGridColumn = function(object) {
		if (typeof object.n != 'undefined') {
			this.name = object.n;
			this.index = object.n;
		}
		if (typeof object.s != 'undefined') {
			this.sorttype = object.s;
			this.sortable = true;

		} else {
			this.sortable = false;
		}
		if (typeof object.w != 'undefined') {
			this.width = object.w;
		}
		if (typeof object.h != 'undefined') {
			this.hidden = object.h;
		}
		if (typeof object.e != 'undefined') {
			this.editable = object.e;
		}
		if (typeof object.a != 'undefined') {
			this.align = object.a;
		} else {
			this.align = 'center';
		}
		if (typeof object.f != 'undefined') {
			this.formatter = object.f;
		}

	}
	// gc grid表格列的名字
	// name按钮的id可以不给
	// showName按钮显示的名字 (如果不给就不显示名字,适用于使用css控制按钮的显示效果)
	// tip 鼠标移动上去显示的文字
	// css按钮的样式(按钮的css名字)
	// action按钮的按下执行的操作
	// width按钮的宽度
	// height按钮的高度

	window.jqGrid.crateJqGridButtonColumn = function(object, objId) {
		var but = "<input type='button' ";
		if (typeof object.name != 'undefined') {
			but += " name ='" + object.name + "'";
		}
		if (typeof object.showName != 'undefined') {
			but += " value ='" + object.showName + "'";
		}
		if (typeof object.tip != 'undefined') {
			but += " title ='" + object.tip + "'";
		}
		if (typeof object.css != 'undefined') {
			but += " class ='" + object.css + "'";
		}
		if (typeof object.width != 'undefined') {
			but += " width ='" + object.width + "'";
		}
		if (typeof object.height != 'undefined') {
			but += " height ='" + object.height + "'";
		}
		if (typeof object.action != 'undefined') {
			but += " onclick ='" + object.action + "(" + objId + ")'";
		}
		if (typeof object.disabled != 'undefined' && object.disabled==true) {
			but += " disabled = 'true'";
		}
		but += " />";
		return but;
	}
	window.jqGrid.crateJqGridButtonColumnWithTemplate = function(object, objId,tempId) {
		var but = "<input type='button' ";
		if (typeof object.name != 'undefined') {
			but += " name ='" + object.name + "'";
		}
		if (typeof object.showName != 'undefined') {
			but += " value ='" + object.showName + "'";
		}
		if (typeof object.tip != 'undefined') {
			but += " title ='" + object.tip + "'";
		}
		if (typeof object.css != 'undefined') {
			but += " class ='" + object.css + "'";
		}
		if (typeof object.width != 'undefined') {
			but += " width ='" + object.width + "'";
		}
		if (typeof object.height != 'undefined') {
			but += " height ='" + object.height + "'";
		}
		if (typeof object.action != 'undefined') {
			but += " onclick ='" + object.action + "(" + objId + ","+tempId+")'";
		}
		if (typeof object.disabled != 'undefined' && object.disabled==true) {
			but += " disabled = 'true'";
		}
		but += " />";
		return but;
	}
	window.jqGrid.createColModel = function(columns) {
		var cls = columns.split('|');
		var array = new Array();
		for ( var i = 0; i < cls.length; i++) {
			array.push(new jqGrid.jqGridColumn(eval('(' + cls[i] + ')')));
		}
		return array;
	}
	window.jqGrid.createColModelByArray = function(columns) {
		var array = new Array();
		for ( var i = 0; i < columns.length; i++) {
			array.push(new jqGrid.jqGridColumn(eval('(' + columns[i] + ')')));
		}
		return array;
	}
	window.jqGrid.createJqGridSeparateButton = function(table, pager, url, datatype, headers, columns, pagesize, caption, srfunction, buttons) {
		$(table).jqGrid({
			url : url,
			mtype : "POST",
			datatype : datatype,
			height : "100%",
			colNames : headers.split(','),
			colModel : jqGrid.createColModelByArray(columns),
			rownumbers : true,
			sortname : 'id',
			sortorder : 'asc',
			viewrecords : true,
			jsonReader : {
				repeatitems : false,
				id : "id"
			},
			autowidth : true,
			forceFit : true,
			shrinkToFit : true,
			width : "100%",
			rowNum : pagesize*2,
			rowList : [ pagesize*2, pagesize * 4, pagesize * 6 ],
			pager : pager,
			multiselect : true,
			multiboxonly : true,
			caption : caption,
			onSelectRow : function(iRow) {
				// alert(srfunction);
				if (srfunction != undefined) {
					srfunction.call($(table), iRow);
					// $(table).setCell(iRow, "rn",iRow);
				}
			},
			loadComplete : function() {
				if (buttons != undefined && buttons.length > 0) {
					var ids = jQuery(table).getDataIDs();
					for ( var i = 0; i < ids.length; i++) {
						var id = $(table).getRowData(ids[i]).id;
						var tid = $(table).getRowData(ids[i])["contentTemplate.id"];
						for ( var j = 0; j < buttons.length; j++) {
							var gc = buttons[j].gc;
							var data =$(table).getRowData(ids[i]);
							var buttonObj=buttons[j];
							if(buttonObj.textFormatter)
								buttonObj=buttonObj.textFormatter.call($(table),data,buttonObj);
							var button = jqGrid.crateJqGridButtonColumnWithTemplate(buttonObj, id,tid);
							var json = '({"' + gc + '":"' + button + '"})';
							jQuery(table).setRowData(ids[i], eval(json));
						}

					}

				}
			}
		});
	}, window.jqGrid.createJqGridSeparateButtonNoPager = function(table, url, datatype, headers, columns, pagesize, caption, srfunction, buttons) {
		$(table).jqGrid({
			url : url,
			mtype : "POST",
			datatype : datatype,
			height : "100%",
			colNames : headers.split(','),
			colModel : jqGrid.createColModelByArray(columns),
			rownumbers : true,
			sortname : 'id',
			sortorder : 'asc',
			viewrecords : true,
			jsonReader : {
				repeatitems : false,
				id : "id"
			},
			autowidth : true,
			forceFit : true,
			shrinkToFit : true,
			width : "100%",
			rowNum : pagesize*2,
			rowList : [ pagesize*2, pagesize * 4, pagesize * 6 ],
			multiselect : true,
			multiboxonly : true,
			caption : caption,
			onSelectRow : function(iRow) {
				// alert(srfunction);
				if (srfunction != undefined) {
					srfunction.call($(table), iRow);
					// $(table).setCell(iRow, "rn",iRow);
				}
			},
			loadComplete : function() {
				if (buttons != undefined && buttons.length > 0) {
					var ids = jQuery(table).getDataIDs();
					for ( var i = 0; i < ids.length; i++) {
						var id = $(table).getRowData(ids[i]).id;
						var tid = $(table).getRowData(ids[i])["contentTemplate.id"];
						for ( var j = 0; j < buttons.length; j++) {
							var gc = buttons[j].gc;
							var data =$(table).getRowData(ids[i]);
							var buttonObj=buttons[j];
							if(buttonObj.textFormatter)
								buttonObj=buttonObj.textFormatter.call($(table),data,buttonObj);
							var button = jqGrid.crateJqGridButtonColumnWithTemplate(buttonObj, id,tid);
							var json = '({"' + gc + '":"' + button + '"})';
							jQuery(table).setRowData(ids[i], eval(json));
						}

					}

				}
			}
		});
	}, window.jqGrid.createJqGridNoCheckBoxSeparateButton = function(table, pager, url, datatype, headers, columns, pagesize, caption, srfunction, buttons) {
		$(table).jqGrid({
			url : url,
			mtype : "POST",
			datatype : datatype,
			height : "100%",
			colNames : headers.split(','),
			colModel : jqGrid.createColModelByArray(columns),
			rownumbers : true,
			sortname : 'id',
			sortorder : 'asc',
			viewrecords : true,
			jsonReader : {
				repeatitems : false,
				id : "id"
			},
			autowidth : true,
			forceFit : true,
			shrinkToFit : true,
			width : "100%",
			rowNum : pagesize*2,
			rowList : [ pagesize*2, pagesize * 4, pagesize * 6 ],
			pager : pager,
			multiselect : false,
			multiboxonly : true,
			caption : caption,
			onSelectRow : function(iRow) {
				// alert(srfunction);
				if (srfunction != undefined) {
					srfunction.call($(table), iRow);
					// $(table).setCell(iRow, "rn",iRow);
				}
			},
			loadComplete : function() {
				if (buttons != undefined && buttons.length > 0) {
					var ids = jQuery(table).getDataIDs();
					for ( var i = 0; i < ids.length; i++) {
						var id = $(table).getRowData(ids[i]).id;
						var tid = $(table).getRowData(ids[i])["contentTemplate.id"];
						for ( var j = 0; j < buttons.length; j++) {
							var gc = buttons[j].gc;
							var data =$(table).getRowData(ids[i]);
							var buttonObj=buttons[j];
							if(buttonObj.textFormatter)
								buttonObj=buttonObj.textFormatter.call($(table),data,buttonObj);
							var button = jqGrid.crateJqGridButtonColumnWithTemplate(buttonObj, id,tid);
							var json = '({"' + gc + '":"' + button + '"})';
							jQuery(table).setRowData(ids[i], eval(json));
						}

					}

				}
			}
		});
	}, window.jqGrid.createJqGrid = function(table, pager, url, datatype, headers, columns, pagesize, caption, buttons, srfunction, functions) {
		$(table).jqGrid({
			url : url,
			mtype : "POST",
			datatype : datatype,
			height : "100%",
			colNames : headers.split(','),
			colModel : jqGrid.createColModelByArray(columns),
			rownumbers : true,
			sortname : 'id',
			sortorder : 'asc',
			viewrecords : true,
			jsonReader : {
				repeatitems : false,
				id : "id"
			},
			autowidth : true,
			forceFit : true,
			shrinkToFit : true,
			width : "100%",
			rowNum : pagesize*2,
			rowList : [ pagesize*2, pagesize * 4, pagesize * 6 ],
			pager : pager,
			multiselect : true,
			multiboxonly : true,
			caption : caption,
			onSelectRow : function(iRow) {
				// alert(srfunction);
				if (srfunction != undefined) {
					srfunction.call($(table), iRow);
					// $(table).setCell(iRow, "rn",iRow);
				}
			},
			loadComplete : function() {
				if (buttons != undefined && functions != undefined) {
					var ids = jQuery(table).getDataIDs();
					for ( var i = 0; i < ids.length; i++) {
						var id = $(table).getRowData(ids[i]).id;
						var button = "";
						var buttonNames = buttons.split(',');
						var functionsNames = functions.split(',');
						for ( var j = 0; j < buttonNames.length; j++) {
							if (j == 0)
								button += "<input class='editButton' name='jqGridButton'" + i + " style='border:0px;cursor:pointer' title='编辑' type='button' onclick=" + functionsNames[j] + "(" + id + "); />";
							else if (j == 1)
								button += "  <input class='deleteButton' name='jqGridButton'" + i + " style='border:0px;cursor:pointer' title='删除' type='button' onclick=" + functionsNames[j] + "(" + id + "); />";
							else
								button += "  <input name='jqGridButton'" + i + " style='height:22px;width:40px;' type='button' value='" + buttonNames[j] + "' onclick=" + functionsNames[j] + "(" + id + "); />";
						}
						jQuery(table).setRowData(ids[i], {
							act : button
						});
					}

				}
			}
		});
	}, window.jqGrid.createJqGridNoCheckboxWithButtonStyles = function(table, pager, url, datatype, headers, columns, pagesize, caption, buttons, srfunction, functions, buttonstyles, buttonsToolTips) {
		$(table).jqGrid({
			url : url,
			mtype : "POST",
			datatype : datatype,
			height : "100%",
			colNames : headers.split(','),
			colModel : jqGrid.createColModelByArray(columns),
			rownumbers : true,
			sortname : 'id',
			sortorder : 'asc',
			viewrecords : true,
			jsonReader : {
				repeatitems : false,
				id : "id"
			},
			autowidth : true,
			forceFit : true,
			shrinkToFit : true,
			width : "100%",
			rowNum : pagesize*2,
			rowList : [ pagesize*2, pagesize * 4, pagesize * 6 ],
			pager : pager,
			multiselect : true,
			multiboxonly : true,
			caption : caption,
			loadComplete : function() {
				if (buttons != undefined && functions != undefined) {
					var ids = jQuery(table).getDataIDs();
					for ( var i = 0; i < ids.length; i++) {
						var id = $(table).getRowData(ids[i]).id;
						var button = "";
						var buttonNames = buttons.split(',');
						var functionsNames = functions.split(',');
						var buttonstyleNames = buttonstyles.split(',');
						var buttonToolTipsName = buttonsToolTips.split(',');
						for ( var j = 0; j < buttonNames.length; j++) {
							if (buttonstyleNames != undefined)
								button += "<input class='" + buttonstyleNames[i] + "' name='jqGridButton'" + i + " style='border:0px;cursor:pointer' title='" + buttonToolTipsName[i] + "' type='button' onclick=" + functionsNames[j] + "(" + id + "); />";
						}
						jQuery(table).setRowData(ids[i], {
							act : button
						});
					}

				}
			}
		});
	}, window.jqGrid.createJqGridNoCheckbox = function(table, pager, url, datatype, headers, columns, pagesize, caption, buttons, srfunction, functions) {
		$(table).jqGrid({
			url : url,
			mtype : "POST",
			datatype : datatype,
			height : "100%",
			colNames : headers.split(','),
			colModel : jqGrid.createColModelByArray(columns),
			rownumbers : true,
			sortname : 'id',
			sortorder : 'asc',
			viewrecords : true,
			jsonReader : {
				repeatitems : false,
				id : "id"
			},
			autowidth : true,
			forceFit : true,
			shrinkToFit : true,
			width : "100%",
			rowNum : pagesize*2,
			rowList : [ pagesize*2, pagesize * 4, pagesize * 6 ],
			pager : pager,
			multiselect : false,
			multiboxonly : true,
			caption : caption,
			loadComplete : function() {
				if (buttons != undefined && functions != undefined) {
					var ids = jQuery(table).getDataIDs();
					for ( var i = 0; i < ids.length; i++) {
						var id = $(table).getRowData(ids[i]).id;
						var button = "";
						var buttonNames = buttons.split(',');
						var functionsNames = functions.split(',');
						for ( var j = 0; j < buttonNames.length; j++) {
							if (j == 0)
								button += "<input class='editButton' name='jqGridButton'" + i + " style='border:0px;cursor:pointer' title='编辑' type='button' onclick=" + functionsNames[j] + "(" + id + "); />";
							else if (j == 1)
								button += "  <input class='deleteButton' name='jqGridButton'" + i + " style='border:0px;cursor:pointer' title='删除' type='button' onclick=" + functionsNames[j] + "(" + id + "); />";
							else
								button += "  <input name='jqGridButton'" + i + " style='height:22px;width:40px;' type='button' value='" + buttonNames[j] + "' onclick=" + functionsNames[j] + "(" + id + "); />";
						}
						jQuery(table).setRowData(ids[i], {
							act : button
						});
					}

				}
			}
		});
	}, window.jqGrid.createJqGridNoPager = function(table, url, datatype, headers, columns, caption, multiselect, srfunction, dbcfunction, buttons, functions) {
		$(table).jqGrid({
			url : url,
			mtype : "POST",
			datatype : datatype,
			height : "100%",
			colNames : headers.split(','),
			colModel : jqGrid.createColModel(columns),
			rownumbers : true,
			sortname : 'id',
			sortorder : 'asc',
			viewrecords : true,
			jsonReader : {
				repeatitems : false,
				id : "id"
			},
			autowidth : true,
			forceFit : true,
			shrinkToFit : true,
			width : "100%",
			multiselect : multiselect,
			multiboxonly : true,
			caption : caption,
			onSelectRow : function(iRow) {
				// alert(srfunction);
				if (srfunction != undefined) {
					srfunction.call($(table), iRow);
					// $(table).setCell(iRow, "rn",iRow);
				}
			},
			ondblClickRow : function(iRow) {
				if (dbcfunction != undefined) {
					dbcfunction.call($(table), iRow);
				}
			},
			loadComplete : function() {
				if (buttons != undefined && functions != undefined) {
					var ids = jQuery(table).getDataIDs();
					for ( var i = 0; i < ids.length; i++) {
						var id = $(table).getRowData(ids[i]).id;
						var button = "";
						var buttonNames = buttons.split(',');
						var functionsNames = functions.split(',');
						for ( var j = 0; j < buttonNames.length; j++) {
							if (j == 0)
								button += "<input class='editButton' name='jqGridButton'" + i + " style='border:0px;cursor:pointer' title='编辑' type='button' onclick=" + functionsNames[j] + "(" + id + "); />";
							else if (j == 1)
								button += "  <input class='deleteButton' name='jqGridButton'" + i + " style='border:0px;cursor:pointer' title='删除' type='button' onclick=" + functionsNames[j] + "(" + id + "); />";
							else
								button += "  <input name='jqGridButton'" + i + " style='height:22px;width:40px;' type='button' value='" + buttonNames[j] + "' onclick=" + functionsNames[j] + "(" + id + "); />";
						}
						jQuery(table).setRowData(ids[i], {
							act : button
						});
					}

				}
			}
		});
	}, jqGrid.addRow = function(table, object) {
		$(table).resetSelection();
		var array = $(table).getDataIDs();
		var id = array.length + 1;
		$(table).addRowData(id, object);
		//$(table).trigger("loadComplete");
		$(table).setSelection(id);
	}, jqGrid.reLoad = function(table, url) {
		jQuery(table).setGridParam({
			url : url
		}).trigger("reloadGrid");

	}, jqGrid.refresh = function(table) {
		jQuery(table).trigger("reloadGrid");
	}, jqGrid.Clear = function(table) {
		var tab = $(table);
		var array = tab.getDataIDs();
		for ( var i = 0; i < array.length; i++) {
			tab.delRowData(array[i]);
		}
	}, jqGrid.deleteRow = function(table,id) {
		var tab = $(table);
		var array = tab.getDataIDs();
		for ( var i = 0; i < array.length; i++) {
			if($(table).getRowData(array[i]).id==id)
				tab.delRowData(array[i]);
		}
	},
	
	jqGrid.getSelected = function(table) {
		var tab = $(table);
		var array = tab.getGridParam("selarrrow");
		var R = "";
		if (array) {
			for ( var i = 0; i < array.length; i++) {
				R += tab.getRowData(array[i]).id;
				if (i < array.length - 1)
					R += ",";
			}
		}
		return R;
	},
	jqGrid.getSelectedRowsData = function(table) {
		var tab = $(table);
		var array = tab.getGridParam("selarrrow");
		var ret = new Array();
		if (array) {
			for ( var i = 0; i < array.length; i++) {
				var data=tab.getRowData(array[i]);
				ret.push(data);
			}
		}
		return ret;
	},
	jqGrid.getSelectedRowData = function(table,clickedid) {
		var ids = jQuery(table).getDataIDs();
		var ret=null;
		var row=null;
		for ( var i = 0; i < ids.length; i++) {
			row=$(table).getRowData(ids[i]);
			if(clickedid == row.id)
				ret=row;
		}
		return ret;
	},
	
	jqGrid.editRow = function(table, id, b) {
		var tab = $(table);
		tab.editRow(id, true);
	}, jqGrid.restoreRow = function(table, id) {
		var tab = $(table);
		tab.restoreRow(id);
	}
})(jQuery);