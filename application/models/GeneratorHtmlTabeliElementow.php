<?php
class GeneratorHtmlTabeliElementow extends CI_Model {
    private $naglowek;
    private $filtrNazwa;
    private $filtrNazwaExplode;

    public function __construct()
    {
        parent::__construct();
        $this->naglowek = 'Nazwa';
    }
    
    public function separator() {
        return "<!--SEP-->";
    }
    
    public function setNaglowek($naglowek) {
        $this->naglowek = $naglowek;        
    }

    public function generujTabele($wpisy) {
        $html = '';
        $html .= $this->dajNaglowek();
        
        $posortowaneWgIlosciTrafienslow = $this->posortujWpisy($wpisy);
        
        foreach ($posortowaneWgIlosciTrafienslow as $wiersz) {
            $link = !empty($wiersz->link_youtube) ? '<a href="'.$wiersz->link_youtube.'" target="_blank"><img style="width: 27px; height: 25px" src="play-button.png"/></a>' : '';
            $html .= '<tr>';
            $html .= '<td>'.$wiersz->nazwa.'</td>';
            $html .= '<td>'.$link.'</td>';
            $html .= '<td>'.$wiersz->_ile_za.'</td>';
            $html .= '<td>';
            $html .= '<a class="glosuj_a" href="'.$wiersz->id_serial.'" name="+">[ + ] </a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= "</table>";
        return $html;
    }

    private function dajNaglowek()
    {
        $this->load->model('Napisy');
        /** @var Napisy $napisyObj */
        $napisyObj = $this->Napisy;
        
        return '<table id="tab_elementy">
                <tr>
                    <td>'.$this->naglowek.'</td>
                    <td>YT</td>
                    <td>+</td>
                    <td>'.$napisyObj->daj('glosuj').'</td>
                </tr>';
    }
    
    public function dajSkryptJs() {
        return '<script>
                $( ".glosuj_a" ).click(function( event ) {
                    event.preventDefault();
                    var rodzaj = event.target.getAttribute("name");
                    var id = event.target.getAttribute("href");
                    var dodajacy = $("#dodajacy").val();
                    var nazwa = $("#nazwa").val();
                    var request = $.ajax({
                        url: "index.php/Main/glosuj",
                        method: "POST",
                        data: { 
                            id_serial: id, 
                            rodzaj: rodzaj, 
                            dodajacy: dodajacy,
                            nazwa: nazwa
                        },
                        error: function (jqXHR, exception) {
                            $( "#ERROR" ).css("display", "block");
                            $( "#error_msg" ).html(jqXHR.responseText);
                            szukajUtwory();
                        }
                    });
                    
                    odswiezTabele(request);
                    
                });
                </script>';
    }

    /**
     * @param mixed $filtrNazwa
     * @return GeneratorHtmlTabeliElementow
     */
    public function setFiltrNazwa($filtrNazwa)
    {
        $this->load->model('Napisy');
        /** @var Napisy $napisyObj */
        $napisyObj = $this->Napisy;
        
        $this->filtrNazwa = strtolower($filtrNazwa) == strtolower($napisyObj->daj('szukaj')) ? '' : $filtrNazwa;
        $this->filtrNazwaExplode = $nazwaOryginalna = explode(" ", strtolower($filtrNazwa));
        return $this;
    }

    private function posortujWpisy($wpisy)
    {
        $nowe = array();
        foreach ($wpisy->result() as $wpis) {
            $nazwaBaza = explode(" ", strtolower($wpis->nazwa));
            $wpis->ile_podobienst = count(array_intersect($this->filtrNazwaExplode, $nazwaBaza));
            $nowe[] = $wpis;
        }

        if (!empty($this->filtrNazwa)) {
            usort($nowe, function($a, $b)
            {
                return $a->ile_podobienst <= $b->ile_podobienst;
            });
        }
        
        return $nowe;
    }
}