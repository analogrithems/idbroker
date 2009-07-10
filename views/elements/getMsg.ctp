<?php if ($session->check('Message.flash.message')){ ?>
<script>
	$(function() {
		$.jGrowl( "<?php echo $session->read('Message.flash.message');?>",
		{
			life: 2000,
			sticky: false,
			header: '<?php echo $header;?>',
			theme: '<?php echo $message_class;?>'
		});
	});
</script>
<?php 
$session->del('Message.flash.message');
}?>