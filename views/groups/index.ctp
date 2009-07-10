<?php echo $html->css('style');?>


<div id="cabledbManage">
	<ul id="tabmenu">
		<?php echo $this->element('userMenu');?>
	</ul>
<?php
/*
	<ul id="tabmenu">
		<li> <?php echo $html->link('My Profile', '/users/myprofile', array('class'=>'active')); ?>
		<li> <?php echo $html->link('Cables',  '/cables/index', array('class'=>'button')); ?>
		<li> <?php echo $html->link('System',  '/systems/index', array('class'=>'button')); ?>
                <li> <?php echo $html->link('Subsystem',  '/subsystems/index', array('class'=>'button')); ?>
		<li> <?php echo $html->link('Types',   '/types/index', array('class'=>'button')); ?>
	</ul>
*/
?>


	<div id="UserPaging" class="Paging">
		<?php echo $this->element('users/myprofile');?>
	</div>
<div>
