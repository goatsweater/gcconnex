<?php
/**
 * Created by PhpStorm.
 * User: barndt
 * Date: 15/12/14
 * Time: 1:33 PM
 */


$education = get_entity($vars['guid']);

$guid = ($education != NULL)? $vars['guid'] : "new";

echo '<div class="gcconnex-education-entry" data-guid="' . $guid . '">';
echo 'School Name: ' . elgg_view("input/text", array('name' => 'education', 'class' => 'gcconnex-education-school', 'value' => $education->school));
echo '<br>Start Date: ' . elgg_view("input/text", array('name' => 'startdate', 'class' => 'gcconnex-education-startdate', 'value' => $education->startdate));
echo 'End Date: ' . elgg_view("input/text", array('name' => 'enddate', 'class' => 'gcconnex-education-enddate', 'value' => $education->enddate));
echo '<br>Program: ' . elgg_view("input/text", array('name' => 'program', 'class' => 'gcconnex-education-program', 'value' => $education->program));
echo '<br>Field of Study: ' . elgg_view("input/text", array('name' => 'fieldofstudy', 'class' => 'gcconnex-education-field', 'value' => $education->field));
echo '<br><div class="education-delete" onclick="deleteEducation(this)">Delete this entry</div>';
echo '</div>';