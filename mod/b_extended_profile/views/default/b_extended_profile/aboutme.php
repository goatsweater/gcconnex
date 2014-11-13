<?php
?>
<div class="gcconnex-profile-section-wrapper gcconnex-about-me"><div class="gcconnex-profile-title">About Me</div>
    <?php
    if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
        echo '<span class="gcconnex-profile-edit-controls">';
        echo '<span class="edit-control edit-aboutme"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">Edit</span>';
        echo '<span class="save-control save-aboutme"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">Save</span>';
        echo '<span class="cancel-control cancel-aboutme"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">Cancel</span>';
        echo '</span>';
    }

    $user = elgg_get_page_owner_entity();
    $aboutme = $user->description;

    echo '<div class="gcconnex-profile-aboutme">' . $aboutme . '</div>'; ?>

</div>