<?php
class Person extends AppModel {

        var $name = 'Person';

        var $useDbConfig = 'ldap';

        // This would be the ldap equivalent to a primary key if your dn is
        // in the format of uid=username, ou=people, dc=example, dc=com
        var $primaryKey = 'uid';

        // The table would be the branch of your basedn that you defined in
        // the database config
        var $useTable = 'ou=people';

        var $validate = array(
                'cn' => array(
                        'alphaNumeric' => array(
                                'rule' => array('custom', '/^[a-zA-Z ]+$/'),
                                'required' => true,
                                'on' => 'create',
                                'message' => 'Only Letters, Numbers and spaces	 can be used for Display Name.'
                        ),
                        'between' => array(
                                'rule' => array('between', 5, 40),
                                'on' => 'create',
                                'message' => 'Between 5 to 40 characters'
                        )
                ),
                'sn' => array(
                                'rule' => array('custom', '/^[a-zA-Z]*$/'),
                                'required' => true,
                                'on' => 'create',
                                'message' => 'Only Letters and Numbers can be used for Last Name.'
                ),
                'userpassword' => array(
                                'rule' => array('minLength', '8'),
                                'message' => 'Mimimum 8 characters long.'
                ),
                'uid' => array(
                                'rule' => array('custom', '/^[a-zA-Z0-9]*$/'),
                                'required' => true,
                                'on' => 'create',
                                'message' => 'Only Letters and Numbers can be used for Username.'
                )
        );


}
?>
