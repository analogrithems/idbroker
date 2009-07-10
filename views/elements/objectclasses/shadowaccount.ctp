<?php echo $javascript->link('/js/jquery.phpdate.js')."\n"; ?>
  <script type="text/javascript">

  function getint(v) {
    if (v<0) {
        return(Math.ceil(v));
    } else {
        return(Math.floor(v));
    }
  }

  function getEpochDay(v){
	var cEpoch = $.PHPDate("U", new Date(v));
	return getint(cEpoch / 86400);
  }

  function getRealDate(v){
	var cEpoch = v * 86400;
	return $.PHPDate("m/d/Y", new Date(cEpoch));
  }


  $(document).ready(function(){
    $("#BrowserShadowexpire").datepicker({
	onSelect: function(dateText, inst) {
		        var cEpoch = $.PHPDate("U", new Date(dateText));
			var epochDay = getint(cEpoch / 86400);
			return epochDay;
		  }
    });

    $("#BrowserShadowlastchange").datepicker({
	onSelect: function(dateText, inst) {
		        var cEpoch = $.PHPDate("U", new Date(dateText));
			var epochDay = getint(cEpoch / 86400);
			return epochDay;
		  }
    });
  });
  </script>
<?php
	echo "<div id='$objectclass'>";
	echo $ajax->form('edit','post',array('model'=>substr($this->name,0,-1), 'update'=>'dndisplay'));
	echo $form->input('dn', array('type'=>'hidden'));


	if(isset($this->data['Browser']['shadowexpire']) && !empty($this->data['Browser']['shadowexpire'])){
		$expdate = date("m/d/Y", 86400 * $this->data['Browser']['shadowexpire']);
	}
	echo $form->input('shadowexpire', array('label'=>'Password Expire Date', 'value'=>$expdate, 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute contains an absolute date specifying when the login may no longer be used.'));

	echo $form->input('shadowinactive', array('label'=>'Days Inactive', 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies the number of days of inacitivity allowed for the specified user.'));

	if(isset($this->data['Browser']['shadowlastchange']) && !empty($this->data['Browser']['shadowlastchange'])){
		$lastdate = date("m/d/Y", 86400 * $this->data['Browser']['shadowlastchange']);
	}
	echo $form->input('shadowlastchange', array('label'=>'Password Last Changed', 'value'=>$lastdate, 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies number of days between January 1, 1970, and the date that the password was last modified.'));

	echo $form->input('shadowmax', array('label'=>'Max Days Till Change', 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies the maximum number of days the password is valid.'));

	echo $form->input('shadowmin', array('label'=>'Min Days Till Change', 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies the minimum number of days required between password changes.'));

	echo $form->input('shadowwarning', array('label'=>'Days Before Warn', 'title'=>'UNIX systems only. Related to the /etc/shadow file, this attribute specifies the number of days before the password expires that the user is warned.'));

	echo $form->end('Update');
                echo "</div>";
?>
