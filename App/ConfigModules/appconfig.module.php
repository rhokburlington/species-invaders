<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of appconfig
 *
 * @author smarkoski
 */
class appconfig implements ConfigModule {
    
    public function __construct() {
        $this->selfname = get_class($this);
    }
    
    
    public function readConfig() {
//        $filename = '../../../sr_configuration.xml';
        $filename = 'sr_configuration.xml';
        $fp = fopen($filename, 'r');
        $xmlstr = fread($fp, filesize($filename));
        fclose($fp);
        $sxml = new SimpleXMLElement($xmlstr);
        
        $this->databaseConfig($sxml);
        $this->valuesConfig($sxml);
        $this->alertTypesConfig($sxml);
    }
    
    private function databaseConfig($sxml) {
        foreach ($sxml->{$this->selfname}->database as $db) {
            Configuration::write('db_host', (string)$db->host);
            Configuration::write('db_name', (string)$db->databasename);
            Configuration::write('db_username', (string)$db->username);
            Configuration::write('db_password', (string)$db->password);
        }
    }

    private function valuesConfig($sxml) {
        foreach ($sxml->{$this->selfname}->values->value as $value) {
            Configuration::write((string)$value['name'], (string)$value);
        }
    }
    
    private function alertTypesConfig($sxml) {
        foreach ($sxml->{$this->selfname}->alertTypes->value as $value) {
            Configuration::write((string)$value['name'], (string)$value);
        }
    }
    
}

?>
