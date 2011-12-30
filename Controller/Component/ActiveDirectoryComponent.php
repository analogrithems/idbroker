<?php
class ActiveDirectoryComponent extends Component {
	//Functions 
	//Parse UserAccountControl Flgs to more human understandable form... 
	function parseUACF($uacf) { 
	    //All flags array 
	    $flags = array(    "TRUSTED_TO_AUTH_FOR_DELEGATION"=>    16777216, 
			    "PASSWORD_EXPIRED"                =>    8388608, 
			    "DONT_REQ_PREAUTH"                =>    4194304, 
			    "USE_DES_KEY_ONLY"                =>    2097152, 
			    "NOT_DELEGATED"                    =>    1048576, 
			    "TRUSTED_FOR_DELEGATION"        =>    524288, 
			    "SMARTCARD_REQUIRED"            =>    262144, 
			    "MNS_LOGON_ACCOUNT"                =>    131072, 
			    "DONT_EXPIRE_PASSWORD"            =>    65536, 
			    "SERVER_TRUST_ACCOUNT"            =>    8192, 
			    "WORKSTATION_TRUST_ACCOUNT"        =>    4096, 
			    "INTERDOMAIN_TRUST_ACCOUNT"        =>    2048, 
			    "NORMAL_ACCOUNT"                =>    512, 
			    "TEMP_DUPLICATE_ACCOUNT"        =>    256, 
			    "ENCRYPTED_TEXT_PWD_ALLOWED"    =>    128, 
			    "PASSWD_CANT_CHANGE"            =>    64, 
			    "PASSWD_NOTREQD"                =>    32, 
			    "LOCKOUT"                        =>    16, 
			    "HOMEDIR_REQUIRED"                =>    8, 
			    "ACCOUNTDISABLE"                =>    2, 
			    "SCRIPT"                         =>     1); 

	    //Parse flags to text 
	    $retval = array(); 
	    while (list($flag, $val) = each($flags)) { 
		if ($uacf >= $val) { 
		    $uacf -= $val; 
		    $retval[$flag] = true;
		} 
	    } 
	     
	    //Return human friendly flags 
	    return($retval); 
	} 

	//parse SamAccountType value to text 
	function parseSAT($samtype) { 
	    $stypes = array(    805306368    =>    "NORMAL_ACCOUNT", 
				805306369    =>    "WORKSTATION_TRUST", 
				805306370    =>    "INTERDOMAIN_TRUST", 
				268435456    =>    "SECURITY_GLOBAL_GROUP", 
				268435457    =>    "DISTRIBUTION_GROUP", 
				536870912    =>    "SECURITY_LOCAL_GROUP", 
				536870913    =>    "DISTRIBUTION_LOCAL_GROUP"); 
	     
	    $retval = ""; 
	    while (list($sat, $val) = each($stypes)) { 
		if ($samtype == $sat) { 
		    $retval = $val; 
		    break; 
		} 
	    } 
	    if (empty($retval)) $retval = "UNKNOWN_TYPE_" . $samtype; 
	     
	    return($retval); 
	} 

	//Parse GroupType value to text 
	function parseGT($grouptype) { 
	    $gtypes = array(    -2147483643    =>    "SECURITY_BUILTIN_LOCAL_GROUP", 
				-2147483644    =>    "SECURITY_DOMAIN_LOCAL_GROUP", 
				-2147483646    =>    "SECURITY_GLOBAL_GROUP", 
				2            =>    "DISTRIBUTION_GLOBAL_GROUP", 
				4            =>    "DISTRIBUTION_DOMAIN_LOCAL_GROUP", 
				8            =>    "DISTRIBUTION_UNIVERSAL_GROUP"); 

	    $retval = ""; 
	    while (list($gt, $val) = each($gtypes)) { 
		if ($grouptype == $gt) { 
		    $retval = $val; 
		    break; 
		} 
	    } 
	    if (empty($retval)) $retval = "UNKNOWN_TYPE_" . $grouptype; 

	    return($retval); 
	} 

	function getObjectSid($adConn, $dn, $distname) { 
	    //Select which attributes wa want 
	    $attrs = array("objectsid"); 

	    //Filter creation 
	    $filter = "distinguishedname=" . addslashes($distname); 

	    //Do the seacrh! 
	    $search = ldap_search($adConn, $dn, $filter, $attrs) or die("**** happens, no connection!"); 

	    $entry = ldap_first_entry($adConn, $search); 
	    $vals = ldap_get_values_len($adConn, $entry, "objectsid"); 
	    return(bin2hex($vals[0])); 
	} 
}
?>
