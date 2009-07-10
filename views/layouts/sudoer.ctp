<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- COMPONENTS -->
	<?php echo $javascript->link('/js/jquery.js')."\n"; ?>
	<?php echo $javascript->link('/js/jquery.form.js')."\n"; ?>
	<?php echo $javascript->link('/js/jquery.tooltip.js')."\n"; ?>
	<?php echo $javascript->link('/js/jquery.jgrowl_minimized.js')."\n"; ?>
	<?php echo $javascript->link('/js/thickbox.js')."\n"; ?>
	<?php echo $html->css('/css/jquery.jgrowl.css')."\n"; ?>
	<?php echo $html->css('/css/thickbox.css')."\n"; ?>
	<?php echo $html->css('/css/browser.css')."\n"; ?>
	<?php echo $html->css('/css/jquery.tooltip.css')."\n"; ?>
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
