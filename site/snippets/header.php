<!DOCTYPE html>
  <html>
    <head>
        <meta charset="UTF-8">
        <title><?=$page->title()." - ".$page->popupSetTitle()?></title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="https://use.typekit.net/red3rnv.css">
        <?= css('assets/css/style.css') ?>
    </head>
    <body class="body">
    <div class="page-container">
      <div class="app-body">
        <header class="header">
          <h1 class="main-title">
            <a href="https://www.arebyte.com/" title="Arebyte" target="_Blank">
            <img class="arebyte-logo" alt="Arebyte" src="<?= $site->url();?>/assets/img/arebyte-Plugin-blue.png" width="176px" height="auto"/>
            </a>
          </h1>
          <nav class="menu">
            <a id="page-toggle" href="#about" class="link-item">About</a>
          </nav>
        </header>