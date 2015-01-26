<?php
/*
 * Author: Bryden Arndt
 * Date: January 26, 2015
 * Purpose: Provide search results to skills auto-suggest
 */

$skills[] = 'test';
$skills[] = 'bryden';
$skills[] = 'tyson';
$skills[] = 'daniel';
$skills[] = 'matthew';
$skills[] = 'anjali';
$skills[] = 'algonquin';
$skills[] = 'two words';
$skills[] = 'mike tyson';
$skills[] = 'anjali wildgen';
$skills[] = 'bryden arndt';
$skills[] = 'daniel arndt';
$skills[] = 'tyson arndt';
$skills[] = 'matthew arndt';

$query = htmlspecialchars($_GET['query']);
$result = array();

foreach ($skills as $s) {
    if (strpos($s, $query) !== FALSE) {
        $result[] = array('value' => $s);
    }
}

echo json_encode($result);

