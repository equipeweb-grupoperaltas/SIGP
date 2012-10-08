<?php

/**
 * 01/10/2012
 * @file           DepartamentosAd.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 01/10/2012
 * @version        Release: 1.0
 */
class Application_Model_DepartamentosAd {

    /**
     *
     * @var type 
     */
    private $departaments = array("" => "Selecione o departamento");

    
    /**
     * get all departments and exlude
     * @return type 
     */
    public function getDepartaments() {
        //get Config File 
        $config = new Zend_Config_Ini('../application/configs/application.ini', 'production');
        $options = $config->ldap->toArray();
        foreach ($options as $ad) {
            $fields = array('displayname', 'mail', 'samaccountname');
            $ldap = new Zend_Ldap($ad);
            $ouDomain = $ldap->search('(objectCategory=organizationalUnit)', '' . $ad['baseDn'] . ' ', Zend_Ldap::SEARCH_SCOPE_SUB, $fields);
            foreach ($ouDomain as $ou) {
                $exOu = explode(",", $ou['dn']);
                //exclude OU lists
                $excludeOU = array('OU=Computadores','OU=Fortigate', 'OU=Compudores','OU=Proxy', 'OU=Grupos', 'OU=Usuarios', 'OU=Domain Controllers', 'OU=Fazenda', 'OU=Usuarios');
                if (!in_array($exOu[0], $excludeOU)) {
                   $value = strtolower(str_replace("OU=", "", $exOu[0]));
                   $descriptrion = str_replace("OU=", "", $exOu[0]);
                   
                   $this->departaments[$value] = $descriptrion;
                    //echo '<strong>' . $exOu[0] . "</strong><br/>";
                }
            }
            
            return $this->departaments;
        }
    }

}

