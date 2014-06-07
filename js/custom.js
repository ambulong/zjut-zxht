$(function(){
	escapeHTML = function(text) {	//HTML
		return $('<div/>').text(text).html();
	}
	$(".btn-checkall").click(function(){//全选或者全不选
		if($(".btn-checkall").attr("status") == "unchecked"){
			$(".s_checkbox").prop("checked",true);
			$(".btn-checkall").attr("status","checked");
		}else{
			$(".s_checkbox").prop("checked",false);
			$(".btn-checkall").attr("status","unchecked");
		}
	});
	$(".btn-delete-user").click(function(){//批量删除用户
		if(confirm("你确定要删除你选中的用户吗?")){
			$.each($('.users_td_operate'),function(index,item){
				if($(item).children(".s_checkbox").prop('checked') == true){
					$.get($(item).children(".main-content-operate").children(".link_delete").attr("href"));
					$(item).closest("tr").hide(300,function(){
						$(item).closest("tr").remove();
					});
				}
			});
		}
	});
	$(".btn-delete-proj").click(function(){//批量删除项目
		if(confirm("你确定要删除你选中的项目吗?")){
			$.each($('.projs_td_operate'),function(index,item){
				if($(item).children(".s_checkbox").prop('checked') == true){
					$.get($(item).children(".main-content-operate").children(".link_delete").attr("href"));
					$(item).closest("tr").hide(300,function(){
						$(item).closest("tr").remove();
					});
				}
			});
		}
	});
	$(".btn-delete-item").click(function(){//批量删除记录
		if(confirm("你确定要删除你选中的记录吗?")){
			$.each($('.item_td_operate'),function(index,item){
				if($(item).children(".s_checkbox").prop('checked') == true){
					$.get($(item).children(".main-content-operate").children(".link_delete").attr("href"));
					$(item).closest("tr").hide(300,function(){
						$(item).closest("tr").remove();
					});
				}
			});
		}
	});
	$("#btn-param-add").live("click",function(){//添加参数
		var regExp = /[a-z]$/;
		if($.trim($("#tr-param-add input[name='param-add-name']").val()) == ""){
			alert("参数名不能为空");
		}else if($.trim($("#tr-param-add input[name='param-add-name']").val()).toLocaleLowerCase() == "id"){
			alert("不能为id");
		}else if($.trim($("#tr-param-add input[name='param-add-label']").val()) == ""){
			alert("显示名不能为空");
		}else if(!regExp.test($("#tr-param-add input[name='param-add-name']").val())){
			alert("参数名只能为英文字母");
		}else{
			var add_name	= $.trim($("#tr-param-add input[name='param-add-name']").val());
			var add_label	= $.trim($("#tr-param-add input[name='param-add-label']").val());
			var add_method	= $.trim($("#tr-param-add select[name='param-add-method'] option:selected").val());
			var add_type	= $.trim($("#tr-param-add select[name='param-add-type'] option:selected").val());
			var add_case	= $.trim($("#tr-param-add input[name='param-add-case']").val());
			var add_allow_null	= $.trim($("#tr-param-add select[name='param-add-allow_null'] option:selected").val());
			var add_regex	= $.trim($("#tr-param-add input[name='param-add-regex']").val());
			var add_comment	= $.trim($("#tr-param-add input[name='param-add-comment']").val());
			var add_html	= "<tr class=\"tr-add tr-add-content\"><td class=\"td-add-operate\"><a class=\"add-del\" href=\"#\">del</a></td><td class=\"td-add-name\" title=\""+escapeHTML(add_name)+"\"><div>"	+escapeHTML(add_name)	+"</div></td><td class=\"td-add-label\"title=\""+escapeHTML(add_label)+"\"><div>"	+escapeHTML(add_label)	+"</div></td><td class=\"td-add-method\"title=\""+escapeHTML(add_method)+"\"><div>"	+escapeHTML(add_method)	+"</div></td><td class=\"td-add-type\"title=\""+escapeHTML(add_type)+"\"><div>"	+escapeHTML(add_type)	+"</div></td><td class=\"td-add-case\"title=\""+escapeHTML(add_case)+"\"><div>"	+escapeHTML(add_case)	+"</div></td><td class=\"td-add-allow_null\" title=\""+escapeHTML(add_allow_null)+"\"><div>"	+escapeHTML(add_allow_null)	+"</div></td><td class=\"td-add-regex\" title=\""+escapeHTML(add_regex)+"\"><div>"	+escapeHTML(add_regex)	+"</div></td><td class=\"td-add-comment\" title=\""+escapeHTML(add_comment)+"\"><div>"	+escapeHTML(add_comment)	+"</div></td></tr>";
			if(add_case != ""){	//判断是否符合json格式
				try{
					$.parseJSON(add_case)
				}catch (err){
					alert("你的case可能不符合json格式")
					return false;
				}
			}
			$("#tr-param-add").before(add_html);
			$("#tr-param-add input[name='param-add-name']").val("");
			$("#tr-param-add input[name='param-add-label']").val("");
			$("#tr-param-add input[name='param-add-case']").val("");
			$("#tr-param-add input[name='param-add-regex']").val("");
			$("#tr-param-add input[name='param-add-comment']").val("");
		}
	});
	$(".add-del").live("click",function(){	//移除参数
		$(this).closest(".tr-add").hide(500,function(){
			$(this).closest(".tr-add").remove();
		});
		return false;
	});
	$(".del-ele-a").live("click",function(){	//删除参数
		if($(this).attr("href") != "#"){
			if(confirm($(this).attr("delinfo"))){
				$.get($(this).attr("href"));
				$(this).closest(".tr-add").hide(500,function(){
					$(this).closest(".tr-add").remove();
				});
			}
		}else{
			$(this).closest(".tr-add").hide(500,function(){
				$(this).closest(".tr-add").remove();
			});
		}
		return false;
	});
	$("#form_proj_new .btn-submit").live("click",function(){
		var params = new Array();
		var index = 0;
		$.each($('.tr-add-content'),function(i,item){
				params[index] = new Array();
				params[index][0] = $(item).children(".td-add-name").children("div").text();
				params[index][1] = $(item).children(".td-add-label").children("div").text();
				params[index][2] = $(item).children(".td-add-method").children("div").text();
				params[index][3] = $(item).children(".td-add-type").children("div").text();
				params[index][4] = $(item).children(".td-add-case").children("div").text();
				params[index][5] = $(item).children(".td-add-allow_null").children("div").text();
				params[index][6] = $(item).children(".td-add-regex").children("div").text();
				params[index][7] = $(item).children(".td-add-comment").children("div").text();
				params[index] = JSON.stringify(params[index]);
				index++;
		});
		var data_json = JSON.stringify(params);
		if(data_json == "[]"){
			data_json = "";
		}
		$("#inputProjParams").text(data_json);
	});
	$("#form_proj_profile .btn-submit").live("click",function(){
		var params = new Array();
		var index = 0;
		$.each($('.tr-add-content'),function(i,item){
				params[index] = new Array();
				params[index][0] = $(item).children(".td-add-name").children("div").text();
				params[index][1] = $(item).children(".td-add-label").children("div").text();
				params[index][2] = $(item).children(".td-add-method").children("div").text();
				params[index][3] = $(item).children(".td-add-type").children("div").text();
				params[index][4] = $(item).children(".td-add-case").children("div").text();
				params[index][5] = $(item).children(".td-add-allow_null").children("div").text();
				params[index][6] = $(item).children(".td-add-regex").children("div").text();
				params[index][7] = $(item).children(".td-add-comment").children("div").text();
				params[index] = JSON.stringify(params[index]);
				index++;
		});
		var data_json = JSON.stringify(params);
		if(data_json == "[]"){
			data_json = "";
		}
		$("#inputProjParams").text(data_json);
	});
	$("#proj_auth_select_right").live("click",function(){	//项目权限用户选择
		$.each($('#select_users option:selected'),function(i,item){
				$("#select_auths").append("<option value="+$(item).val()+">"+$(item).text()+"</option>");
				$(item).remove();
		});
	});
	$("#proj_auth_select_left").live("click",function(){	//项目权限用户选择
		$.each($('#select_auths option:selected'),function(i,item){
				$("#select_users").append("<option value="+$(item).val()+">"+$(item).text()+"</option>");
				$(item).remove();
		});
	});
	$("#proj-eles-select-right").live("click",function(){	//项目参数选择
		$.each($('#select-eles-left option:selected'),function(i,item){
				$("#select-eles-right").append("<option value="+$(item).val()+">"+$(item).text()+"</option>");
				$(item).remove();
		});
	});
	$("#proj-eles-select-left").live("click",function(){	//项目参数选择
		$.each($('#select-eles-right option:selected'),function(i,item){
				$("#select-eles-left").append("<option value="+$(item).val()+">"+$(item).text()+"</option>");
				$(item).remove();
		});
	});
	$("#proj-eles-select-up").live("click",function(){	//项目参数选择
		$.each($('#select-eles-right option:selected'),function(i,item){
				if($(item).prev().length > 0){
					$(item).prev().before("<option selected value="+$(item).val()+">"+$(item).text()+"</option>");
					$(item).remove();
				}
		});
	});
	$("#proj-eles-select-down").live("click",function(){	//项目参数选择
		var i = 0;
		$.each($('#select-eles-right option:selected'),function(i,item){
			if(i == 0){
				if($('#select-eles-right option:selected').last().next().length > 0){
					$('#select-eles-right option:selected').last().next().after("<option selected value="+$(item).val()+">"+$(item).text()+"</option>");
					$(item).remove();
				}
				i = 1;
			}else{
				$('#select-eles-right option:selected').last().after("<option selected value="+$(item).val()+">"+$(item).text()+"</option>");
				$(item).remove();
			}
		});
	});
	$("#form_proj_auth .btn-submit").live("click",function(){	//项目权限用户表单提交
		var uids = new Array();
		var str;
		var index = 0;
		$.each($('#select_auths option'),function(i,item){
			uids[index] = $(item).val();
			index++;
		});
		str = JSON.stringify(uids);
		$("#form_proj_auth input[name='uids']").val(str);
	});
	$("#form_proj_set .btn-submit").live("click",function(){	//项目设置表单提交
		var paramids = new Array();
		var str;
		var index = 0;
		$.each($('#select-eles-right option'),function(i,item){
			paramids[index] = $(item).val();
			index++;
		});
		str = JSON.stringify(paramids);
		$("#form_proj_set input[name='default_show']").val(str);
	});
	$("#form_proj_export .btn-submit").live("click",function(){	//项目导出表单提交
		var paramids = new Array();
		var str;
		var index = 0;
		$.each($('#select-eles-right option'),function(i,item){
			paramids[index] = $(item).val();
			index++;
		});
		str = JSON.stringify(paramids);
		$("#form_proj_export input[name='export_ids']").val(str);
	});
	$("#projs .api").live("click",function(){	//项目API
		var pname	= $(this).prev(".title").children("a").text();
		var pid		= $(this).next(".id").text();
		$("#modal-proj-api #modal-proj-name").text(pname);
		$("#modal-proj-api #modal-proj-id").text(pid);
		$('#modal-proj-api').modal('show')
	});
});
