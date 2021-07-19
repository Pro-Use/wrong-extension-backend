<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
  <h1><?= $page->title() ?></h1>
  <?php
    $data = $page->children()->published()->flip();


    foreach($data as $article) {

        var_dump($article);

    }
        
    
    ?>
</body>
</html>
