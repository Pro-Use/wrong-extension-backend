<?php
	header("Access-Control-Allow-Origin: *");
	$json = ['about' => (string)$site->extAbout()];

	echo json_encode($json);