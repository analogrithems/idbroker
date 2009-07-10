<script type="text/javascript">

	$().ready(function() {
		var groupDN = '<?php echo $this->data['Browser']['dn'];?>';
		var gUrl = '<?php echo $html->url('/browsers/groupSelect/');?>'+groupDN+'/groupofuniquenames';;
		$('#uniqueMemberSelectBox').html(geturl(gUrl));

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
	$attr = 'uniquemember';
        $memberid = substr($this->name,0,-1).ucwords($attr);


	echo "<div id='$objectclass'>";
	echo $ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay', 'before'=>'select'.$memberid.'();'));
	echo $form->input('dn', array('type'=>'hidden'));

	echo $form->input('cn', array('label'=> 'Name', 'div'=>'required', 'title'=>'A single word name for the description.'));

	echo $form->input('description', array('title'=>'Provides a human-readable description of the purpose of this group.'));
?>
<div id="uniqueMemberSelectBox"></div>
<?php
	echo $form->end('Update');
                echo "</div>";
?>
