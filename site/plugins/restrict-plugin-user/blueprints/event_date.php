<?php

	// $max_days = $page->days;
	$url = $kirby->urls()->current();
	preg_match("/\/pages\/([a-zA-Z0-9+-]+)\/?/", $url, $result);
    $pageSlug = str_replace('+', '/', $result[1]);
    $page = $kirby->page($pageSlug);
    $start_date = $page->from();
    $to = new DateTime($start_date, new DateTimeZone('Europe/London'));
    $to->modify(sprintf("%u day",$page->days()->toInt()));
	$yaml = [
	      'label' => 'Date of event',
	      'type'=> 'date',
	      'min'=> $start_date->toDate('Y-m-d'),
	      'max'=> $to->format('Y-m-d'),
	      'width'=> '1/7',
	      'help'=> "Must be a date between ". $start_date->toDate('d/m/Y')." and " . $to->format('d/m/Y')
	  ];

	return $yaml;