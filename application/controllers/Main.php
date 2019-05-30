<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->load->model('Napisy');
        /** @var Napisy $napisyObj */
        $napisyObj = $this->Napisy;

        $this->load->model('Youtube');
        
        $data = array(
            'napisy' => array(
                'szukaj' => $napisyObj->daj('szukaj'),
                'osoba' => $napisyObj->daj('osoba'),
                'dod_utwor' => $napisyObj->daj('dod_osoba'),
                'dod_wykonawca' => $napisyObj->daj('dod_wykonawca'),
                'info_box' => $napisyObj->daj('info_box'),
                'youtube_link' => $napisyObj->daj('youtube_link'),
            ),
            'youtube_list' => $this->Youtube->getIdPlaylist(),
            'widok' => '',//$this->load->view('nazwa', [], true),
        );
        
        $this->load->helper('url');
		$this->load->view('main_message', $data);
	}
    
    public function szukaj() {
        $this->load->model('Napisy');
        /** @var Napisy $napisyObj */
        $napisyObj = $this->Napisy;
        
        $this->load->model('ElementMuzycznyCollection');
        /** @var ElementMuzycznyCollection $elementy */
        $elementy = $this->ElementMuzycznyCollection;
        $wpisyWykonawcy = $elementy->dajWykonawcowWgNazwy($_POST['nazwa']);
        $wpisyUtwory = $elementy->dajUtworyWgNazwy($_POST['nazwa']);

        $html = '';
            
        $this->load->model('GeneratorHtmlTabeliElementow');
        /** @var GeneratorHtmlTabeliElementow $tabele */
        $tabele = $this->GeneratorHtmlTabeliElementow;
        $tabele->setNaglowek($napisyObj->daj('wykonawcy'));
        $tabele->setFiltrNazwa($_POST['nazwa']);
        $html .= $tabele->generujTabele($wpisyWykonawcy);
        
        $html .= $tabele->separator();

        $tabele->setNaglowek($napisyObj->daj('utwory'));
        $html .= $tabele->generujTabele($wpisyUtwory);
        
        $html .= $tabele->dajSkryptJs();
            
        echo $html;
    }
    
    public function dodajWykonawce() {
        $this->load->model('ElementMuzyczny');
        /** @var ElementMuzyczny $element */
        $element = $this->ElementMuzyczny;
        $element->nazwa = $_POST['nazwa'];
        $element->rodzaj = $element->getRodzajWykonawca();
        $element->dodajacy = $_POST['dodajacy'];
        try {
            $element->zapisz();
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
            return;
        }
        $this->szukaj();
    }

    public function dodajUtwor() {
        $this->load->model('Napisy');
        
        $this->load->model('ElementMuzyczny');
        /** @var ElementMuzyczny $element */
        $element = $this->ElementMuzyczny;
        $element->nazwa = $_POST['nazwa'];
        $element->rodzaj = $element->getRodzajUtwor();
        $element->dodajacy = $_POST['dodajacy'];
        $element->link_youtube = $_POST['link_youtube'];

        $this->load->model('Youtube');
        /** @var Youtube $youtube */
        $youtube = $this->Youtube;
        $videoData = $youtube->getVideoInfo($element->link_youtube);
        $element->nazwa = $videoData['modelData']['items'][0]['snippet']['title'];
        
        try {
            $this->czyUtworIstnieje();
            $element->zapisz();
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
            return;
        }
        $this->szukaj();
    }
    
    public function glosuj() {
        /** @var ElementMuzycznyCollection $elementCollection */
        $elementCollection = $this->load->getModel('ElementMuzycznyCollection');
        
        /** @var ElementMuzyczny $element */
        $element = $elementCollection->dajElementWgId($_POST['id_serial']);
        
        /** @var Glosowanie $glosowanie */
        $glosowanie = $this->load->getModel('Glosowanie');
        try {
            $glosowanie->glosuj($element, $_POST);
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
            return;
        }
        
        $this->szukaj();
    }
    
    public function czyUtworIstnieje() {
        $this->load->model('ElementMuzycznyCollection');
        /** @var ElementMuzycznyCollection $elementy */
        $elementy = $this->ElementMuzycznyCollection;
        $wpisyUtwory = $elementy->dajUtworyWgNazwy($_POST['nazwa']);
        
        $nazwy = array();
        
        $nazwaOryginalna = explode(" ", strtolower(trim($_POST['nazwa'])));
        
        foreach ($wpisyUtwory->result() as $wpis) {
            $nazwaZBazy = explode(" ", strtolower($wpis->nazwa));
            
            $roznice = array_diff($nazwaOryginalna, $nazwaZBazy);
            if (empty($roznice)) {
                $nazwy[] = $wpis->nazwa;
            }
        }
        if (count($nazwy) > 0) {
            throw new Exception($this->Napisy->daj('blad_utwor_istnieje'));
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Youtube');
        /** @var Youtube $youtube */
        $youtube = $this->Youtube;
    }
}
