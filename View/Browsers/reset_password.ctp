<div id="resetPassword">
<script>
	function passwdSent(){
		getMsg();
		tb_remove();
	}
</script>

<?php
        $user = $this->request->data['Browser'];
	echo $this->Ajax->form('resetPassword','post',array('model'=>'Browser', 'url'=> array( 'action'=>'resetPassword/'.$user['dn'], 'controller'=>'browsers'),'complete'=>'passwdSent();'));

	echo $this->Form->input('dn', array('type'=>'hidden'));
        echo $this->Form->input('password', array('label'=>'Password', 'type'=>'password'));
        echo $this->Form->input('password_confirm', array('label'=>'Re-Type Password', 'type'=>'password'));
        echo $this->Form->end('Set');

?>
</div>
