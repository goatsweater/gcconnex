<?php

?>

<div class="gcconnex-profile-section-wrapper gcconnex-endorsement-wrapper">
    <span class="gcconnex-profile-title">Endorsements</span>

    <?php if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
        echo '<span class="gcconnex-profile-edit-controls">';
        echo '<span class="edit-control edit-endorsements"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">Edit</span>';
        echo '<span class="save-control save-endorsements"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">Save</span>';
        echo '<span class="cancel-control cancel-endorsements"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">Cancel</span>';
        echo '</span>';
    }
    ?>
    <div class="gcconnex-endorsement-skills-list-wrapper"></div>
    <div class="endorsements-message"></div>
</div>