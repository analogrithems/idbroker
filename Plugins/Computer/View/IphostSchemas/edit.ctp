<div id="iphost">
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

        echo $this->Form->input('dn', array('type'=>'hidden'));

        echo $this->Form->input('iphostnumber', array('label'=>'IP Address', 'div'=>'required', 'title'=>'The IP address of this host'));

        echo $this->Form->end('Update');
?>
</div>