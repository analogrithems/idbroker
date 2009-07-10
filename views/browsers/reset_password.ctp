<div id="resetPassword">
<script>
	function passwdSent(){
		getMsg();
		tb_remove();
	}
</script>

<?php
        $user = $this->data['Browser'];
	echo $ajax->form('resetPassword','post',array('model'=>'Browser', 'url'=> array( 'action'=>'resetPassword/'.$user['dn'], 'controller'=>'browsers'),'complete'=>'passwdSent();'));

	echo $form->input('dn', array('type'=>'hidden'));
        echo $form->input('password', array('label'=>'Password', 'type'=>'password'));
        echo $form->input('password_confirm', array('label'=>'Re-Type Password', 'type'=>'password'));
        echo $form->end('Set');

?>
</div>
