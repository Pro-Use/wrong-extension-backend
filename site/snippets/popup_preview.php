<section id="popup-info" class="next-popup box fade red-shadow">
    <h2 class="box-header">TEST BUTTONS: Visible to curators / admin uses only</h2>
    <p class="body-content"> Use the buttons here to preview the pop windows in this series: </p>
    <?php
    $popups = $page->popups()->toStructure();
    $win_id = 0;
    foreach($popups as $popup) {
        $id = base64_encode($popup->url());
        ?>
  <input type="button" value="<?=(string)$popup->url()?>"
            data-fs="<?=(string)$popup->fullscreen()?>"
            data-width="<?=(string)$popup->width()?>"
            data-height="<?=(string)$popup->height()?>"
            data-pos="<?=(string)$popup->position()?>"
            data-time="<?=(string)$popup->time()?>"
            data-info="<?=(string)$page->url().'?id='.$id?>"
            data-ID="<?=$win_id?>"
            data-trigger="page"

            />
        <?php
        
        $win_id += 1;?>
  <br>
    <?php }
  ?>
</section>
 
  <script >
    const buttons = document.getElementsByTagName('input');
    console.log(buttons);
    for(let i=0;i<buttons.length;i++){
        buttons[i].addEventListener("click", open_popup)
    };

    function open_popup(){
        if (this.dataset.trigger == "page") {
            // info window
            var settings = "menubar=0,toolbar=0,location=0,status=0,width=400,height=400";
            height = 400;
            width = 400;
            vPosition = (screen.height) ? (screen.height-height)/2 : 0;
            settings += ",top="+vPosition;
            hPosition = (screen.width) ? (screen.width-width)/2 : 0;
            settings += ",left="+hPosition;
            window.open(this.dataset.info, "_blank", settings);
            // popup
            var settings = "menubar=0,toolbar=0,location=0,status=0,";
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
            window.open(this.value, "_blank", settings);
        }
    };
  </script>

