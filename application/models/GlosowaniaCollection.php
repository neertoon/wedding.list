<?php

class GlosowaniaCollection extends CI_Model {
    private $_tabela;
    public function __construct()
    {
        parent::__construct();
        $this->_tabela = 'glosowania';
    }
    
    public function czyZaglosowano(ElementMuzyczny $elementMuzyczny, $params) {
        $sel = "SELECT *
                FROM ".$this->_tabela."
                WHERE TRUE
                    AND id_element_muzyczny = ".$elementMuzyczny->id_serial."
                    AND web_browser = '".$_SERVER['HTTP_USER_AGENT']."'
                    AND ip = '".$_SERVER['REMOTE_ADDR']."'";
        log_message('error', $sel);
        $query = $this->db->query($sel);
        $result = $query->result();
        return count($result) > 0;
    }
}