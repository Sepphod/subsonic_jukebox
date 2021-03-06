<?php

namespace MHorwood\Jukebox\classes;

use MHorwood\Jukebox\classes\subsonic;

class lists extends subsonic {

  private $SubADDR;
  private $SubUSER;
  private $SubPASS;
  private $SubSALT;
  private $SubVER;
  private $SubCLI;

  /**
   * Build Object
   **/
   function __construct($settings){
     $this->SubADDR = $settings['Sub']['ADDR'];
     $this->SubUSER = $settings['Sub']['USER'];
     $this->SubPASS = $settings['Sub']['PASS'];
     $this->SubSALT = $settings['Sub']['SALT'];
     $this->SubVER = $settings['Sub']['VER'];
     $this->SubCLI = $settings['Sub']['CLI'];
   }

  public function getAlbumList(){}
  public function getAlbumList2(){}

  /*
   * Get a random list of songs
   * $size: INT the number of songs to get
   * $folderID: INT the folder to get songs from
   */
  public function getRandomSongs(int $size = 10 , int $folderID = 1, string $genre = '', int $fromYear = 0, int $toYear = 0){
    $folderID_url = '&musicFolderId='.$folderID;
    $genre_url = '';
    $fromYear_url = '';
    $toYear_url = '';
    if($genre !== ''){
      $genre_url = '&genre='.$genre;
    }
    if($fromYear !== 0){
      $fromYear_url = '&fromYear='.$fromYear;
    }
    if($toYear !== 0){
      $toYear_url = '&toYear='.$toYear;
    }
    return $this->connect($this->SubADDR.'/rest/getRandomSongs.view'.'?u='.$this->SubUSER.
    '&t='.$this->SubPASS.'&s='.$this->SubSALT.'&v='.$this->SubVER.'&c='.
    $this->SubCLI.'&size='.$size.$folderID_url.$genre_url.$fromYear_url.$toYear_url);

  }
  public function getSongsByGenre(){}
  public function getNowPlaying(){}
  public function getStarred(){}
  public function getStarred2(){}

}
