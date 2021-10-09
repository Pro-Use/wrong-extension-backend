<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
  <?=$page->invalidDate() ?>
  <h1><?= $page->title() ?></h1>
  <?php
    $popups = $page->popups()->toStructure();
    $win_id = 0;
    foreach($popups as $popup) {?>
    date = <?php var_dump($popup->date())?>
  <input type="button" value="<?=(string)$popup->url()?>"
            data-fs="<?=(string)$popup->fullscreen()?>"
            data-width="<?=(string)$popup->width()?>"
            data-height="<?=(string)$popup->height()?>"
            data-pos="<?=(string)$popup->position()?>"
            data-time="<?=(string)$popup->time()?>"
            data-ID="<?=$win_id?>"
            />
        <?php
        
        $win_id += 1;?>
  <br>
    <?php }
  ?>
  <script >
    const buttons = document.getElementsByTagName('input');
    console.log(buttons);
    for(let i=0;i<buttons.length;i++){
        buttons[i].addEventListener("click", function(){
            var settings = "";
            console.log(this.dataset);
            if (this.dataset.fs === "true"){
                settings = "fullscreen";
            } else {
                height = parseInt(this.dataset.height);
                width = parseInt(this.dataset.width);
                settings += "height="+height+",width="+width;
                const pos_arr = this.dataset.pos.split("-");
                console.log(pos_arr);
//                vertical
                if (pos_arr[0] === "top"){
                    settings += ",top="+0;
                } else if (pos_arr[0] === "mid") {
                    vPosition = (screen.height) ? (screen.height-height)/2 : 0;
                    settings += ",top="+vPosition;
                } else if (pos_arr[0] === "bottom"){
                    vPosition = screen.height-height;
                    settings += ",top="+vPosition;
                }
//                horizontal
                if (pos_arr[1] === "left") {
                    settings += ",left="+0;
                } else if (pos_arr[1] === "center") {
                    hPosition = (screen.width) ? (screen.width-width)/2 : 0;
                    settings += ",left="+hPosition;
                } else if (pos_arr[1] === "right"){
                    hPosition = screen.width-width;
                    settings += ",left="+hPosition;
                }
                console.log("settings:"+settings );
            }
            popup = window.open(this.value, "popup"+this.ID, settings);
        });
    };
  </script>
</body>
</html>
