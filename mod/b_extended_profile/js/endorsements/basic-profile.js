$(window).load(function() {
    $(".gcconnex-basic-profile-edit").fancybox({
        autoDimensions: false,
        width: '852px',
        height: '550px'
    })
});
/*
$(document).load(function() {
    var userName = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: elgg.get_site_url() + "userfind?query=%QUERY",
            filter: function (response) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(response, function (user) {
                    return {
                        value: user.value,
                        guid: user.guid,
                        pic: user.pic,
                        avatar: user.avatar,
                        tid: tid
                    };
                });
            }
        }
    });

    // initialize bloodhound engine for colleague auto-suggest
    userName.initialize();

    var userSearchField = $('.gcconnex-my-manager').typeahead(null, {
        name: 'my-manager',
        displayKey: function (user) {
            return user.value;
        },
        limit: Infinity,
        //source: userName.ttAdapter(),
        source: function (query, cb) {
            userName.get(query, function (suggestions) {
                cb(filter(suggestions, tidName));
            });
        },
        templates: {
            suggestion: function (user) {
                return '<p>' + user.pic + '<span class="tt-suggest-username">' + user.value + '</span></p>';
            }
        }
    })
});
    */