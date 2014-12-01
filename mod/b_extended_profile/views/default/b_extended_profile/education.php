<?php
?>

<div class="gcconnex-profile-section-wrapper gcconnex-education">
<div class="gcconnex-profile-title">Education</div>
    <?php if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
    echo '<span class="gcconnex-profile-edit-controls">';
        echo '<span class="edit-control edit-education"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">Edit</span>';
        echo '<span class="save-control save-education hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">Save</span>';
        echo '<span class="cancel-control cancel-education hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">Cancel</span>';
    echo '</span>';
        echo '    <div class="gcconnex-profile-education-display">';
        $user_guid = elgg_get_logged_in_user_guid();
        $user = get_user($user_guid);
        $education_guid = $user->education;
        $education = get_entity($education_guid);
        echo '<div class="gcconnex-profile-label education-dates">' . $education->startdate . ' - ' . $education->enddate . '</div>';

        echo ' <div class="gcconnex-profile-label education-school">' . $education->school . '</div>';
        echo '<div class="gcconnex-profile-label education-degree"><ul><li>' . $education->program . '</li></ul></div>';
        echo '<div class="gcconnex-profile-label education-field">' . $education->field . '</div>';
    }?>

    </div>
</div>