<?php
/*
 * Author: Bryden Arndt
 * Date: 01/09/2015
 * Time: 1:33 PM
 * Purpose: This is a collection of input fields that are grouped together to create an entry for work experience (designed to be entered for a user's profile).
 */


$work_experience = get_entity($vars['guid']); // get the guid of the work experience entry that is being requested for display

$guid = ($work_experience != NULL)? $vars['guid'] : "new"; // if the work experience guid isn't given, this must be a new entry

echo '<div class="gcconnex-work-experience-entry" data-guid="' . $guid . '">'; // work experience entry wrapper for css styling

// enter organization name
echo 'Name of Organization: ' . elgg_view("input/text", array(
        'name' => 'work-experience',
        'class' => 'gcconnex-work-experience-organization',
        'value' => $work_experience->organization));

// enter title
echo '<br>Title: ' . elgg_view("input/text", array(
        'name' => 'title',
        'class' => 'gcconnex-work-experience-title',
        'value' => $work_experience->title));

// enter start date
echo '<br>Start Date: ' . elgg_view("input/pulldown", array(
        'name' => 'startdate',
        'class' => 'gcconnex-work-experience-startdate',
        'options' => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
        'value' => $work_experience->startdate));

echo 'Year: ' . elgg_view("input/text", array(
        'name' => 'start-year',
        'class' => 'gcconnex-work-experience-start-year',
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $work_experience->startyear));

// disable the end dates if the user is still currently working here

$params = array(
    'name' => 'enddate',
    'class' => 'gcconnex-work-experience-enddate gcconnex-work-experience-enddate-' . $work_experience->guid,
    'options' => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
    'value' => $work_experience->enddate);
if ($work_experience->ongoing == 'true') {
        $params['disabled'] = 'true';
}

echo '<br>End Date: ' . elgg_view("input/pulldown", $params);

unset($params);


$params = array('name' => 'end-year',
        'class' => 'gcconnex-work-experience-end-year gcconnex-work-experience-end-year-' . $work_experience->guid,
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $work_experience->endyear);
if ($work_experience->ongoing == 'true') {
        $params['disabled'] = 'true';
}

echo 'Year: ' . elgg_view("input/text", $params);

unset($params);

$params = array(
    'name' => 'ongoing',
    'class' => 'gcconnex-work-experience-ongoing',
    'onclick' => 'toggleEndDate(' . $work_experience->guid . ')',
);
if ($work_experience->ongoing == 'true') {
        $params['checked'] = $work_experience->ongoing;
}

echo  '<label>' . elgg_view('input/checkbox', $params);
echo 'I still work here</label>';

// enter responsibilities
echo '<br>Responsibilities: ' . elgg_view("input/textarea", array(
        'name' => 'responsibilities',
        'id' => 'textarea',
        'class' => 'gcconnex-work-experience-responsibilities',
        'value' => $work_experience->responsibilities));

// create a delete button for each work experience entry
echo '<br><div class="elgg-button elgg-button-action btn" onclick="deleteEntry(this)" data-type="work-experience">Delete this entry</div>';

echo '</div>'; // close div class="gcconnex-work-experience-entry"
?>