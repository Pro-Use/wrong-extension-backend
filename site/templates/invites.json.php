<?php


$data = $page->children()
    ->filter(function ($child) {
    return $child->status() != 'draft';
  });

$now = new DateTime("now");
$json = [];

foreach($data as $article) {
    
  $from = new DateTime($article->from());
  $to = new DateTime($article->to());
    
  if ($from<= $now && $now <= $to){
      
    $popups = $article->popups()->toStructure();
    $popups_json = [];

    foreach($popups as $popup) {
        $popups_json[] = [
            'url' => (string)$popup->url(),
            'fullscreen' => (string)$popup->fullscreen(),
            'width' => (string)$popup->width(),
            'height' => (string)$popup->height(),
            'position' => (string)$popup->position(),
            'time' => (string)$popup->time(),
            'date' => (string)$popup->date()
        ];
    }

    $json[] = [
      'title' => (string)$article->title(), 
      'from'=> (string)$article->from(),
      'to' => (string)$article->to(),
      'popups'   => $popups_json,
      'invalidDate' =>$article->invalidDate()->toBool(),

    ];
  }
}

echo json_encode($json);

