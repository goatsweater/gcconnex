<?php

if (elgg_is_xhr()) {  //This is an Ajax call!

    //$user_guid = $_GET["user"];
    $user_guid = $_GET["param"];
    $user = get_user($user_guid);

    $value = $user->education;



    echo 'School Name: ';

    $params = array(
        'name' => 'education',
        'value' => $value,
    );

    echo elgg_view("input/text", $params);

    echo 'Start Date: ' . elgg_view("input/datepicker", array('name' => 'startdate', 'value' => ''));
    echo 'End Date: ' . elgg_view("input/datepicker", array('name' => 'enddate', 'value' => ''));
    echo 'Program: ' . elgg_view("input/text", array('name' => 'program', 'value' => 'Friday'));
    echo 'Field of Study: ' . elgg_view("input/text", array('name' => 'fieldofstudy', 'value' => 'Friday'));



    $access_id = ACCESS_DEFAULT;
    $params = array(
        'name' => "accesslevel['education']",
        'value' => $access_id,
    );

    echo elgg_view('input/access', $params);
}

else {  // In case this view will be called via elgg_view()
    echo 'An error has occurred. Please ask the system administrator to find line number 32 in edit_education.php';
}
?>