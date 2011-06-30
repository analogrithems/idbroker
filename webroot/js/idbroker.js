
$(function (){
	function changediv(dn) {
	 var editUrl = escape(APP+'/idbroker/browsers/edit/'+dn);
	 $('#dndisplay').load(editUrl);
	 getMsg();
	}
	function getMsg(){
		var addr = APP+'/idbroker/browsers/getMsg';
		$.ajax({
		type: 'POST', 
		url: addr, 
		complete :
		      function(data, textStatus, jqXHR) {
			var msg = data.responseText
			if(msg != '0'){
				$.jGrowl(msg);
				return true;
			}
		      }
		});
	}
	var idbroker = $("#myldap").jstree({
		"plugins" 	: [ 'core', 'themeroller', 'ui', 'json_data', 'contextmenu' ],
		"json_data"	: {
			"ajax"	: {
				"type"	: "post",
				"url"	: "/APS/idbroker/browsers/getnodes/",
				dataType: "json",
				"async"	: true,
				"data" : function (n) { 
					var dn = $(n).data('id');
					return {
						"node" : dn
					};
                                } 
			},
		},
		"themes"	: {
			"theme"	:  "default",
			"dots"	:  true,
			"icons"	:  true
		},
		"contextmenu"	: {
			"show_at_node" : true,
			"items" : function (n) {
				var dn = $(n).data('id');
				var default_obj = { "ccp":false, "remove":false, "rename":false, "create":false,
                                   "restPassword" : {
                                        "label"   : "Set Password",
                                        "icon"    : "ui-icon ui-icon-key",
                                        "action"  : function () {
							var user = dn;
							if(user){
								var url = APP+'/idbroker/browsers/resetPassword/'+user;
								showModal(url,'Reset Password');
								return false;
							}else{
								alert('You must select object!');
							}
                                                }
                                        },
					"adduser" :	{
                                                "label"   : "Add User",
                                                "icon"    : "ui-icon ui-icon-person",
                                                "action"  : function () {
								return showModal(APP+'/idbroker/people/add/','Add User');
                                                }
                                        },
                                        "addgroup": {
                                                "label"   : "Add Group",
                                                "icon"    : "ui-icon ui-icon-copy",
                                                "action"  : function () {
								showModal(APP+'/idbroker/groups/add/','Add Group');
								return false;
                                                }
                                        },
                                        "addcomputer" : {
                                                "label"   : "Add Computer",
                                                "icon"    : "ui-icon ui-icon-disk",
                                                "action"  : function () {
								showModal(APP+'/idbroker/computers/add/','Add Computer');
								return false;
                                                }
                                        },
                                        "addsudoers" :{
                                                "label"   : "Add Sudoer Role",
                                                "icon"    : "ui-icon ui-icon-gear",
                                                "action"  : function () {
								showModal(APP+'/idbroker/sudoers/add/','Create Sudo Role');
								return false;
                                                }
                                        },
                                        "refresh" : {
                                                "label"   : "Refresh",
                                                "icon"    : "ui-icon ui-icon-arrowrefresh-1-s",
                                                "action"  : function () {
                                                                //idbroker.refresh(n);
                                                }
                                        },
                                        "unlock" :{
                                                "label"   : "UnLock Account",
                                                "icon"    : "ui-icon ui-icon-unlocked",
                                                "action"  : function () {
                                                                //idbroker.refresh(n);
                                                                var dn = jQuery(n).data('id');
                                                                if(confirm("Are you sure you want to enable "+dn+"?")){
                                                                        //n.refresh(n.parent);
                                                                }
                                                }
                                        },
                                        "lock" : {
                                                "label"   : "Lock Account",
                                                "icon"    : "ui-icon ui-icon-locked",
                                                "action"  : function () {
                                                                //idbroker.refresh(n);
                                                                var dn = jQuery(n).data('id');
                                                                if(confirm("Are you sure you want to disable "+dn+"?")){
                                                                        //n.refresh(n.parent);
                                                                }
                                                }
                                        },
                                        "delete" : {
                                                "label"   : "Delete",
                                                "icon"    : "ui-icon ui-icon-trash",
                                                "action"  : function () {
                                                                var dn = jQuery(n).data('title');
                                                                if(confirm("Are you sure you want to delete "+dn+"?")){
                                                                        //n.refresh(n.parent);
                                                                }
                                                }
                                        }
				   };
				   if($(n).data('hasPassword') == 'true') default_obj.restPassword = false;
				   if($(n).data('lock') == 'true') default_obj.lock = false;
				   else default_obj.unlock = false;

				   return default_obj;
				},
                        },

	});
	$("#myldap").bind("select_node.jstree", function(e, data){
		dn = data.rslt.obj.data("id");
		changediv(dn);
	});
	
	//Show the tool Tips
	$('#Forms *').tooltip();

	function showModal(url, title){
		$("#popupMenu").dialog({
			modal : true,
			title : title,
			open  : function(){
					$("#popupMenu").load(url);
				}
		});
		return false;
	}

function passwordReset(user){
	if(user){
		var url = APP+'/idbroker/browsers/resetPassword/'+user;
		showModal(url,'Reset Password');
		return false;
	}else{
		alert('You must select object!');
	}
}

});
