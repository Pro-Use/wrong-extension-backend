<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<?php if ($kirby->user()) {
    snippet('popup_preview');  
} else {
    $popup_id = filter_input(INPUT_GET, 'puid', FILTER_SANITIZE_URL);
    if (isset($popup_id)) {
        echo $popup_id;
    }
}
?>
</body>
</html>
