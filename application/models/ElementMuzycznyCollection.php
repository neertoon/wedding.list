<?php
class ElementMuzycznyCollection extends CI_Model {
    private $_tabela;
    public function __construct()
    {
        parent::__construct();
        $this->_tabela = 'element_muzyczny';
    }
    
    public function dajElementWgId($id) {
        if (!is_numeric($id)) {
            throw new Exception("Niewłaściwy argument!");
        }
        $this->db->select('e.*');
        $this->db->from($this->_tabela.' AS e');
        $this->db->where("id_serial", $id);

        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            $this->load->model('ElementMuzyczny');
            /** @var ElementMuzyczny $element */
            $element = $this->ElementMuzyczny;
            foreach ($row as $key => $value) {
                $element->$key = $value;
            }
            return $element;
        }
    }

    public function dajWykonawcowWgNazwy($nazwa)
    {
        $this->load->model('Napisy');
        /** @var Napisy $napisyObj */
        $napisyObj = $this->Napisy;
        
        $nazwa = strtolower($nazwa) == strtolower($napisyObj->daj('szukaj')) ? '' : $nazwa;
        $this->load->model('ElementMuzyczny');
        /** @var ElementMuzyczny $element */
        $element = $this->ElementMuzyczny;

        /** @var Glosowania $glosowania */
        $glosowania = $this->load->getModel('Glosowania');
        
        

        $sel = "SELECT e.id_serial, e.nazwa AS nazwa
                  , sum(CASE WHEN g.rodzaj = '".$glosowania->rodzajZa()."' THEN 1 ELSE 0 END) AS _ile_za
                  , sum(CASE WHEN g.rodzaj = '".$glosowania->rodzajPrzeciw()."' THEN 1 ELSE 0 END) AS _ile_przeciw
                  , e.link_youtube
                FROM ".$this->_tabela." AS e
                    LEFT OUTER JOIN glosowania AS g ON g.id_element_muzyczny = e.id_serial 
                WHERE e.rodzaj = '".$element->getRodzajWykonawca()."'
                    ".$this->whereLikeInNazwa($nazwa)."
                GROUP BY e.id_serial, e.nazwa";
        $query = $this->db->query($sel);

        return $query;
    }

    public function dajUtworyWgNazwy($nazwa) {
        $this->load->model('Napisy');
        /** @var Napisy $napisyObj */
        $napisyObj = $this->Napisy;

        $nazwa = strtolower($nazwa) == strtolower($napisyObj->daj('szukaj')) ? '' : $nazwa;
        
        $this->load->model('ElementMuzyczny');
        /** @var ElementMuzyczny $element */
        $element = $this->ElementMuzyczny;

        /** @var Glosowania $glosowania */
        $glosowania = $this->load->getModel('Glosowania');

        $sel = "SELECT e.id_serial, e.nazwa AS nazwa
                  , sum(CASE WHEN g.rodzaj = '".$glosowania->rodzajZa()."' THEN 1 ELSE 0 END) AS _ile_za
                  , sum(CASE WHEN g.rodzaj = '".$glosowania->rodzajPrzeciw()."' THEN 1 ELSE 0 END) AS _ile_przeciw
                  , e.link_youtube
                FROM ".$this->_tabela." AS e
                    LEFT OUTER JOIN glosowania AS g ON g.id_element_muzyczny = e.id_serial 
                WHERE e.rodzaj = '".$element->getRodzajUtwor()."'
                    ".$this->whereLikeInNazwa($nazwa)."
                GROUP BY e.id_serial, e.nazwa
                ORDER BY sum(CASE WHEN g.rodzaj = '".$glosowania->rodzajZa()."' THEN 1 ELSE 0 END) DESC";
        $query = $this->db->query($sel);

        return $query;
    }
    
    public function dajUtworyMajaceLinkiYoutube() {
        $this->load->model('ElementMuzyczny');
        /** @var ElementMuzyczny $element */
        $element = $this->ElementMuzyczny;
        
        $sel = "SELECT e.id_serial, e.nazwa AS nazwa
                  , e.link_youtube
                FROM ".$this->_tabela." AS e
                WHERE e.rodzaj = '".$element->getRodzajUtwor()."'
                    AND COALESCE(e.link_youtube, '') != ''
                ORDER BY e.id_serial";
        $query = $this->db->query($sel);

        return $query;
    }

    private function dodajWhereLikeIn($pole, $tabSzukaj)
    {
        $whereLikeIn = array();
        
        foreach ($tabSzukaj as $czescSzukaj) {
            $czescSzukaj = strip_tags($czescSzukaj);
            $czescSzukaj = htmlentities($czescSzukaj, ENT_QUOTES);
            
            $whereLikeIn[] = "CONCAT(' ', ".$pole.", ' ') LIKE '% ".$czescSzukaj."%'";
        }
        
        return implode(" OR ", $whereLikeIn);
    }
    
    private function whereLikeInNazwa($nazwa) {
        $nazwaSzukaj = str_replace(array("-", "_"), ' ', $nazwa);
        $nazwaSzukaj = preg_replace('/[\s]+/', ' ', $nazwaSzukaj);
        $nazwaSzukaj = explode(" ", $nazwaSzukaj);
        
        $szukajPart = array();
        foreach ($nazwaSzukaj as &$czesc) {
            $czesc = trim($czesc);
            $czesc = strtolower($czesc);
            if (!empty($czesc)) {
                $szukajPart[] = $czesc;
            }
        }

        $whrNazwa = "";
        if (!empty($nazwa)) {
            $whrNazwa = "AND (".$this->dodajWhereLikeIn("lower(e.nazwa)", $szukajPart).")";
        }
        log_message('error', $whrNazwa);
        return $whrNazwa;
    }
}