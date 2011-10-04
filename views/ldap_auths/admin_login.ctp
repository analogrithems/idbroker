<h2>Login</h2>
<?php
echo $form->create('LdapAuth', array('action' => 'login'));
echo $form->input('username');
echo $form->input('password');
echo $form->end('Login');
?>
