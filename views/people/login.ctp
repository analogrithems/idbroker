<h2>Login</h2>
<?php
echo $form->create('User', array('action' => 'login'));
echo $form->input('username');
echo $form->input('password');
echo $form->end('Login');
?>
