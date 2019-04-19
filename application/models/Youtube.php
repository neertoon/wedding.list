<?php

class Youtube extends CI_Model
{
    const CREDENTIALS_PATH = 'php-yt-oauth2.json';
    
    /** @var Google_Service_YouTube  */
    private $service;

    public function __construct()
    {
        $b = file_get_contents('php-yt-oauth2.json');
        $token = json_decode($b, true);
        if (empty($_SESSION['token'])) {
            $tokenNew = $this->refreshToken();
            $tokenNewArray = json_decode($tokenNew, true);
            $token['access_token'] = $tokenNewArray['access_token'];
            $token['expires_in'] = $tokenNewArray['expires_in'];
            $token['created'] = time();
            $_SESSION['token'] = json_encode($token);
            $_SESSION['access_token'] = $tokenNewArray['access_token'];
        }

        $client = $this->getClient();
        $this->service = new Google_Service_YouTube($client);
    }
    
    public function refreshToken() {
        $a = file_get_contents('client_secrets.json');
        $json = json_decode($a, true);

        $b = file_get_contents('php-yt-oauth2.json');
        $token = json_decode($b, true);

        $refresh = [
            'client_id' => $json['web']['client_id'],
            'client_secret' => $json['web']['client_secret'],
            'grant_type' => 'refresh_token',
            'refresh_token' => $token['refresh_token'],
        ];

        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_URL,"https://accounts.google.com/o/oauth2/token");

        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 10); //max czas po³¹czenia
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 20); //max czas pobierania/dzia³ania
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLINFO_HEADER_OUT, true);
        

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($refresh));


        $resultJson = curl_exec($this->curl);
        $curlOpt = curl_getinfo($this->curl);
        
        return $resultJson;
    }
    
    public function getIdPlaylist() {
        return $_SERVER['youtube_playlist'] ?? $_ENV['youtube_playlist'];
    }

    public function index() {
        

        $r = $this->service->playlists->listPlaylists(
            'snippet,contentDetails,id',
            array('channelId'=>'UCaSm5O-ss8AG6Aqmk4BFzqg')
        );
        
        foreach ($r as $wiersz) {
            echo "<pre>";
            var_export($wiersz);
            echo "</pre>";
        }

        echo "TEST";
    }

    private function expandHomeDirectory($path) {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }

    private function getClient() {
        $client = new Google_Client();
        // Set to name/location of your client_secrets.json file.
        $client->setAuthConfigFile('client_secrets.json');
        // Set to valid redirect URI for your project.
        $client->setRedirectUri('http://martaniel.ovh');
        $client->addScope(Google_Service_YouTube::YOUTUBE);
//        $client->addScope(Google_Service_YouTube::YOUTUBE_UPLOAD);
        $client->setAccessType('offline');

        // Load previously authorized credentials from a file.
//        $credentialsPath = self::CREDENTIALS_PATH;
        if (empty($_SESSION['access_token'])) {
            throw new Exception("Brak tokenu autoryzuj¹cego");
        }

        $client->setAccessToken($_SESSION['token']);

        // Refresh the token if it's expired.^M
//        if ($client->isAccessTokenExpired()) {
//            $client->refreshToken($client->getRefreshToken());
//            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
//        }

        return $client;
    }

    public function channelsListByUsername($part, $params) {
        $params = array_filter($params);
        $response = $this->service->channels->listChannels(
            $part,
            $params
        );

        $description = sprintf(
            'This channel\'s ID is %s. Its title is %s, and it has %s views.',
            $response['items'][0]['id'],
            $response['items'][0]['snippet']['title'],
            $response['items'][0]['statistics']['viewCount']);
        print $description . "\n";
    }

    public function kasujOrazDodajWszystkieFilmy() {
        $this->kasujFilmyZPlaylisty();
        
        $this->load->model('ElementMuzycznyCollection');
        /** @var ElementMuzycznyCollection $elementy */
        $elementy = $this->ElementMuzycznyCollection;
        
        $utworyZLinkami = $elementy->dajUtworyMajaceLinkiYoutube();

        $idVideo = array();
        foreach ($utworyZLinkami->result() as $wpis) {
            $link = $this->dajIdFilmu($wpis->link_youtube);
            if (!empty($link)) {
                $idVideo[$link] = $link;
            }
        }
        
//        echo "<pre>";
//        var_export($idVideo);
//        echo "</pre>";
        
        foreach ($idVideo as $videoId) {
            $this->dodajFilmDoPlaylisty($videoId);
        }
        
        echo "DODANO ".count($idVideo)." FILMOW <br />";
    }

    public function dajIdFilmu($link) {
        $matches = array();
        preg_match('/watch\?v=([^&]*)/', $link, $matches);
        
        if (empty($matches[1])) {
            $matches = array();
            preg_match('/http:\/\/youtu.be\/([^?]*)/', $link, $matches); 
        }

        if (empty($matches[1])) {
            $matches = array();
            preg_match('/https:\/\/youtu.be\/([^?]*)/', $link, $matches);
        }
        
        if (empty($matches[1])) {
            $matches = array();
            preg_match('/http:\/\/www.youtube.com\/embed\/(.*)/', $link, $matches);
        }

        if (empty($matches[1])) {
            $matches = array();
            preg_match('/https:\/\/www.youtube.com\/embed\/(.*)/', $link, $matches);
        }
        
        return !empty($matches[1]) ? $matches[1] : '';
    }

    public function dodajFilmDoPlaylisty($movieId) {
        // 5. Add a video to the playlist. First, define the resource being added
        // to the playlist by setting its video ID and kind.
        $resourceId = new Google_Service_YouTube_ResourceId();
        $resourceId->setVideoId($movieId); //'e7lcimljm3k');
        $resourceId->setKind('youtube#video');

        // Then define a snippet for the playlist item. Set the playlist item's
        // title if you want to display a different value than the title of the
        // video being added. Add the resource ID and the playlist ID retrieved
        // in step 4 to the snippet as well.
        $playlistItemSnippet = new Google_Service_YouTube_PlaylistItemSnippet();
        $playlistItemSnippet->setTitle('Film z glosowania na utwory');
        $playlistItemSnippet->setPlaylistId($this->getIdPlaylist());
        $playlistItemSnippet->setResourceId($resourceId);

        // Finally, create a playlistItem resource and add the snippet to the
        // resource, then call the playlistItems.insert method to add the playlist
        // item.
        $playlistItem = new Google_Service_YouTube_PlaylistItem();
        $playlistItem->setSnippet($playlistItemSnippet);

        $r = $this->service->playlistItems->insert(
            'snippet,contentDetails',
            $playlistItem
        );
    }

    private function kasujFilmyZPlaylisty()
    {
        $nextPage = null;
        $items = array();
        do {
            $response = $this->pobierzElementyZListy($nextPage);

            foreach ($response['items'] as $item) {
                $items[] = $item['id'];
            }

            $nextPage = $response['nextPageToken'];
        } while (!empty($nextPage));
        
        foreach ($items as $item) {
            $this->service->playlistItems->delete($item);
        }
        
        echo "USUNIETO ".count($items)." ELEMENTOW <br />";
    }
    
    public function pobierzElementyZListy($nextPage = null) {
        $params = array('playlistId' => $this->getIdPlaylist(), 'maxResults'=>30);
        if (!empty($nextPage)) {
            $params['pageToken'] = $nextPage;
        }
        $response = $this->service->playlistItems->listPlaylistItems(
            'snippet,contentDetails',
            $params
        );
        
        return $response;
    }
}