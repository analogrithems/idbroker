<?php
	$config['settings']['auto']['uidnumber']['0'] = '/posix/PosixaccountSchema/findUniqueUidNumber';
	$config['settings']['auto']['gidnumber']['0'] = '/posix/PosixgroupSchema/findUniqueGidNumber';
	$config['settings']['sync']['uniquemember']['0']['/posix/PosixgroupSchema/syncGroup']['0'] = 'dn';
	$config['settings']['PosixSetting']['uidnumbermin'] = '1000';
	$config['settings']['PosixSetting']['uidnumbermax'] = '20000';
	$config['settings']['PosixSetting']['gidnumbermin'] = '1000';
	$config['settings']['PosixSetting']['gidnumbermax'] = '6000';

?>