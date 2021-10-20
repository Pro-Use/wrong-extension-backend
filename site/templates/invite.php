<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<?php if ($kirby->user()) {
    snippet('popup_preview');  
} else {
//    $urlhash = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
//    $url = base64_decode($urlhash);
//    $popups = $page->popups()->toStructure();
//    foreach($popups as $popup) {
//        if ($popup->url() == $url){
//            echo $popup->url();?>
            <iframe src="//<?=$url?>"
                frameborder="0" 
                marginheight="0" 
                marginwidth="0" 
                width="100%" 
                height="100%" 
                scrolling="auto"></iframe >
            //<?php break;
//        }
//    }
}
?>
</body>
</html>
