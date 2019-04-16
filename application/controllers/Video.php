<?php


class Video extends CI_Controller 
{
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
    
    
}