<?php if ($this->Session->check('Message.flash.message')){ ?>
<script>
	$(function() {
		$.jGrowl( "<?php echo $this->Session->read('Message.flash.message');?>",
		{
			life: 2000,
			sticky: false,
			header: '<?php echo $header;?>',
			theme: '<?php echo $message_class;?>'
		});
	});
</script>
<?php 
$this->Session->del('Message.flash.message');
}?>