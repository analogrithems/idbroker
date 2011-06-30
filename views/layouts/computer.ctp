<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
        <?php echo $html->css('/idbroker/js/jqueryUI/css/ui-lightness/jquery-ui-1.8.14.custom')."\n"; ?>
 

	<script type="text/javascript">
	function geturl(addr) {
	 var r = $.ajax({
	  type: 'POST',
	  url: addr,
	  async: false
	 }).responseText;
	 return r;
	}
</script>
</head>
<body>
	<?php echo $content_for_layout ?>
</body>
</html>
