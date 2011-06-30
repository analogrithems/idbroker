<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo h($title_for_layout) ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>idBroker - LDAP Browser</title>

        <script type="text/javascript">
                var APP = "/<?php echo APP_DIR; ?>";
        </script> 
        <?php echo $this->Html->script('/idbroker/js/jquery-1.6.1.min')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jgrowl/jquery.jgrowl_compressed')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jstree/jquery.jstree')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jqueryUI/js/jquery-ui-1.8.14.custom.min')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/idbroker')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jquery.tools.min')."\n"; ?>
        <?php echo $html->css('/idbroker/css/browser.css')."\n"; ?>
        <?php echo $html->css('/idbroker/js/jgrowl/jquery.jgrowl')."\n"; ?>
        <?php echo $html->css('/idbroker/js/jqueryUI/css/smoothness/jquery-ui-1.8.14.custom')."\n"; ?>
 
  </script>

</head>
<body>
<div id="container">
                <div id="MyAccount"><?php echo $html->link("MyAccount", '/idbroker/people/MyAccount', array('class'=>'button')); ?></div>
                <div id="Logout"><?php echo $html->link("Logout", '/idbroker/ldap_auths/logout', array('class'=>'button'));?></div>
        <?php echo $content_for_layout ?>

		<div id="popupMenu"></div>
</div>
                <div id="footer">
                        <?php
                                echo $html->link('IDBroker', 'http://analogrithems.com/rant/idbroker', array('target'=>'_blank'), null, false );
                        ?>
                </div>
	<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
