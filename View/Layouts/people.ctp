<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- APP . 'Controller' . DS . 'Component' -->
        <script type="text/javascript">
                var APP = "/<?php echo APP_DIR; ?>";
        </script>
        <?php echo $this->Html->script('/idbroker/js/jquery-1.6.1.min')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jgrowl/jquery.jgrowl_compressed')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jstree/jquery.jstree')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jqueryUI/js/jquery-ui-1.8.14.custom.min')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/idbroker')."\n"; ?>
        <?php echo $this->Html->script('/idbroker/js/jquery.tools.min')."\n"; ?>
        <?php echo $this->Html->css('/idbroker/css/browser.css')."\n"; ?>
        <?php echo $this->Html->css('/idbroker/js/jgrowl/jquery.jgrowl')."\n"; ?>
        <?php echo $this->Html->css('/idbroker/js/jqueryUI/css/ui-lightness/jquery-ui-1.8.14.custom')."\n"; ?>


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
	 var editUrl = APP+'/idbroker/people/edit/'+dn;
	 $('#dndisplay').html(geturl(editUrl));
	 getMsg();
	}
	function getMsg(){
		var msgURL = APP+'/idbroker/users/getMsg';
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
