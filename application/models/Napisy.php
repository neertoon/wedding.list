<?php

class Napisy extends CI_Model
{
    private $napisy = array();
    
    public function __construct()
    {
        $this->napisy['pl'] = array(
            'szukaj' => 'SZUKAJ/DODAJ',       
            'osoba' => 'TWOJE IMIĘ',       
            'dod_wykonawca' => 'Dodaj wykonawcę',       
            'dod_osoba' => 'Dodaj jako utwór',       
            'wykonawcy' => 'WYKONAWCY',       
            'utwory' => 'UTWORY',       
            'glosuj' => 'Głosuj',
            'youtube_link' => 'LINK DO YOUTUBE',
            'format_youtube' => 'Niewłaściwy format linku youtube',
            'info_box' => 'Drodzy goście,<br/>
Wesele nie może się obejść was drodzy goście a ponieważ chcemy, 
        byście cieszyli się razem z nami podczas tego specjalnego dnia możecie w tym miejscu zaproponować utwory lub ogólnie artystów do których lubicie się bawić<br/><br/>
    - Najpierw warto wyszukać, czy interesujący was utwór lub artysta istnieje na liście<br/>
    - Element który najbardziej spełnia kryteria wyszukiwania będzie na pierwszym miejscu na liście<br/>
    - Jeśli istnieje, zagłosuj na niego, jeśli nie możesz go dodać<br/>
    - Jeśli znalazłeś link do utworu na youtube dodaj go<br/>
    - Nie zapomnij podać swojego imienia.<br/>
    - Pozdrawiamy!<br/>
    - Wszelkie pytania odnośnie działania strony piszcie na neertoon@gmail.com'
        );

        $this->napisy['pl']['blad_brak_osoby'] = "Uzupełnij pole ".$this->napisy['pl']['osoba'];

        $msg = "Nie można dodać tego wpisu<br />";
        $msg .= "- nazwa nie może być pusta<br />";
        $msg .= "- nazwa nie może zawierać słowa ".$this->napisy['pl']['szukaj']."<br />";
        $this->napisy['pl']['blad_blad_dodania'] = $msg;
        
        $this->napisy['pl']['blad_utwor_istnieje'] = 'Nie można dodać tego utworu.<br />Prawdopodobnie już istnieje';

        // ANGIELSKI
        $this->napisy['en'] = array(
            'szukaj' => 'SEARCH/ADD',
            'osoba' => 'YOUR NAME',
            'dod_wykonawca' => 'Add as artist',
            'dod_osoba' => 'Add as song',
            'wykonawcy' => 'ARTISTS',
            'utwory' => 'SONGS',
            'glosuj' => 'Vote',
            'youtube_link' => 'LINK TO YOUTUBE',
            'format_youtube' => 'Wrong youtube link format',
            'info_box' => 'Dear guests,<br/>
The wedding party wouldn\'t be possible without you and because we want you to enjoy yourselves with us on our special day
, can you please help us by choosing songs which you know you will dance to<br/><br/>
    - First, check if your favourite song or artist exists in the database<br/>
    - If it does - vote for it, if not - you can add it<br/>
    - If you found a song on youtube you can add a link to it<br/>
    - Don\'t forget to add your name<br/>
    - Have a problem with this website? Write to neertoon@gmail.com'
        );

        $this->napisy['en']['blad_brak_osoby'] = "Fill field ".$this->napisy['en']['osoba'];

        $msg = "System cannot add this item<br />";
        $msg .= "- name cannot be empty<br />";
        $msg .= "- name cannot contains ".$this->napisy['en']['szukaj']."<br />";
        $this->napisy['en']['blad_blad_dodania'] = $msg;

        $this->napisy['en']['blad_utwor_istnieje'] = 'Cannot add this item.<br />Probably already exists';
    }

    public function daj($napis) {
        $jezyk = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        $jezyk = in_array($jezyk, array('pl', 'en')) ? $jezyk : 'en';
        
        return !empty($this->napisy[$jezyk][$napis]) ? $this->napisy[$jezyk][$napis] : $napis;
    }
}