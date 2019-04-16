<?php
class ElementMuzyczny extends CI_Model {
    private $_tabela;
    
    public $id_serial;
    public $ip;
    public $nazwa;
    public $rodzaj;
    public $dodajacy;
    public $link_youtube;
    
    public function __construct()
    {
        parent::__construct();
        $this->_tabela = 'element_muzyczny';
    }
    
    public function getRodzajWykonawca() {
        return 'W';
    }
    
    public function getRodzajUtwor() {
        return 'U';
    }

    public function zapisz() {
        $this->load->model('Napisy');
        /** @var Napisy $napisyObj */
        $napisyObj = $this->Napisy;
        
        if (!empty($id)) {
            throw new Exception("Nie można zapisać utworzonego obiektu");
        }
        
        if (in_array(trim($this->dodajacy), array($napisyObj->daj('osoba'), ""))) {
            throw new Exception($napisyObj->daj('blad_brak_osoby'));
        }

        if (in_array(trim($this->nazwa), array($napisyObj->daj('szukaj'), ""))) {
            throw new Exception($napisyObj->daj('blad_blad_dodania'));
        }

        if (in_array(trim($this->link_youtube), array($napisyObj->daj('youtube_link'), ""))) {
            $this->link_youtube = '';
        }
        
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->formatujPola();
        
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
        
        if (!empty($this->link_youtube)) {
            $this->load->model('Youtube');
            /** @var Youtube $youtube */
            $youtube = $this->Youtube;
            $zawartoscPliku = '';
            $plik = 'youtube.log';
            if (file_exists($plik)) {
                $zawartoscPliku = file_get_contents($plik);
            }
            try {
                $link = $youtube->dajIdFilmu($this->link_youtube);
                $youtube->dodajFilmDoPlaylisty($link);
            } catch (Exception $e) {
                $zawartoscPliku .= date("Y-m-d ");
                $zawartoscPliku .= $e->getMessage();
                $zawartoscPliku .= "\r\n";
                file_put_contents($plik, $zawartoscPliku);
            }
        }
    }

    private function formatujPola()
    {
        $this->nazwa = strip_tags($this->nazwa);
        $this->nazwa = htmlentities($this->nazwa, ENT_QUOTES);

        $this->dodajacy = strip_tags($this->dodajacy);
        $this->dodajacy = htmlentities($this->dodajacy, ENT_QUOTES);

        $this->link_youtube = strip_tags($this->link_youtube);
        $this->link_youtube = trim(htmlentities($this->link_youtube, ENT_QUOTES));
        
        if (!preg_match('/https:\/\/www.youtube.com\/.+/', $this->link_youtube)
            && !preg_match('/http:\/\/www.youtube.com\/.+/', $this->link_youtube)
            && !preg_match('/http:\/\/y2u.be\/.+/', $this->link_youtube)
            && !preg_match('/https:\/\/y2u.be\/.+/', $this->link_youtube)
            && !preg_match('/http:\/\/youtu.be\/.+/', $this->link_youtube)
            && !preg_match('/https:\/\/youtu.be\/.+/', $this->link_youtube)
            && !preg_match('/https:\/\/m.youtube.com\/.+/', $this->link_youtube)
            && !preg_match('/http:\/\/m.youtube.com\/.+/', $this->link_youtube)
            && !empty($this->link_youtube)
        ) 
        {
            throw new Exception($this->Napisy->daj('format_youtube'));
        }
    }


}