<script type="text/javascript">

        $().ready(function() {
                var sudoDN = '<?php echo $this->data['Browser']['dn'];?>';
                var gUrl = '<?php echo $html->url('/browsers/sudoSelect/');?>'+sudoDN;
                $('#sudoSelectBox').html(geturl(gUrl));

        });
</script>

<style type="text/css">

#uniqueMemberSelectBox {
        clear: none;
        text-align: center;
        margin: 10px;
        white-space: nowrap;
}
</style>

<?php
	echo "<div id='$objectclass'>";
	echo $ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay', 'before'=>'submitSelected();'));
	echo $form->input('dn', array('type'=>'hidden'));

	echo $form->input('cn', array('label'=> 'Name', 'div'=>'required', 'title'=>'A single word name for the description.'));

	echo $form->input('description', array('title'=>'Provides a human-readable description of the Sudo Role. For example: These users can reset passwords for other people.'));

	echo $form->input('sudocommand', array('label'=>'Command', 'title'=>'The command that people in this sudo role can run.  For example: /usr/bin/passwd or ALL for all commands'));


	echo $form->input('sudorunasuser', array('label'=> 'Run As User', 'title'=>'A user name or uid (prefixed with \'#\') that commands may be run as or a Unix group (prefixed with a \'%\') or user netgroup (prefixed with a \'+\') that contains a list of users that commands may be run as. The special value ALL will match any user.'));


?>
<div id="sudoSelectBox"></div>
<?php


	echo $form->end('Update');
                echo "</div>";
?>
