<?php

Kirby::plugin('robprouse/validate-popups', [ 
    'hooks' => [
        'page.update:after' => function ($newPage) {
            $site = $this->site();
            $page = $site->pages()->findById($newPage->id());
            $popups = $page->popups()->toStructure();
            $errors = 'false';
            $f_timestamp = $page->from()->toDate();
            $t_timestamp = $page->to()->toDate();
            foreach($popups as $popup) {
                if ($popup->date() != ""){
                    $p_timestamp = $popup->date()->toDate();
                    if ( $p_timestamp < $f_timestamp ||
                            $p_timestamp > $t_timestamp) {
                        $errors = 'true';
                        break;
                    }
                }
            }
            $page->update(['dateError'=>$errors]);
//            $page->update(['test'=>'testing']);
        }
      ],
]);

