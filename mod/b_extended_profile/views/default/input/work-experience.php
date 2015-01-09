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
echo '<br>Start Date: ' . elgg_view("input/text", array(
        'name' => 'startdate',
        'class' => 'gcconnex-work-experience-startdate',
        'value' => $work_experience->startdate));

// enter end date
echo 'End Date: ' . elgg_view("input/text", array(
        'name' => 'enddate',
        'class' => 'gcconnex-work-experience-enddate',
        'value' => $work_experience->enddate));

// enter responsibilities
echo '<br>Responsibilities: ' . elgg_view("input/text", array(
        'name' => 'responsibilities',
        'class' => 'gcconnex-work-experience-responsibilities',
        'value' => $work_experience->responsibilities));

// create a delete button for each work experience entry
echo '<br><div class="elgg-button elgg-button-action btn" onclick="deleteWorkExperience(this)">Delete this entry</div>';

echo '</div>'; // close div class="gcconnex-work-experience-entry"