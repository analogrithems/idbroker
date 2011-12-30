<h2>Login</h2>
<?php
echo $this->Form->create('LdapAuth', array('action' => 'login'));
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Login');
?>
