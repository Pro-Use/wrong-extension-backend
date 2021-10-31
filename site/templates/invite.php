<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$page->title()." - ".$page->popupSetTitle()?></title>
</head>
<body>
<?php 
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if ($id) {
        $popups = $page->popups()->toStructure();
        foreach($popups as $popup) {
            if ((string)base64_encode($popup->url()) == $id) {?>
        <div>
            <h1><?=$page->title()." - ".$page->popupSetTitle()?></h1>
            <h2><?=$popup->popup_title()?></h2>
            <div>
                <?=$popup->popup_text()?>
            </div>
            <h2>About the exhibition:</h2>
            <div>
                <?=$page->popupSetText()?>
            </div>
        </div>

           <?php }
        }
    } else {
        if ($kirby->user()) {
            snippet('popup_preview');  
        } 
    }

?>
</body>
</html>
