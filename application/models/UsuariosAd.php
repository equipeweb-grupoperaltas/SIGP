<?php

/**
 * 01/10/2012
 * @file           UsuariosAd.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 01/10/2012
 * @version        Release: 1.0
 */
class Application_Model_UsuariosAd {

    /**
     * 
     * @var type 
     */
    private $config;
    private $options;
    private $retUsers = array();
    private $user;

    /**
     * set configs and options 
     */
    public function __construct() {
        $this->config = new Zend_Config_Ini('../application/configs/application.ini', 'production');
        $this->options = $this->config->ldap->toArray();
    }

    /**
     * get all Users of Active Directory
     * @return type 
     */
    public function getAllUsers() {

        foreach ($this->options as $ad) {
            $fields = array('displayname', 'mail', 'samaccountname');
            $ldap = new Zend_Ldap($ad);
            $users = $ldap->search('(&(objectClass=user)(objectCategory=person))', 'OU=Fazenda,  ' . $ad['baseDn'] . ' ', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);

            foreach ($users as $user) {
                $value = $user['samaccountname'][0];
                $description = $user['displayname'][0];
                $this->retUsers[$value] = $description;
            }
        }

        return $this->retUsers;
    }

    /**
     * get users of department 
     * @param type $department
     * @return type 
     */
    public function getUsersOfDepartment($department) {
        foreach ($this->options as $ad) {
            $fields = array('displayname', 'mail', 'samaccountname');
            $ldap = new Zend_Ldap($ad);
            $users = $ldap->search('(&(objectClass=user)(objectCategory=person))', 'OU=' . $department . ',OU=Fazenda,' . $ad['baseDn'] . '', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);
            foreach ($users as $user) {
                $value = $user['samaccountname'][0];
                $description = $user['displayname'][0];

                $array = array();

                $array['optionValue'] = $value;
                $array['optionDisplay'] = $description;



                $this->retUsers[] = $array;
            }
        }
        return $this->retUsers;
    }

    /**
     * Get name User
     * @param type $user
     * @return type 
     */
    public function getUser($user) {
        foreach ($this->options as $ad) {
            $fields = array('displayname', 'mail', 'samaccountname');
            $ldap = new Zend_Ldap($ad);
            $users = $ldap->search('(&(objectClass=user)(samaccountname=' . $user . '))', 'OU=Fazenda,  ' . $ad['baseDn'] . ' ', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);

            foreach ($users as $user) {
                $description = $user['displayname'][0];
            }
        }

        return $description;
    }

    /**
     * GetUserData 
     * @param type $user
     */
    public function getUserData($userN) {
        
        foreach ($this->options as $ad) {
         $fields = array('displayname', 'mail', 'samaccountname','mobile');
            $ldap = new Zend_Ldap($ad);
            $users = $ldap->search('(&(objectClass=user)(samaccountname='.$userN.'))' , '' . $ad['baseDn'] . ' ', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);
            foreach ($users as $user) {
                $userR['displayname'] = $user['displayname'][0];
                $userR['mail'] = $user['mail'][0];
                $userR['mobile'] = $user['mobile'][0];
            }
         return $userR;
        
        }
    }
    
    
    

}

