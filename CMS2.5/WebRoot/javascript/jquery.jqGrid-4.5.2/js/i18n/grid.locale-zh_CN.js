(function(a) {
	a.jgrid = {
		defaults : {
			recordtext : "第 {0} 到 {1} 条，共 {2}条",
			emptyrecords : "没有数据",
			loadtext : "正在加载数据...",
			pgtext : "第 {0} 页，共 {1} 页"
		},
		search : {
			caption : "正在查找...",
			Find : "查找",
			Reset : "Reset",
			odata : ["equal", "not equal", "less", "less or equal", "greater",
					"greater or equal", "begins with", "does not begin with",
					"is in", "is not in", "ends with", "does not end with",
					"contains", "does not contain"],
			groupOps : [{
						op : "AND",
						text : "all"
					}, {
						op : "OR",
						text : "any"
					}],
			matchText : " match",
			rulesText : " rules"
		},
		edit : {
			addCaption : "Add Record",
			editCaption : "Edit Record",
			bSubmit : "提交",
			bCancel : "取消",
			bClose : "关闭",
			saveData : "数据已经被修改! 要保存吗?",
			bYes : "是",
			bNo : "否",
			bExit : "取消",
			msg : {
				required : "Field is required",
				number : "Please, enter valid number",
				minValue : "value must be greater than or equal to ",
				maxValue : "value must be less than or equal to",
				email : "is not a valid e-mail",
				integer : "Please, enter valid integer value",
				date : "Please, enter valid date value",
				url : "is not a valid URL. Prefix required ('http://' or 'https://')"
			}
		},
		view : {
			caption : "查看记录",
			bClose : "关闭"
		},
		del : {
			caption : "确认删除",
			msg : "确信要删除选中的记录吗?",
			bSubmit : "确定",
			bCancel : "取消"
		},
		nav : {
			edittext : "",
			edittitle : "Edit selected row",
			addtext : "",
			addtitle : "Add new row",
			deltext : "",
			deltitle : "删除选中的记录",
			searchtext : "",
			searchtitle : "查找记录",
			refreshtext : "",
			refreshtitle : "重新加载数据",
			alertcap : "警告",
			alerttext : "请先选中记录",
			viewtext : "",
			viewtitle : "View selected row"
		},
		col : {
			caption : "Show/Hide Columns",
			bSubmit : "Submit",
			bCancel : "Cancel"
		},
		errors : {
			errcap : "Error",
			nourl : "No url is set",
			norecords : "No records to process",
			model : "Length of colNames <> colModel!"
		},
		formatter : {
			integer : {
				thousandsSeparator : " ",
				defaultValue : "0"
			},
			number : {
				decimalSeparator : ".",
				thousandsSeparator : " ",
				decimalPlaces : 2,
				defaultValue : "0.00"
			},
			currency : {
				decimalSeparator : ".",
				thousandsSeparator : " ",
				decimalPlaces : 2,
				prefix : "",
				suffix : "",
				defaultValue : "0.00"
			},
			date : {
				dayNames : ["Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat",
						"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday",
						"Friday", "Saturday"],
				monthNames : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
						"Aug", "Sep", "Oct", "Nov", "Dec", "January",
						"February", "March", "April", "May", "June", "July",
						"August", "September", "October", "November",
						"December"],
				AmPm : ["am", "pm", "AM", "PM"],
				S : function(b) {
					return b < 11 || b > 13 ? ["st", "nd", "rd", "th"][Math
							.min((b - 1) % 10, 3)] : "th"
				},
				srcformat : "Y-m-d",
				newformat : "d/m/Y",
				masks : {
					ISO8601Long : "Y-m-d H:i:s",
					ISO8601Short : "Y-m-d",
					ShortDate : "n/j/Y",
					LongDate : "l, F d, Y",
					FullDateTime : "l, F d, Y g:i:s A",
					MonthDay : "F d",
					ShortTime : "g:i A",
					LongTime : "g:i:s A",
					SortableDateTime : "Y-m-d\\TH:i:s",
					UniversalSortableDateTime : "Y-m-d H:i:sO",
					YearMonth : "F, Y"
				},
				reformatAfterEdit : false
			},
			baseLinkUrl : "",
			showAction : "",
			target : "",
			checkbox : {
				disabled : true
			},
			idName : "id"
		}
	}
})(jQuery);