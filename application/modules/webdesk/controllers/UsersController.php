<?php

class Webdesk_UsersController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $config = new Zend_Config_Ini('../application/configs/application.ini', 'production');
        $options = $config->ldap->toArray();


        foreach ($options as $ad) {
            $fields = array('displayname', 'mail', 'samaccountname');
            $ldap = new Zend_Ldap($ad);

            //Pega PCS
            //$users = $ldap->search('(objectClass=computer)', '' . $ad['baseDn'] . ' ', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);
            //Pega Users
            //$users = $ldap->search('(&(objectClass=user)(objectCategory=person))', ' ,OU=Fazenda,  ' . $ad['baseDn'] . ' ', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);
            //GET OU
            $ouDomain = $ldap->search('(objectCategory=organizationalUnit)', '' . $ad['baseDn'] . ' ', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);
            
            foreach ($ouDomain as $ou) {
                $exOu = explode(",", $ou['dn']);
                //exclude OU lists
                $excludeOU = array('OU=Computadores', 'OU=Compudores', 'OU=Grupos', 'OU=Usuarios', 'OU=Domain Controllers', 'OU=Fazenda', 'OU=Usuarios');

                if (!in_array($exOu[0], $excludeOU)) {
                    echo '<strong>' . $exOu[0] . "</strong><br/>";
                    $users = $ldap->search('(&(objectClass=user)(objectCategory=person))', ' ' . $exOu[0] . ',OU=Fazenda,' . $ad['baseDn'] . '', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);
                    foreach ($users as $user) {
                        echo 'Nome Usuario: '. $user['displayname'][0] . '<br/>';
                        echo 'Email: '. @$user['mail'][0] . '<br/>';
                        echo 'Login: '. $user['samaccountname'][0] . '<br/>';
                        echo "<hr size='1px'>";
                    }

                    echo '<br/>';
                }
            }
        }
    }

}

