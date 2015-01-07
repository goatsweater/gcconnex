<style>
    body {
        font-family: arial;
    }
    .c_table {
        border:1px solid #ccc;
        background-color: orangered;
        width: 600px;
    }

    h1 {
        padding: 0px;
        margin: 0px;
        color: #3c698e;
    }

    .basic-profile-label {
        margin: 5px;
        float: left;
        text-align: right;
        width: 120px;
    }

    .social-media-label {
        float: inherit;
        text-align: left;
    }

    .basic-profile-field {
        margin: 3px;
    }

    .table th,td {
        padding:10px;
    }


    .c_table {
        border: 1px solid;
        margin: 5px 0px;
        padding:0px 10px 0px 10px;
        width: 100%;
        background-repeat: no-repeat;
        background-position: 10px center;
        color: #00529B;
        background-color: #BDE5F8;
        background-image: url('info.png');
    }

    .input-group-addon {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #EEE;
        border: 1px solid #CCC;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        display: table-cell;
        white-space: nowrap;
        vertical-align: middle;
        float: left;
    }

    .input-group {
        border-collapse: separate;
    }

    .basic-profile {
        width: 100%;
        height: 100%;
    }

    .basic-profile-standard-field-wrapper,
    .basic-profile-social-media-wrapper,
    .basic-profile-micro-assignments {
        width: 375px;
        float: left;
    }

    .social-media-field-wrapper {
    }

    .gcconnex-basic-field {
        width: 150px;
        height: 28px;
    }
    .submit-basic-profile {
        width: 100%;
    }

</style>


<?php

$guid = elgg_get_logged_in_user_guid();
$user = get_user($guid);

$fields = array('Name', 'Title', 'Department', 'Phone', 'Mobile', 'Email', 'Website');

echo '<h1>Edit Basic Profile</h1>';
echo '<div class="basic-profile">';
echo '<div class="basic-profile-standard-field-wrapper">';


foreach ($fields as $field) {

    echo '<div class="basic-profile-field-wrapper">';

    echo '<br><div class="basic-profile-label ' . $field . '-label">' . $field . ': </div>';
    $field = strtolower($field);
    $value = $user->get($field);

    $params = array(
        'name' => $field,
        'class' => 'gcconnex-basic-' . $field,
        'value' => $value,
    );

    echo '<div class="basic-profile-field">';
    echo elgg_view("input/text", $params);
    echo '</div>'; //close div class = basic-profile-field
    echo '</div>'; //close div class = basic-profile-field-wrapper
}

echo '</div>';

echo '<div class="basic-profile-social-media-wrapper">';

// setup the social media fields
$fields = array('Facebook' => "http://www.facebook.com/", 'Google' => "http://www.google.com/+", 'GitHub' => "https://github.com/",
    'Twitter' => "https://twitter.com/", 'Linkedin' => "http://ca.linkedin.com/in/", 'Pinterest' => "http://www.pinterest.com/",
    'Tumblr' => "https://www.tumblr.com/blog/", 'Instagram' => "http://instagram.com/", 'Flickr' => "http://flickr.com/", 'Youtube' => "http://www.youtube.com/");

foreach ($fields as $field => $field_link) {

    echo '<div class="basic-profile-field-wrapper social-media-field-wrapper">';
    echo '<br><div class="basic-profile-label social-media-label ' . $field . '-label">' . $field . ': </div>';

    $field = strtolower($field);
    $value = $user->get($field);

    echo '<div class="input-group">';
    echo '<span class="input-group-addon">' . $field_link . "</span>";
    $params = array(
        'name' => $field,
        'class' => 'form-control gcconnex-basic-field gcconnex-basic-' . $field,
        'placeholder' => 'Username',
        'value' => $value
    );

    echo elgg_view("input/text", $params);
    echo '</div>';
    echo '</div>'; // close div class = basic-profile-field-wrapper
}

echo '</div>';
echo '<div class="basic-profile-micro-assignments">';

echo elgg_view('input/checkbox', array('name' => 'micro', 'checked' => ($user->micro == "on") ? "on" : FALSE));
echo 'I would like to opt-in to micro-assignments';
echo '</div>';

echo '<div class="submit-basic-profile">';
echo elgg_view('input/button', array('type' => 'submit', 'value' => 'Save'));
echo '</div>';
echo '</div>';