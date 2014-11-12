/*
 * Purpose: Provides 'LinkedIn-like endorsements' functionality for use on user profiles
 *
 * License: GPL v2.0
 * Full license here: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Author: Bryden Arndt
 * email: bryden@arndt.ca
 */

/*
 * Purpose: initialize the script
 */
$(document).ready(function() {
    // initialize errythan
    // hide some of the toggle elements
    $('.save-control').hide();
    $('.cancel-control').hide();

    $('.edit-endorsements').click(editEndorsements);
    $('.save-endorsements').click(saveEndorsements);
    $('.cancel-endorsements').click(cancelEndorsements);

    $('.edit-education').click(editEducation);
    $('.save-education').click(saveEducation);
    $('.cancel-education').click(cancelEducation);

    $('.edit-experience').click(editExperience);
    $('.save-experience').click(saveExperience);
    $('.cancel-experience').click(cancelExperience);

    // when a user clicks outside of the text box (the one for entering new skills), make it disappear elegantly
    $(document).click(function(event) {
        if(!$(event.target).closest('.gcconnex-endorsement-input-wrapper').length) {
            if($('.gcconnex-endorsement-input-skill').is(":visible")) {
                $('.gcconnex-endorsement-input-skill').hide();
                $('.gcconnex-endorsement-add-skill').fadeIn('slowly');
            }
        }
    });
});

/*
 * Purpose: Turn editing capabilities on
 */
function editEndorsements() {
    // inject the html to add ability to add skills
    $('.gcconnex-endorsement-wrapper').append('<div class="gcconnex-endorsement-input-wrapper">' +
    '<input type="text" class="gcconnex-endorsement-input-skill" onkeyup="checkForEnter(event)"/>' +
    '<span class="gcconnex-endorsement-add-skill">+ add new skill</span>' +
    '</div>');
    // hide the text box which is only to be shown when toggled by the link
    $('.gcconnex-endorsement-input-skill').hide();

    // the profile owner would like to type in a new skill
    $('.gcconnex-endorsement-add-skill').click(function () {
        $('.gcconnex-endorsement-input-skill').fadeIn('slowly').focus() ;
        $('.gcconnex-endorsement-add-skill').hide();
    });

    // hide the edit, show the save icon
    $('.edit-endorsements').hide();
    $('.save-endorsements').show();
    $('.cancel-endorsements').show();

    $('.gcconnex-endorsement-add').hide();
    $('.gcconnex-endorsement-retract').hide();
    $('.delete-skill').show();
}

/*
 * Purpose: Do nothing with the changes made to the skills list
 */
function cancelEndorsements() {
    $('.gcconnex-endorsement-input-wrapper').remove();

    $('.save-endorsements').hide();
    $('.cancel-endorsements').hide();
    $('.edit-endorsements').show();

    $('.delete-skill').hide();
    $('.gcconnex-endorsement-skill-wrapper').removeClass('endorsement-markedForDelete');

    $('.gcconnex-endorsement-skill-wrapper').show();
    $('.temporarily-added').remove();
}

/*
 * Purpose: Save any changes made to the skills in the list (added/deleted skills)
 */
function saveEndorsements() {
    $('.gcconnex-endorsement-input-wrapper').remove();

    $('.save-endorsements').hide();
    $('.cancel-endorsements').hide();
    $('.edit-endorsements').show();

    $('.delete-skill').hide();

    var skillsToAdd = [];

    $(".temporarily-added .gcconnex-endorsement-skill").each(function() {
        skillsToAdd.push($(this).text())
    });

    if(confirm("Are you sure you would like to save changes? Any endorsements for skills that you have removed will be permanently deleted.")) {
        // this is where skills are deleted (if they have been marked for deletion by the user)
        $('.gcconnex-endorsement-skill-wrapper').removeClass('temporarily-added');
        $('.endorsement-markedForDelete').remove();
    }
    else {
        // show() the skills that have been hidden() (marked for deletion)
        $('.gcconnex-enxorsement-skill-wrapper').show();
    }

    $.ajaxSetup ({
        cache: false
    });

    // prep the skills array
    var pathname = '../mod/b_extended_profile/saveEndorsements.php';
    var user =  elgg.get_page_owner_guid();
    // save functions
    $('.endorsements-message')
        .html('loading, please standby')
        .load(pathname, 'user=' + user + 'skills=' + skillsToAdd);
    // @todo: show add or retract links based on status of endorsement
}

/*
 * Purpose: Listen for the enter key in the "add new skill" text box
 */
function checkForEnter(event) {
    if (event.keyCode == 13) { // 13 = 'Enter' key

        // The new skill being added, as entered by user
        var newSkill = $('.gcconnex-endorsement-input-skill').val().trim();
        // @todo: do data validation to ensure css class-friendly naming (ie: no symbols)
        // @todo: add a max length to newSkill
        addNewSkill(newSkill);
    }
}

/*
 * Purpose: append a new skill to the bottom of the list
 */
function addNewSkill(newSkill) {

    var newSkillDashed = newSkill.replace(/\s+/g, '-'); // replace spaces with '-' for css classes

    // @todo: cap the list of skills at ~8-10 in order not to have "too many" on each profile
    // inject HTML for newly added skill
    $('.gcconnex-endorsement-skills-list-wrapper').append('<div class="gcconnex-endorsement-skill-wrapper temporarily-added">' +
    '<span title="Number of endorsements" class="gcconnex-endorsement-count endorsement-count-' +
    newSkillDashed +
    '">0</span>' +
    '<span title="Test" class="gcconnex-endorsement-skill">' +
    newSkill +
    '</span>' +
    '<span title="Endorse this skill" class="gcconnex-endorsement-add add-endorsement-' +
    newSkillDashed +
    '">+</span>' +
    '<span title="Remove your endorsement for this skill" class="gcconnex-endorsement-retract retract-endorsement-' +
    newSkillDashed +
    '">-</span><span class="delete-skill delete-' +
    newSkillDashed +
    '">Delete this skill</span></div>');

    $('.gcconnex-endorsement-input-skill').val('');                                 // clear the text box
    $('.gcconnex-endorsement-input-skill').hide();                                  // hide the text box
    $('.add-endorsement-' + newSkillDashed).hide();                                 // hide the '+' button
    $('.retract-endorsement-' + newSkillDashed).hide();                             // hide the '-' button
    $('.gcconnex-endorsement-add-skill').show();                                    // show the 'add a new skill' link
    $('.add-endorsement-' + newSkillDashed).on('click', addEndorsement);            // bind the addEndoresement function to the '+'
    $('.retract-endorsement-' + newSkillDashed).on('click', retractEndorsement);    // bind the retractEndorsement function to the '-'
    $('.delete-' + newSkillDashed).on('click', deleteSkill);                        // bind the deleteSkill function to the 'Delete this skill' link
}

/*
 * Purpose: Increase the endorsement count by one, for a specific skill for a specific user
 */
function addEndorsement() {
    // A user is endorsing a skill! Do stuff about it..
    var targetSkill = $(this).siblings('.gcconnex-endorsement-skill').text(); //.text();
    var targetSkillDashed = targetSkill.replace(/\s+/g, '-'); // replace spaces with '-' for css classes

    $('.add-endorsement-' + targetSkillDashed).hide();
    $('.retract-endorsement-' + targetSkillDashed).show();

    var endorse_count = $('.endorsement-count-' + targetSkillDashed).val();
    endorse_count++;
    $('.endorsement-count-' + targetSkillDashed).val(endorse_count);

    // @todo: add the endorsing user's profile image to the list of endorsers for this skill
}

/*
 * Purpose: Retract a previous endorsement for a specific skill for a specific user
 */
function retractEndorsement() {
    // A user is retracting their endorsement for a skill! Do stuff about it..
    var targetSkill = $(this).siblings('.gcconnex-endorsement-skill').text(); //.text();
    var targetSkillDashed = targetSkill.replace(/\s+/g, '-'); // replace spaces with '-' for css classes

    $('.add-endorsement-' + targetSkillDashed).show();
    $('.retract-endorsement-' + targetSkillDashed).hide();

    var endorse_count = $('.endorsement-count-' + targetSkillDashed).val();
    endorse_count--;
    $('.endorsement-count-' + targetSkillDashed).val(endorse_count);
}

/*
 * Purpose: Delete a skill from the list of endorsements
 */
function deleteSkill() {
    // We don't _actually_ delete anything yet, since the user still has the ability to click 'Cancel'
    // instead, we just hide the skill until the user clicks on 'Save'. See the 'saveChanges' function for
    // the actual code where skills are permanently deleted.
    $(this).parent('.gcconnex-endorsement-skill-wrapper').addClass('endorsement-markedForDelete').hide();
}

/*
 * Purpose: Edit the education section in order to add, edit or delete entries
 */
function editEducation() {
    // Edit the edumacation
    $('.education-dates').hide();
    $('.education-school').hide();
    $('.education-degree').hide();
    $('.education-field').hide();

    // toggle edit controls
    $('.edit-education').hide();
    $('.save-education').show();
    $('.cancel-education').show();

    // inject the html form for editing education entries/adding new entries
    $('.gcconnex-education').append('<div>TEST</div>');

}

/*
 * Purpose: 
 */
function cancelEducation() {
    //$('.gcconnex-endorsement-input-wrapper').remove();

    $('.save-education').hide();
    $('.cancel-education').hide();
    $('.edit-education').show();

    //$('.delete-skill').hide();
    //$('.gcconnex-endorsement-skill-wrapper').removeClass('education-markedForDelete');

    //$('.gcconnex-endorsement-skill-wrapper').show();
    $('.temporarily-added').remove();
}

/*
 * Purpose
 */
function saveEducation() {

}