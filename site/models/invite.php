<?php

class InvitePage extends Page
{
    public function returnDates() {
        $all_dates = [];
        $from = new DateTime($this->from()->toDate('Y-m-d'));
        $to = new DateTime($this->to()->toDate('Y-m-d'));
        for($i = $from; $i <= $to; $i->modify('+1 day')){
           $all_dates[] = $i->format("Y-m-d");
        }
        return $all_dates;
    }
}