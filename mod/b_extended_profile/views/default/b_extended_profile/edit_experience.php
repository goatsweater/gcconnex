<?php

if (elgg_is_xhr()) {  //This is an Ajax call!

    //$user_guid = $_GET["user"];
    $user_guid = $_GET["param"];
    $user = get_user($user_guid);

    $value = $user->experience;



    echo 'Name of organization: ';

    $params = array(
        'name' => 'experience',
        'value' => $value,
    );

    echo elgg_view("input/text", $params);

    echo '<br>Title: ' . elgg_view("input/text", array('name' => 'title', 'value' => 'Friday'));
    echo '<br>Start Date: ' . elgg_view("input/text", array('name' => 'startdate', 'value' => ''));
    echo 'End Date: ' . elgg_view("input/text", array('name' => 'enddate', 'value' => ''));
    echo '<br>Responsibilities: ' . elgg_view("input/text", array('name' => 'responsibilities', 'value' => 'Friday'));
    echo '<br>';


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