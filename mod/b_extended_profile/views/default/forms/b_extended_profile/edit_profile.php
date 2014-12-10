<?php

$guid = elgg_get_logged_in_user_guid();
$user = get_user($guid);

$fields = array('Name', 'Title', 'Department', 'Phone', 'Mobile', 'Email', 'Website', 'Facebook', 'Google', 'GitHub',
    'Twitter', 'Linkedin', 'Pinterest', 'Tumblr', 'Instagram', 'Flickr', 'Youtube');

echo '<h1>Edit Basic Profile</h1>';

foreach ($fields as $field) {

    echo '<br>' . $field . ': ';
    $field = strtolower($field);
    $value = $user->get($field);

    $params = array(
        'name' => $field,
        'class' => 'gcconnex-basic-' . $field,
        'value' => $value,
    );

    echo elgg_view("input/text", $params);
}

$__elgg_ts = time();
$__elgg_token = generate_action_token($__elgg_ts);


echo elgg_view('input/button', array('type' => 'submit', 'value' => 'Save', 'target' => 'edit_extended_profile'));