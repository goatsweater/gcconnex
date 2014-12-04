<?php

if (elgg_is_xhr()) {  //This is an Ajax call!

    //$user_guid = $_GET["user"];
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    $work_guid = $user->work;
    $work = get_entity($work_guid);

    echo 'Name of organization: ' . elgg_view("input/text", array('name' => 'experience', 'class' => 'gcconnex-work-experience-organization', 'value' => $work->organization));
    echo '<br>Title: ' . elgg_view("input/text", array('name' => 'title', 'class' => 'gcconnex-work-experience-title', 'value' => $work->title));
    echo '<br>Start Date: ' . elgg_view("input/text", array('name' => 'startdate', 'class' => 'gcconnex-work-experience-startdate', 'value' => $work->startdate));
    echo 'End Date: ' . elgg_view("input/text", array('name' => 'enddate', 'class' => 'gcconnex-work-experience-enddate', 'value' => $work->enddate));
    echo '<br>Responsibilities: ' . elgg_view("input/longtext", array('name' => 'responsibilities', 'class' => 'gcconnex-work-experience-responsibilities', 'value' => $work->responsibilities));
    echo '<br>';

    $access_id = ACCESS_DEFAULT;
    $params = array(
        'name' => "accesslevel['education']",
        'value' => $access_id,
    );

    echo elgg_view('input/access', $params);
}

else {  // In case this view will be called via elgg_view()
    echo 'An error has occurred. Please ask the system administrator to grep: 3166881FADGYYY5';
}
?>