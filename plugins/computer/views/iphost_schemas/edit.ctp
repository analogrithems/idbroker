<?php
        echo $ajax->form(array('type' => 'post',
            'options' => array(
                'model'=>'IphostSchema',
                'update'=>'iphost',
                'url' => array(
                    'controller' => 'IphostSchemas',
                    'action' => 'edit'
                 )
                )
        ));

        echo $form->input('dn', array('type'=>'hidden'));

        echo $form->input('iphostnumber', array('label'=>'IP Address', 'div'=>'required', 'title'=>'The IP address of this host'));

        echo $form->end('Update');
?>
