<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo h($title_for_layout) ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>idBroker - LDAP Browser</title>

        <?php echo $this->Html->script('/idbroker/js/jquery')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/_lib')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/tree_component')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jquery-ui.min')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jquery.form')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/lib/jquery.dimensions')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jquery.tooltip')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jquery.jgrowl_minimized')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/thickbox')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jquery.selectboxes')."\n"; ?>
        <?php echo $html->css('/idbroker/css/tree_component.css')."\n"; ?>
        <?php echo $html->css('/idbroker/css/jquery.tooltip.css')."\n"; ?>
        <?php echo $html->css('/idbroker/css/jquery/ui.all.css')."\n"; ?>
        <?php echo $html->css('/idbroker/css/browser.css')."\n"; ?>
        <?php echo $html->css('/idbroker/css/jquery.jgrowl.css')."\n"; ?>
        <?php echo $html->css('/idbroker/css/thickbox.css')."\n"; ?>
        <?php echo $html->css('/idbroker/img/themes/ldap/style.css')."\n"; ?>


  <!-- INITIALIZE -->
  <script type="text/javascript">
        function geturl(addr) {
         var r = $.ajax({
          type: 'POST',
          url: addr,
          async: false
         }).responseText;
         return r;
        }
        function changediv(dn) {
         var editUrl = '<?php echo $html->url('/idbroker/browsers/edit/'); ?>'+dn;
         $('#dndisplay').html(geturl(editUrl));
         getMsg();
        }
        function getMsg(){
                var addr = '<?php echo $html->url('/idbroker/browsers/getMsg'); ?>';
                $.ajax({type: 'POST', url: addr, success:
                      function(msg) {
                        if(msg != '0'){
                                $.jGrowl(msg);
                                return true;
                        }
                      }
                });
        }
        $(function() {
                $("#myldap").height($("sources").height() - 12);

                var tree1 = $.tree_create();

                tree1.init($("#myldap"), {
                        data  : {
                                type  : "json",
                                async : true,
                                async_data: function(NODE){ return { 'node' : jQuery(NODE).attr("id") || 0 } },
                                method: "post",
                                url   : "<?php echo $html->url('/idbroker/browsers/getnodes/') ?>"
                        },
                        ui              : {
                                theme_name : "ldap",
                                context : [
                                   {
                                        id      : "restPassword",
                                        label   : "Set Password",
                                        icon    : "rename.png",
                                        visible : function (NODE, TREE_OBJ) {
                                                        if(NODE.length != 1) return false;
                                                        var hasPassword = jQuery(NODE).attr("hasPassword");
                                                        if( hasPassword == 'true'){
                                                                return true;
                                                        }else{
                                                                return false;
                                                        }
                                                },
                                        action  : function (NODE, TREE_OBJ) {
                                                passwordReset(jQuery(NODE).attr("id"));
                                                }
                                        },
                                    "separator",
                                    {
                                                id      : "adduser",
                                                label   : "Add User",
                                                icon    : "user_add.png",
                                                visible : function (NODE, TREE_OBJ) {
                                                                if(NODE.length != 1) return false;
                                                                return true;
                                                        },
                                                action  : function (NODE, TREE_OBJ) {
                                                                adduser();
                                                }
                                        },
                                        {
                                                id      : "addgroup",
                                                label   : "Add Group",
                                                icon    : "group_add.png",
                                                visible : function (NODE, TREE_OBJ) {
                                                                if(NODE.length != 1) return false;
                                                                return true;
                                                        },
                                                action  : function (NODE, TREE_OBJ) {
                                                                addgroup();
                                                                TREE_OBJ.refresh();
                                                }
                                        },
                                        {
                                                id      : "addcomputer",
                                                label   : "Add Computer",
                                                icon    : "computer_add.png",
                                                visible : function (NODE, TREE_OBJ) {
                                                                if(NODE.length != 1) return false;
                                                                return true;
                                                        },
                                                action  : function (NODE, TREE_OBJ) {
                                                                addcomputer();
                                                }
                                        },
                                        {
                                                id      : "addsudoers",
                                                label   : "Add Sudoer Role",
                                                icon    : "key.png",
                                                visible : function (NODE, TREE_OBJ) {
                                                                if(NODE.length != 1) return false;
                                                                return true;
                                                        },
                                                action  : function (NODE, TREE_OBJ) {
                                                                addsudoer();
                                                }
                                        },
                                        {
                                                id      : "refresh",
                                                label   : "Refresh",
                                                icon    : "action_refresh.gif",
                                                visible : function (NODE, TREE_OBJ) {
                                                                if(NODE.length != 1) return false;
                                                                return true;
                                                        },
                                                action  : function (NODE, TREE_OBJ) {
                                                                TREE_OBJ.refresh(NODE);
                                                }
                                        },
                                    "separator",
                                        {
                                                id      : "unlock",
                                                label   : "UnLock Account",
                                                icon    : "unlock.png",
                                                visible : function (NODE, TREE_OBJ) {
                                                                if(NODE.length != 1) return false;
                                                                var lock = jQuery(NODE).attr("lock");
                                                                if( lock == 'true'){
                                                                        return true;
                                                                }else{
                                                                        return false;
                                                                }
                                                        },
                                                action  : function (NODE, TREE_OBJ) {
                                                                TREE_OBJ.refresh(NODE);
                                                                var dn = jQuery(NODE).attr("id");
                                                                var msgURL = '<?php echo $html->url('/idbroker/browsers/unLock'); ?>/'+dn;
                                                                if(confirm("Are you sure you want to enable "+dn+"?")){
                                                                        geturl(msgURL);
                                                                        getMsg()
                                                                        TREE_OBJ.refresh(NODE.parent);
                                                                }
                                                }
                                        },
                                        {
                                                id      : "lock",
                                                label   : "Lock Account",
                                                icon    : "icon_padlock.gif",
                                                visible : function (NODE, TREE_OBJ) {
                                                                if(NODE.length != 1) return false;
                                                                var lock = jQuery(NODE).attr("lock");
                                                                if( lock == 'true'){
                                                                        return false;
                                                                }else{
                                                                        return true;
                                                                }
                                                        },
                                                action  : function (NODE, TREE_OBJ) {
                                                                TREE_OBJ.refresh(NODE);
                                                                var dn = jQuery(NODE).attr("id");
                                                                var msgURL = '<?php echo $html->url('/idbroker/browsers/lock'); ?>/'+dn;
                                                                if(confirm("Are you sure you want to disable "+dn+"?")){
                                                                        geturl(msgURL);
                                                                        getMsg()
                                                                        TREE_OBJ.refresh(NODE.parent);
                                                                }
                                                }
                                        },
                                        {
                                                id      : "delete",
                                                label   : "Delete",
                                                icon    : "delete.png",
                                                visible : function (NODE, TREE_OBJ) {
                                                                if(NODE.length != 1) return false;
                                                                return true;
                                                        },
                                                action  : function (NODE, TREE_OBJ) {
                                                                TREE_OBJ.refresh(NODE);
                                                                var dn = jQuery(NODE).attr("id");
                                                                var msgURL = '<?php echo $html->url('/idbroker/browsers/delete'); ?>/'+dn;
                                                                if(confirm("Are you sure you want to delete "+dn+"?")){
                                                                        geturl(msgURL);
                                                                        getMsg()
                                                                        TREE_OBJ.refresh(NODE.parent);
                                                                }
                                                }
                                        },
                                ]
                        },
                        cookies : { prefix : "tree1", opts : { path : '/' } },

                        callback : {
                                onchange : function (NODE) {
                                      changediv(jQuery(NODE).attr("id"));
                                }
                        }
                });

                function adduser(){
                        imgLoader = new Image();// preload image
                        imgLoader.src = tb_pathToImage;
                        var t = 'Add User';
                        var a = '<?php echo $html->url('/idbroker/people/add/'); ?>?TB_iframe=true&height=500&width=350';
                        var g = false;
                        tb_show(t,a,g);
                        this.blur();
                        return false;
                }

                function addcomputer(){
                        imgLoader = new Image();// preload image
                        imgLoader.src = tb_pathToImage;
                        var t = 'Add Computer';
                        var a = '<?php echo $html->url('/idbroker/computers/add/'); ?>?TB_iframe=true&height=400&width=350';
                        var g = false;
                        tb_show(t,a,g);
                        this.blur();
                        return false;
                }
                function addgroup(){
                        imgLoader = new Image();// preload image
                        imgLoader.src = tb_pathToImage;
                        var t = 'Add Group';
                        var a = '<?php echo $html->url('/idbroker/groups/add/'); ?>?TB_iframe=true&height=400&width=350';
                        var g = false;
                        tb_show(t,a,g);
                        this.blur();
                        return false;
                }
                function addsudoer(){
                        imgLoader = new Image();// preload image
                        imgLoader.src = tb_pathToImage;
                        var t = 'Create Sudo Role';
                        var a = '<?php echo $html->url('/idbroker/sudoers/add/'); ?>?TB_iframe=true&height=600&width=350';
                        var g = false;
                        tb_show(t,a,g);
                        this.blur();
                        return false;
                }

                function passwordReset(user){
                        if(user){
                                imgLoader = new Image();// preload image
                                imgLoader.src = tb_pathToImage;
                                var t = 'Reset Password';
                                var a = '<?php echo $html->url('/idbroker/browsers/resetPassword/'); ?>'+user+'?TB_iframe=true&height=150&width=350';
                                var g = false;
                                tb_show(t,a,g);
                                this.blur();
                                return false;
                        }else{
                                alert('You must select object!');
                        }
                }

                $('#Forms *').tooltip();
		$('body').live('click', function(){
			getMsg();
		});
    });




  </script>

</head>
<body>
<div id="container">
                <div id="MyAccount"><?php echo $html->link("MyAccount", '/idbroker/people/MyAccount', array('class'=>'button')); ?></div>
                <div id="Logout"><?php echo $html->link("Logout", '/idbroker/ldap_auths/logout', array('class'=>'button'));?></div>
        <?php echo $content_for_layout ?>

</div>
                <div id="footer">
                        <?php
                                echo $html->link('IDBroker', 'http://analogrithems.com/rant/idbroker', array('target'=>'_blank'), null, false );
                        ?>
                </div>
	<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
