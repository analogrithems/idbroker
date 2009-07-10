<style type="text/css">

#memberUidSelectBox {
    clear: none;
    text-align: center;
    margin: 10px;
    white-space: nowrap;
}

</style>

<?php
        $attr = 'memberuid';
        $memberid = substr($this->name,0,-1).ucwords($attr);

        echo $ajax->form(array('type' => 'post',
            'options' => array(
                'model'=>'PosixgroupSchema',
                'update'=>'posixgroup',
		'before'=>'select'.$memberid.'();',
                'url' => array(
                    'controller' => 'PosixgroupSchemas',
                    'action' => 'edit'
                 )
                )
        ));

        echo $form->input('dn', array('type'=>'hidden'));

        echo $form->input('cn', array('label'=> 'Name', 'div'=> 'required', 'title'=>'A single word name for the description.'));

        echo $form->input('description', array('title'=>'Provides a human-readable description of the purpose of this group.'));

        echo $form->input('gidnumber', array('label'=>'Group ID Number', 'div'=> 'required',  'title'=>'Unix Style Group ID Number.'));
?>
<div id="memberUidSelectBox"><?php


	$attr = 'memberuid';
        $model = 'PosixgroupSchema';
        $nonmemberid = $model.'Non'.$attr;
        $memberid = $model.ucwords($attr);


        $members = $groups['members'];
        $nonmembers = $groups['nonmembers'];
?>
        <script type="text/javascript">

                $().ready(function() {
                        $('#<?php echo $attr;?>add').click(function() {
                                return !$('#<?php echo $nonmemberid;?> option:selected').remove().appendTo('#<?php echo $memberid;?>');
                        });
                        $('#<?php echo $attr;?>remove').click(function() {
                                return !$('#<?php echo $memberid;?> option:selected').remove().appendTo('#<?php echo $nonmemberid;?>');
                        });
                });
                function select<?php echo $memberid;?>(){
                        $("#<?php echo $memberid;?>").each(function(){
                                $("#<?php echo $memberid;?> option").attr("selected","selected");
                        }) ;
                        return true;
                }
        </script>

        <style type="text/css">
                div.memberSelect{
                        display: inline;
                        clear: none;
                        float: left;
                }

                select#<?php echo $nonmemberid;?>, select#<?php echo $memberid;?> {
                        width: 250px;
                        height: 250px;
                }
        </style>
        <div class="memberSelect">
                <?php echo $form->input($model.'.non'.$attr, array( 'type' => 'select', 'multiple' => 'true', 'label' => 'Non-Members', 'options'=>$nonmembers)); ?>
                <a href="#" id="<?php echo $attr;?>add">add &gt;&gt;</a>
        </div>
        <div class="memberSelect">
                <?php echo $form->input($model.'.'.$attr, array( 'type' => 'select', 'multiple' => 'true', 'label' => 'Members', 'options'=>$members)); ?>
                <a href="#" id="<?php echo $attr;?>remove">&lt;&lt; remove</a>
        </div>
</div>
<?php
        echo $form->end('Update');
?>
