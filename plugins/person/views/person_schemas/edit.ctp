<?php
        echo $ajax->form(array('type' => 'post',
            'options' => array(
                'model'=>'PersonSchema',
                'update'=>'person',
                'url' => array(
                    'controller' => 'PersonSchemas',
                    'action' => 'edit'
                 )
                )
        ));
        echo $form->input('dn', array('type'=>'hidden'));
        echo $form->input('cn', array('label'=>'Display Name','div'=>'required'));
        echo $form->input('sn', array('label'=>'Last Name', 'div'=>'required'));
        echo $form->input('description');
        echo $form->end('Update');
?>
