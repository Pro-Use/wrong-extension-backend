<?php
 header("Access-Control-Allow-Origin: *");

$data = $page->children()
    ->filter(function ($child) {
    return $child->status() != 'draft';
  });

$now = new DateTime("now");
$now_string = $result = $now->format('Y-m-d');
$popups_json = [];
$next_popups = [];
foreach($data as $article) {
    
  $from = new DateTime($article->from());
  $to = new DateTime($article->to());
    
  if ($from<= $now && $now <= $to){
      
    $popups = $article->popups()->toStructure();
    $popup_json = [];

    foreach($popups as $popup) {
        $dates = explode(", ", $popup->date());
        sort($dates);
        foreach($dates as &$date){
//            $date = trim($date);
            if ($date == $now_string || $date == ""){
                $id = base64_encode($popup->url());
                $popup_json[] = [
                'curator' => (string)$article->title(),
                'title' => (string)$article->popupSetTitle(),
                'popup_title' => (string)$popup->popup_title(),
                'popup_info' => (string)$popup->popup_text(), 
                'id' => (string)$id,
                'url' => (string)$popup->url(),
                'info_url' => (string)$article->url()."?id=".$id,
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
        if ($to > $now) {
            foreach($dates as $date){
                $popup_date = new DateTime($date);
                if ($popup_date > $now) {
                    $next_popups[] = [
                    'time' => (string)$popup->time(),
                    'date' => (string)$date,
                    'popup'=> $popup
                    ];
                break;
                }

            }
        }
    }

    $popups_json[] = $popup_json;
  }
  
}

usort($next_popups, function($a, $b) {
    $retval = $a['date'] <=> $b['date'];
    if ($retval == 0) {
        $retval = $a['time'] <=> $b['time'];
    }
    return $retval;
});

$next_popup = $next_popups[0];
$next_popup_json = [
                'curator' => (string)$next_popup['popup']->title(),
                'title' => (string)$next_popup['popup']->popupSetTitle(),
                'popup_title' => (string)$next_popup['popup']->popup_title(),
                'popup_info' => (string)$next_popup['popup']->popup_text(), 
                'id' => (string)$id,
                'url' => (string)$next_popup['popup']->url(),
                'info_url' => (string)$next_popup['popup']->url()."?id=".$id,
                'fullscreen' => (string)$next_popup['popup']->fullscreen(),
                'width' => (string)$next_popup['popup']->width(),
                'height' => (string)$next_popup['popup']->height(),
                'position' => (string)$next_popup['popup']->position(),
                'time' => (string)$next_popup['popup']->time(),
                'dates' => $next_popup['date']
                ];

$json = ['lastUpdate' => (string)$page->lastUpdated(),
         'popups' => $popups_json,
         'next_popup' => $next_popups
        ];

echo json_encode($json);

