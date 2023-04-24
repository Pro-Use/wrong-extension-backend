<?php snippet('header'); ?>
<div class="container info">
    <div class="main">
<?php
    if ($kirby->user()) {
        snippet('popup_preview');  
    } 
?>
<?php 
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if ($id) {
        $popups = $page->popups()->toStructure();
        foreach($popups as $popup) {
            if ((string)base64_encode($popup->url()) == $id) { ?>
        <section id="popup-info" class="next-popup box fade green-shadow">
            <h2 class="box-header">Current</h2>
            <p id="popup-title" class="popup-title"><?=$popup->popup_title()?></p>
            <dl class="popup-details">
                <dt>Part of:</dt>
                <dd id="popup-set-title"><?= $page->popupSetTitle()?></dd>
            </dl>
            <div class="body-content">
                <?=$popup->popup_text()?>
            </div>
        </section>
        <section id="popup-info" class="next-popup box fade green-shadow">
            <h2 class="box-header"><?=$page->popupSetTitle()?></h2>
            <div class="body-content">
                <?=$page->popupSetText()->kt();?>
            </div>
        </section>
    <?php } } } ?>
    </div>
    <footer class="fade">
        <div class="contact-link-container">
            <a class="link-item" href="mailto:hello@arebyte.com">Contact</a>
        </div>
        <div class="wrong-footer">
            <a href="https://thewrong.org/" title="The Wrong biennale" target="_Blank">
            <img class="wrong-logo" alt="The Wrong Biennale" src="<?= $site->url();?>/assets/img/tw5_logo-B.png" width="90px" height="auto"/>
            </a>
        </div>
    </footer>
</div>

<div id="about" class="container about">
    <div class="main">
    <section id="popup-info" class="next-popup box red-shadow">
        <h2 class="box-header">arebyte Plugin</h2>
        <div class="body-content" id="about-text">
            <?= $site->extAbout();?>
        </div>
    </section>
    <section id="popup-info" class="next-popup box red-shadow">
        <h2 class="box-header">Credits</h2>
        <p class="popup-title">arebyte Plugin v2.0</p>
        <p class="credit-details">Developed by <a href="https://www.arebyte.com/" target="_Blank">arebyte</a>, 2021</p>
        <p class="credit-details">
        Plugin Design and Development: <br><a href="http://rob.prou.se" targe="_Blank">Rob Prouse</a> &  <a href="https://www.tommerrell.com" target="_Blank">Tom Merrell</a>
        </p>
        <p class="credit-details">All rights reserved to arebyte 2021</p>
    </section>
    </div>
</div>
<?php snippet('footer'); ?>
