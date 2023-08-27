<?php
 header("Access-Control-Allow-Origin: *");

$data = $page->children()
    ->filter(function ($child) {
    return $child->status() != 'draft';
  });

$now = new DateTime("now", new DateTimeZone('Europe/London'));
$now_string = $now->format('Y-m-d');
$popups_json = [];
$next_popup_json = null;
$slug = null;
$days = null;

if ($_GET['project'] ?? null){
    $slug = 'invites/'.$_GET['project'];
    $article = $kirby->page($slug); 
} else {
    $project = $kirby->site()->live_project_page();
    $article = $project->toPage();
}

if ($_GET['day'] ?? null){
    $day = intval($_GET['day']);
    if ($day == 0) {
        $day = 1;
    }
} else {
    $day = 1;
}

if($article != null && $article->days()->isNotEmpty()) {
  $slug = (string)$article->slug();
  $days = $article->days()->toInt();
  $from = new DateTime($article->from(), new DateTimeZone('Europe/London'));
    
  if ($from<= $now ){
      
    $popups = $article->popups()->toStructure();
    $events = $article->events()->toStructure();

    // Get events
    foreach($events as $event){
        $event_day = $event->date()->toDate('Y-m-d');
        // Check if event is today and add!
        if ($event_day == $now_string) {
            $id = base64_encode($event->url());
            $popups_json[] = [
                'project' => (string)$article->slug(),
                'curator' => (string)$article->title(),
                'title' => (string)$article->popupSetTitle(),
                'popup_title' => (string)$event->popup_title(),
                'popup_info' => (string)$event->popup_text(), 
                'id' => (string)$id,
                'url' => (string)$event->url(),
                'info_url' => (string)$article->url()."?id=".$id,
                'fullscreen' => (string)$event->fullscreen(),
                'width' => (string)$event->width(),
                'height' => (string)$event->height(),
                'position' => (string)$event->position(),
                'time' => (string)$event->time(),
            ]; 
        }
    }
    // Sort all popups by day and time
    $sorted_popups = $popups->sortBy('day', 'asc', 'time', 'asc');

    foreach($sorted_popups as $popup) {
        // Get this day's popups
        if ($popup->day()->isNotEmpty() && $popup->day()->toInt() == $day){
            $id = base64_encode($popup->url());
            $popups_json[] = [

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
                'day' => $popup->day()->toInt(),
            ];
        // get first popup from next day
        } elseif ($popup->day()->toInt() > $day) {
            $id = base64_encode($popup->url());
            $popup_date = clone $now;
            $days_ahead = $popup->day()->toInt() - $day;
            $popup_date->modify(sprintf("%u day",$days_ahead));
            $next_popup_diff = (int)$now->diff($popup_date)->format('%a');
            $next_popup_json = [
                'curator' => (string)$article->title(),
                'title' => (string)$article->popupSetTitle(),
                'slug' => (string)$article->slug(),
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
                'day' => $popup->day()->toInt(),
                'diff' => $next_popup_diff
            ];
            break;

        }
    }
  } else {
    // If live project hasn't launched yet, show next popup
    $popups = $article->popups()->toStructure();
    $sorted_popups = $popups->sortBy('day', 'asc', 'time', 'asc');
    $popup = $sorted_popups->first();
    $diff = date_diff($now, $from, true);
    $next_popup_diff = (int)$diff->format('%a');
    $id = base64_encode($popup->url());
    $popup_date = clone $now;
    $days_ahead = $popup->day()->toInt() - $day;
    $popup_date->modify(sprintf("%u day",$days_ahead));
    if ($next_popup_diff == 0){
        $next_popup_diff += 1;
    }
    $next_popup_json = [
        'curator' => (string)$article->title(),
        'title' => (string)$article->popupSetTitle(),
        'slug' => (string)$article->slug(),
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
        'day' => $popup->day()->toInt(),
        'diff' => $next_popup_diff
    ];

  }
}


$json = ['lastUpdate' => (string)$page->lastUpdated(),
         'popups' => $popups_json,
         'next_popup' => $next_popup_json,
         'project' => $slug,
         'days' => $days,
        ];

echo json_encode($json);

