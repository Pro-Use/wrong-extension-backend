<?php


$data = $page->children()
    ->filter(function ($child) {
    return $child->status() != 'draft';
  });

$now = new DateTime("now");
$popups_json = [];

foreach($data as $article) {
    
  $from = new DateTime($article->from());
  $to = new DateTime($article->to());
    
  if ($from<= $now && $now <= $to){
      
    $popups = $article->popups()->toStructure();
    $popup_json = [];

    foreach($popups as $popup) {
        $popup_json[] = [
            'url' => $popup->url(),
            'fullscreen' => (string)$popup->fullscreen(),
            'width' => (string)$popup->width(),
            'height' => (string)$popup->height(),
            'position' => (string)$popup->position(),
            'time' => (string)$popup->time(),
            'date' => (string)$popup->date(),
        ];
    }

    $popups_json[] = [
      'title' => (string)$article->title(), 
      'from'=> (string)$article->from(),
      'to' => (string)$article->to(),
      'popups'   => $popup_json,
    ];
  }
}

$json = ['lastUpdate' => $page->lastUpdated(),
         'popups' => $popups_json];

echo json_encode($json);

