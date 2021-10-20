<?php
 header("Access-Control-Allow-Origin: *");

$data = $page->children()
    ->filter(function ($child) {
    return $child->status() != 'draft';
  });

$now = new DateTime("now");
$now_string = $result = $now->format('Y-m-d');
$popups_json = [];

foreach($data as $article) {
    
  $from = new DateTime($article->from());
  $to = new DateTime($article->to());
    
  if ($from<= $now && $now <= $to){
      
    $popups = $article->popups()->toStructure();
    $popup_json = [];

    foreach($popups as $popup) {
        $dates = explode(",", $popup->date());
        foreach($dates as $date){
            $date = trim($date);
            if ($date == $now_string || $date == ""){
                $popup_json[] = [
                'title' => (string)$article->title(), 
                'id' => base64_encode($popup->url()),
                'url' => (string)$popup->url(),
                'fullscreen' => (string)$popup->fullscreen(),
                'width' => (string)$popup->width(),
                'height' => (string)$popup->height(),
                'position' => (string)$popup->position(),
                'time' => (string)$popup->time(),
                'dates' => $dates
                ];
                break;
            }
        }
    }

    $popups_json[] = $popup_json;
  }
}

$json = ['lastUpdate' => $page->lastUpdated(),
         'popups' => $popups_json];

echo json_encode($json);

