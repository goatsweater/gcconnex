<?php
?>

<div class="gcconnex-profile-section-wrapper gcconnex-education">
<div class="gcconnex-profile-title">Education</div>
    <?php if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
    echo '<span class="gcconnex-profile-edit-controls">';
    echo '<span class="edit-control edit-education"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">Edit</span>';
    echo '<span class="save-control save-education"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">Save</span>';
    echo '<span class="cancel-control cancel-education"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">Cancel</span>';
    echo '</span>';
}?>

<div class="gcconnex-profile-label education-dates">2002-2009</div>
<div class="gcconnex-profile-label education-school">Algonquin College</div>
<div class="gcconnex-profile-label education-degree"><ul><li>Computer Engineering Technology</li></ul></div>
<div class="gcconnex-profile-label education-field">Computer Sciences</div>
</div>