<?php
$user_guid = $_GET["user"];
$skills = $_GET["skills"];

$user = new ElggUser;
$user->guid = $user_guid;

echo 'Skill: ' . $skills . $user->name;