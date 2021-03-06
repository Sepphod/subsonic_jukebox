<?php

namespace MHorwood\Jukebox\model;

use MHorwood\Jukebox\classes\jukebox;
use MHorwood\Jukebox\classes\lists;
use MHorwood\Jukebox\classes\AsciiColorizer;

class CurlModel {
  private $Subsonic;
  private $lists;
  private $jukebox;
  private $settings;
  private $id;
  private $action;
  private $color;
  private $set_color;

  public function __construct($settings) {
    $this->lists = new lists($settings);
    $this->jukebox = new jukebox($settings);
    $this->color = new AsciiColorizer();
    $this->settings = $settings;
  }

  // Process the action
  // Will nedd to add HTML builder here also
  public function action($args){
    foreach ($args as $key => $value) {
      switch ($key){
        case 'id':
          $this->id = $value;
          break;
        case 'color':
          $this->set_color = $value;
          break;
        case 'action':
          $action = $value;
          break;

      }
    }

    if(!isset($action) || $action === ''){
      $action = 'get';
    }

    if(!isset($this->id)  || $this->id === ''){
      $this->id = 2;
    }

    switch ($action) {
        case 'help':
          include (__DIR__ . '/../view/usage.php');
          return $html;
          break;
        case 'add':
            $xml = $this->lists->getRandomSongs(50, 1);
            $songs = $xml['randomSongs']['song'];
            $ids = array();
            foreach ($songs as $key => $song) {
                $xml = $this->jukebox->jukeboxControl('add', 0, 0, 'id='.$song['@attributes']['id']);
            }
            if($this->check_status($xml) === true){
              $html = $this->build_html($this->jukebox->jukeboxControl('get'));
            }
            return $html;
            break;
        case 'set':
            $xml = $this->lists->getRandomSongs(50, 1);
            $songs = $xml['randomSongs']['song'];
            $ids = array();
            foreach ($songs as $key => $song) {
              $ids[] = 'id='.$song['@attributes']['id'];
            }
            $xml = $this->jukebox->jukeboxControl('set', 0, 0, \implode('&', $ids));
            if($this->check_status($xml) === true){
              $html = $this->build_html($this->jukebox->jukeboxControl('get'));
            }
            return $html;
            break;
        case 'skip';
          $xml = $this->jukebox->jukeboxControl('skip', $this->id);
          if($this->check_status($xml) === true){
            $html = $this->build_html($this->jukebox->jukeboxControl('get'));
            return $html;
          }else{
            return 'ERROR! We didnt find that skip';
          }
          break;
        case 'get';
          $html = $this->build_html($this->jukebox->jukeboxControl('get'));
          return $html;
          break;
        default:
            $xml = $this->jukebox->jukeboxControl($action);
            if($this->check_status($xml) === true){
              include (__DIR__ . '/../view/curl_status.php');
              return $html;
            }else{
              return 'ERROR! that didnt work';
            }
            break;
    }
  }

  // pritty print_r
  public function print_pre($input){
      $this->jukebox->print_pre($input);
  }

  // Build the HTML for the page
  private function build_html($songs){
    // $this->lists->print_pre($songs);
    $playing = $songs['jukeboxPlaylist']['@attributes']['playing'];
    $currentIndex = $songs['jukeboxPlaylist']['@attributes']['currentIndex'];
    include (__DIR__ . '/../view/curl.php');
    return $html;
  }

  private function check_status($xml){
    if($xml['@attributes']['status'] === 'ok'){
      return true;
    }else{
      return false;
    }
  }
}
