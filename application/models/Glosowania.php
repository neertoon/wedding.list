<?php
class Glosowania extends CI_Model {
    private $_tabela;

    public $id_serial;
    public $ip;
    public $id_element_muzyczny;
    public $geo_inf;
    public $id_webstorage;
    public $dodajacy;
    public $rodzaj;
    public $tms;
    public $web_browser;
    
    public function __construct()
    {
        parent::__construct();
        $this->_tabela = 'glosowania';
    }

    public function rodzajZa() {
        return '+';
    }

    public function rodzajPrzeciw() {
        return '-';
    }

    public function zapisz() {
        $this->kontrolaPol();
        
        $this->ip = $_SERVER['REMOTE_ADDR'];
        
        $data = array();
        foreach ($this as $klucz => $wartosc) {
            if (substr($klucz, 0, 1) == '_') {
                continue;
            }
            
            if (empty($wartosc)) {
                continue;
            }
            
            $data[$klucz] = $wartosc;
        }
        
        $this->db->insert($this->_tabela, $data);
    }

    private function kontrolaPol()
    {
        if (empty($this->id_element_muzyczny)) {
            throw new Exception("Nie podano id elementu");
        }

        if (!is_numeric($this->id_element_muzyczny)) {
            throw new Exception("Niewłaściwy id elementu");
        }
    }
}