<?php
$html = '<form name="plugs" method="post" action="http://'.$_SERVER['HTTP_HOST'].'">'."\n";
if($playing === 'true'){
  $html .= '<button class="button button3'.$style_stop.'" name="action" value="stop">Stop</button>'."\n";
}else{
  $html .= '<button class="button button1'.$style_start.'" name="action" value="start">Start</button>'."\n";
}
$html .= '<button class="button button2" name="action" value="set">New Playlist</button>'."\n";
$html .= '<button class="button button2" name="action" value="clear">Clear Playlist</button>'."\n";
$html .= '<a class="button4" href="#track-'.$currentIndex.'">Track #: '.$currentIndex . '</a>'."\n";
$html .= '</form>'."\n";