<?php


class Video extends CI_Controller 
{
    public $curl;
    public function index() {
        $this->load->model('Youtube');
        /** @var Youtube $youtube */
        $youtube = $this->Youtube;
        
        $youtube->index();
    }

    public function secret_add_full_movies() {
        $this->load->model('Youtube');
        /** @var Youtube $youtube */
        $youtube = $this->Youtube;

        $youtube->kasujOrazDodajWszystkieFilmy();
    }
    
    public function testapitoken() {
        $this->load->model('Youtube');
        /** @var Youtube $youtube */
        $youtube = $this->Youtube;
        
        $token = $_SESSION['token'];
        
        echo '<pre>';
        var_export($token);
        
        echo '</pre>';
    }
    
    public function testtest() {
        $a = file_get_contents('client_secrets.json');
        $json = json_decode($a, true);
        var_export($json);
    }
}