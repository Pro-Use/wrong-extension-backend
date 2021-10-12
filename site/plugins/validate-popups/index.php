<?php

Kirby::plugin('robprouse/validate-popups', [ 
    'hooks' => [
        'page.update:after' => function ($newPage, $oldPage) {
            $popups = $newPage->popups()->toStructure();
            $errors = 'false';
            $f_timestamp = $newPage->from()->toDate();
            $t_timestamp = $newPage->to()->toDate();
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
//            $newPage->dateError() = $errors;
        }
      ],
]);

