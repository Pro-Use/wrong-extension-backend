<?php
 header("Access-Control-Allow-Origin: *");

$data = $page->children()
    ->filter(function ($child) {
    return $child->status() != 'draft';
  });

$now = new DateTime("now", new DateTimeZone('Europe/London'));
$now_string = $now->format('Y-m-d');
$popups_json = [];
$next_popups = [];
foreach($data as $article) {
    
  $from = new DateTime($article->from(), new DateTimeZone('Europe/London'));
  $to = new DateTime($article->to(), new DateTimeZone('Europe/London'));
    
  if ($from<= $now && $now <= $to){
      
    $popups = $article->popups()->toStructure();
    $popup_json = [];

    foreach($popups as $popup) {
        $dates = explode(", ", $popup->date());
        sort($dates);
        foreach($dates as $date){
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
        $now = new DateTime($now_string, new DateTimeZone('Europe/London'));
        if ($to > $now) {
            foreach($dates as $date){
                if ($date == "") {
                    $popup_date = clone $now;
                    $popup_date->modify('+1 day');
                } else {
                    $popup_date = new DateTime($date, new DateTimeZone('Europe/London'));
                }
                if ($popup_date > $now) {
                    $next_popups[] = [
                    'time' => (string)$popup->time(),
                    'date' => $popup_date,
                    'popup_set' => $article,
                    'popup'=> $popup,
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
if (count($next_popups) == 0) {
    $next_popup_json = Null;
} else {
    $next_popup = $next_popups[0];
    $next_popup_id = base64_encode($next_popup['popup']->url());
    $next_popup_diff = (int)$now->diff($next_popup['date'])->format('%a');
    $next_popup_json = [
                    'curator' => (string)$next_popup['popup_set']->title(),
                    'title' => (string)$next_popup['popup_set']->popupSetTitle(),
                    'popup_title' => (string)$next_popup['popup']->popup_title(),
                    'popup_info' => (string)$next_popup['popup']->popup_text(), 
                    'id' => (string)$next_popup_id,
                    'url' => (string)$next_popup['popup']->url(),
                    'info_url' => (string)$next_popup['popup']->url()."?id=".$next_popup_id,
                    'fullscreen' => (string)$next_popup['popup']->fullscreen(),
                    'width' => (string)$next_popup['popup']->width(),
                    'height' => (string)$next_popup['popup']->height(),
                    'position' => (string)$next_popup['popup']->position(),
                    'time' => (string)$next_popup['popup']->time(),
                    'dates' => (string)$next_popup['date']->format('Y-m-d'),
                    'diff' => $next_popup_diff
                    ];
}

$json = ['lastUpdate' => (string)$page->lastUpdated(),
         'popups' => $popups_json,
         'next_popup' => $next_popup_json
//        _json
        ];

echo json_encode($json);

