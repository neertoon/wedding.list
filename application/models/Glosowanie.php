<?php
class Glosowanie extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function glosuj(ElementMuzyczny $elementMuzyczny, $params) {
        /** @var Glosowania $glosowania */
        $glosowania = $this->load->getModel('Glosowania');
        
        if (!in_array($params['rodzaj'], array($glosowania->rodzajZa(), $glosowania->rodzajPrzeciw()))) {
            throw new Exception("Niewłaściwy rodzaj głosowania");
        }
        
        /** @var GlosowaniaCollection $glosowanieCollection */
        $glosowanieCollection  = $this->load->getModel('GlosowaniaCollection');
        if ($glosowanieCollection->czyZaglosowano($elementMuzyczny, $params)) {
            throw new Exception("Już zagłosowałeś na ten utwór");
        }
        
        $glosowania->rodzaj = $params['rodzaj'];
        $glosowania->id_element_muzyczny = $elementMuzyczny->id_serial;
        $glosowania->dodajacy = $params['dodajacy'];
        $glosowania->web_browser = $_SERVER['HTTP_USER_AGENT'];
        $glosowania->zapisz();
    }
}