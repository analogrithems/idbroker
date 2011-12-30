<script type="text/javascript">

	$().ready(function() {
		var groupDN = '<?php echo $this->request->data['Browser']['dn'];?>';
		var gUrl = '<?php echo $this->Html->url('/browsers/groupSelect/');?>'+groupDN+'/posixgroup';;
		$('#memberUidSelectBox').html(geturl(gUrl));

	});

</script>

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

	echo "<div id='$objectclass'>";
	echo $this->Ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay', 'before'=>'select'.$memberid.'();'));
	echo $this->Form->input('dn', array('type'=>'hidden'));

	echo $this->Form->input('cn', array('label'=> 'Name', 'div'=> 'required', 'title'=>'A single word name for the description.'));

	echo $this->Form->input('description', array('title'=>'Provides a human-readable description of the purpose of this group.'));

	echo $this->Form->input('gidnumber', array('label'=>'Group ID Number', 'div'=> 'required',  'title'=>'Unix Style Group ID Number.'));
?>
<div id="memberUidSelectBox"></div>
<?php
	echo $this->Form->end('Update');
                echo "</div>";
?>
