<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- COMPONENTS -->
	<?php echo $javascript->link('/js/jquery.js')."\n"; ?>
	<?php echo $javascript->link('/js/jquery-ui.min.js')."\n"; ?>
	<?php echo $javascript->link('/js/jquery.tooltip.js')."\n"; ?>
	<?php echo $javascript->link('/js/jquery.jgrowl_minimized.js')."\n"; ?>
	<?php echo $javascript->link('/js/thickbox.js')."\n"; ?>
	<?php echo $html->css('/css/jquery.jgrowl.css')."\n"; ?>
	<?php echo $html->css('/css/jquery/ui.all.css')."\n"; ?>
	<?php echo $html->css('/css/people.css')."\n"; ?>
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
	function changediv(dn) {
	 var editUrl = '<?php echo $html->url('/peoples/edit/'); ?>'+dn;
	 $('#dndisplay').html(geturl(editUrl));
	 getMsg();
	}
	function getMsg(){
		var msgURL = '<?php echo $html->url('/users/getMsg'); ?>';
		var result = geturl(msgURL);
		if(result == false){
			return false;
		}else{
			$.jGrowl(result);
			return true;
		}
	}
	$(function() {
		getMsg();
		$("#accordion").accordion({
			icons: {
    			header: "ui-icon-circle-arrow-e",
   				headerSelected: "ui-icon-circle-arrow-s"
			}
		});
	});

</script>
</head>
<body>
	<div id='peopleContainer'>
	<?php echo $content_for_layout ?>
	</div>
</body>
</html>
