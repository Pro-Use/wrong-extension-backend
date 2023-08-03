<?php

	// $max_days = $page->days;
	$url = $kirby->urls()->current();
	preg_match("/\/pages\/([a-zA-Z0-9+-]+)\/?/", $url, $result);
    $pageSlug = str_replace('+', '/', $result[1]);
    $max_days = $kirby->page($pageSlug)->days();

	$yaml = [
	      'label' => 'Day in the sequence to launch this popup',
	      'type'=> 'number',
	      'min'=> 1,
	      'max'=> $max_days->toInt(),
	      'width'=> '1/7',
	      'help'=> "Must be a date between 1 and " . $max_days
	  ];

	return $yaml;