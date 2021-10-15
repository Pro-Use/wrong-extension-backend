<?php

Kirby::plugin('robprouse/validate-popups', [ 
    'hooks' => [
       'page.update:after' => function ($newPage) {
           $site = $this->site();
           $page = $site->pages()->findById($newPage->id());
           $popups = $page->popups()->toStructure();
           $popups_yaml = $page->popups()->yaml();
           $popup_num = 0;
           $errors = 0;
           $f_timestamp = $page->from()->toDate();
           $t_timestamp = $page->to()->toDate();
           $error_text = "ERROR: ";
            foreach($popups as $popup) {
                if ($popup->date() != ""){
                    $p_timestamp = $popup->date()->toDate();
                    if ( $p_timestamp < $f_timestamp ||
                            $p_timestamp > $t_timestamp) {
                        $errors += 1;
                        $error_text .= " Popup '" . $popup->url() . "' has an invalid date, it must be between " . $page->from() . " and " . $page->to();
                        $popups_yaml[$popup_num]['errors'] = "Date must be between " . $page->from() . " and " . $page->to();
                    } else {
                        $popups_yaml[$popup_num]['errors'] = "";
                    }
                    $page->update(['popups' => yaml::encode($popups_yaml)]);
                }
                $popup_num += 1;
            }
            if ($errors > 0) {
                $page->update(['dateErrorText'=>$error_text]);
                // return $error_text;
            } else {
                $page->update(['dateErrorText'=>'']);
            }
       }
      ],
]);

