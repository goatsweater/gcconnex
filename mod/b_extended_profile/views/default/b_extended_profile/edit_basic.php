<?php

$guid = elgg_get_logged_in_user_guid();
$user = get_user($guid);

$fields = array('name', 'title', 'department', 'phone', 'mobile', 'email', 'website', 'facebook', 'google', 'github',
    'twitter', 'linkedin', 'pinterest', 'tumblr', 'instagram', 'flickr', 'youtube');


foreach ($fields as $field) {

    $value = $user->get($field);

    echo '<br>' . $field . ': ';

    $params = array(
        'name' => $field,
        'class' => 'gcconnex-' . $field,
        'value' => $value,
    );

    echo elgg_view("input/text", $params);
}