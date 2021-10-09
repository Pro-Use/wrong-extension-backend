<?php

class InvitePage extends Page
{
    public function invalidDate() {
//        $popups = $this->popups()->toStructure();
        $errors = false;
//        $f_timestamp = $this->from()->toDate();
//        $t_timestamp = $this->to()->toDate();
//        foreach($popups as $popup) {
//            if ($popup->date() != ""){
//                $p_timestamp = $popup->date()->toDate();
//                if ( $p_timestamp < $f_timestamp ||
//                        $p_timestamp > $t_timestamp) {
//                    $errors = true;
//                    break;
//                }
//            }
//        }
        return $errors;
    }
}