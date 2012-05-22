<div id="person">
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
        echo $this->Form->input('dn', array('type'=>'hidden'));
        echo $this->Form->input('cn', array('label'=>'Display Name','div'=>'required'));
        echo $this->Form->input('sn', array('label'=>'Last Name', 'div'=>'required'));
        echo $this->Form->input('description');
        echo $this->Form->end('Update');
?>
</div>