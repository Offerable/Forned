var Brightery = angular.module('BrighteryFacebookBusinessScraper', ['ngSanitize', 'AxelSoft']);
Brightery.controller('mainCtrl', function ($scope, $http, filterFilter) {
    $scope.error = function (message) {
        $scope.template = 'templates/message.html';
        $scope.SystemMessage = message;
        $("#popup").modal();
        $scope.loading = false;
    };

    $scope.searchAsync = function (term) {
        return $http({
            url: 'api/facebook/autocomplete',
            method: 'post',
            data: {query: term, accessToken: $scope.form.accessToken}
        }).then(function (res) {
            return res.data.data;
        });
    };

    // Get App Setup
    $scope.setup = function () {
        $scope.appId = {};

        $http({
            url: 'http://ip.brightery.com.eg'
        }).then(function (res) {
            $scope.country = res.data.country;
            window.latlng = res.data.lat + ',' + res.data.lon;
            $scope.searchTerm = res.data.country;
        });
        $http({
            url: 'api/configurations/get'
        }).then(function (res) {

            if (res.data.error) {
                $scope.error("<span>" + res.data.message + "</span>");
            }

            $scope.appId = res.data.data.app_id;

            window.fbAsyncInit = function () {
                FB.init({
                    appId: $scope.appId,
                    xfbml: true,
                    version: 'v2.6'
                });

                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {
                        $scope.form.accessToken = response.authResponse.accessToken;
                        $scope.login_status = true;
                    }
                });

            };

            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

        });
    };
    $scope.setup();
    $scope.types = [
        {
            name: "Page",
            icon: "fa-flag",
            raw: "page",
            columns: [
                {raw: 'id', name: 'ID', checked: true},
                {raw: 'name', name: 'Name', checked: true},
                {raw: 'single_line_address', name: 'Address', checked: true},
                {raw: 'phone', name: 'Phone', checked: true},
                {raw: 'emails', name: 'Emails', checked: true},
                {raw: 'website', name: 'Website', checked: true},
                {raw: 'fan_count', name: 'Likes', checked: true},
                {raw: 'link', name: 'Link', checked: true, merge: true},
                {raw: 'is_verified', name: 'Verified', checked: true, merge: true},
                {raw: 'about', name: 'About', checked: false},
                {raw: 'picture', name: 'Picture', checked: false},
            ],
        },
        {
            name: "Place",
            icon: "fa-map-marker",
            raw: "place",
            columns: [
                {raw: 'id', name: 'ID', checked: true},
                {raw: 'name', name: 'Name', checked: true},
                {raw: 'location', name: 'Location', checked: true},
            ],
        },
        {
            name: "Group",
            icon: "fa-group",
            raw: "group",
            columns: [
                {raw: 'id', name: 'ID', checked: true},
                {raw: 'name', name: 'Name', checked: true},
                {raw: 'icon', name: 'Icon', checked: true, merge: true},
                {raw: 'description', name: 'Description', checked: true},
                {raw: 'email', name: 'Email', checked: true},
                {raw: 'privacy', name: 'Privacy', checked: true},
                {raw: 'cover', name: 'Cover', checked: true, merge: true},
                {raw: 'members', name: 'Members', checked: true},
            ],
        },
        {
            name: "User",
            icon: "fa-user",
            raw: "user",
            columns: [
                {raw: 'id', name: 'ID', checked: true},
                {raw: 'name', name: 'Name', checked: true},
                {raw: 'birthday', name: 'Birthday', checked: false},
                {raw: 'email', name: 'Email', checked: true},
                {raw: 'gender', name: 'Gender', checked: false},
                {raw: 'interested_in', name: 'Interested in', checked: false},
                {raw: 'is_verified', name: 'Verified', checked: true, merge: true},
                {raw: 'link', name: 'Link', checked: false, merge: true},
                {raw: 'location', name: 'Location', checked: false},
                {raw: 'meeting_for', name: 'Meeting for', checked: false},
                {raw: 'religion', name: 'Religion', checked: false},
                {raw: 'relationship_status', name: 'Relationship Status', checked: false},
                {raw: 'website', name: 'Website', checked: false},
                {raw: 'work', name: 'Work', checked: false},
                {raw: 'cover', name: 'Cover', checked: true, merge: true},
                {raw: 'devices', name: 'Devices', checked: false},
                {raw: 'education', name: 'Education', checked: false},
                {raw: 'hometown', name: 'Hometown', checked: false},
                {raw: 'languages', name: 'Languages', checked: false},
                {raw: 'picture', name: 'Picture', checked: false, merge: true},
                {raw: 'age_range', name: 'Age Range', checked: false},
            ],
        },
        {
            name: "Event",
            icon: "fa-calendar",
            raw: "event",
            columns: [
                {raw: 'id', name: 'ID', checked: true},
                {raw: 'name', name: 'Name', checked: true},
                {raw: 'attending_count', name: 'Attending', checked: true},
                {raw: 'noreply_count', name: 'No Reply', checked: true},
                {raw: 'maybe_count', name: 'Maybe', checked: true},
                {raw: 'interested_count', name: 'Interested', checked: true},
                {raw: 'declined_count', name: 'Declined', checked: true},
                {raw: 'owner', name: 'Owner', checked: false},
                {raw: 'place', name: 'Place', checked: true},
                {raw: 'category', name: 'Category', checked: true},
                {raw: 'can_guests_invite', name: 'Guests Can Invite', checked: false},
                {raw: 'cover', name: 'Cover', checked: true, merge: true},
                {raw: 'start_time', name: 'Start time', checked: true},
                {raw: 'end_time', name: 'End time', checked: true},
                {raw: 'type', name: 'Type', checked: false},
                {raw: 'ticket_uri', name: 'Ticket URL', checked: false},
            ],
        },
    ];
    $scope.form = {type: 'page', custom_fields: {}};
    $scope.login_status = false;
    $scope.items = [];
    $scope.selectType = function (type) {
        $scope.form.type = type.raw;
        $scope.items = [];
    };
    $scope.settings = function () {
        $scope.template = 'templates/settings.html';
        $("#popup").modal();
        $scope.form.type;
    };
    $scope.typeFields = function () {
        return $scope.types.filter(function (x) {
            return x.raw == $scope.form.type;
        })[0].columns;
    };
    $scope.results = function () {
        return filterFilter($scope.items, $scope.filterEntries).length;
    };
    $scope.activeField = function (field) {
        $field = $scope.typeFields().filter(function (x) {
            return x.raw == field;
        })[0];
        if ($field)
            return $field.checked;
        else
            return false;
    };
    $scope.search = function () {
        $scope.loading = true;

        if (!$scope.form.query) {
            $scope.error("<span>You must insert a search query first</span>");
            return;
        }

        if ($scope.form.type != 'place' && $scope.form.type != 'page' && !$scope.login_status) {
            return $scope.login();
        }
        $scope.form.center = window.latlng;
        $http({
            url: 'api/facebook/search',
            method: 'post',
            data: $scope.form
        }).then(function (res) {

            if (res.data.error) {
                $scope.error("<span>" + res.data.message + "</span>");
            }

            $scope.fields = $scope.typeFields().filter(function (x) {
                return x.checked == true;
            });

            $scope.items = res.data.data.data;
            $scope.paging = res.data.data.paging;


            $scope.resType = res.data.data.type;
            $scope.loading = false;

            if ($scope.resType == 'event') {
                setTimeout(activeTooltip, 1000);
            }
        });
    };
    $scope.userGroups = function () {
        $scope.loading = true;

        if ($scope.form.type != 'place' && $scope.form.type != 'page' && !$scope.login_status) {
            return $scope.login();
        }
        $scope.form.center = window.latlng;
        $http({
            url: 'api/facebook/user_groups',
            method: 'post',
            data: $scope.form
        }).then(function (res) {

            if (res.data.error) {
                $scope.error("<span>" + res.data.message + "</span>");
            }

            $scope.fields = $scope.typeFields().filter(function (x) {
                return x.checked == true;
            });

            $scope.items = res.data.data.data;
            $scope.paging = res.data.data.paging;


            $scope.resType = res.data.data.type;
            $scope.loading = false;

            if ($scope.resType == 'event') {
                setTimeout(activeTooltip, 1000);
            }
        });
    };
    $scope.groupMembers = function (id) {
        $scope.loading = true;
        $scope.selectType($scope.types[3]);
        $scope.form.id = id;



        if ($scope.form.type != 'place' && $scope.form.type != 'page' && !$scope.login_status) {
            return $scope.login();
        }
        $scope.form.center = window.latlng;
        $http({
            url: 'api/facebook/group_members',
            method: 'post',
            data: $scope.form
        }).then(function (res) {

            if (res.data.error) {
                $scope.error("<span>" + res.data.message + "</span>");
            }

            $scope.fields = $scope.typeFields().filter(function (x) {
                return x.checked == true;
            });

            $scope.items = res.data.data.data;
            $scope.paging = res.data.data.paging;


            $scope.resType = res.data.data.type;
            $scope.loading = false;

            if ($scope.resType == 'event') {
                setTimeout(activeTooltip, 1000);
            }
        });
    };

    $scope.page = function ($url) {

        $scope.loading = true;
        $http({
            url: 'api/facebook/paging',
            method: 'post',
            data: {url: $url}
        }).then(function (res) {

            if (res.data.error) {
                $scope.error("<span>" + res.data.message + "</span>");
            }

            $scope.fields = $scope.typeFields().filter(function (x) {
                return x.checked == true;
            });

            $scope.items = res.data.data.data;
            $scope.paging = res.data.data.paging;
            $scope.loading = false;

            if ($scope.resType == 'event') {
                setTimeout(activeTooltip, 1000);
            }
        });
    };
    $scope.export = function () {
        // CHECK IF CHECKED
        $items = $scope.items.filter(function (x) {
            return x.checked == true;
        });
        if ($items.length == 0)
            $items = $scope.items;

        $http({
            url: 'api/export/download',
            method: 'post',
            data: {items: $items, fields: $scope.fields}
        }).then(function (res) {
            var content = res.data;
            var url = (window.URL || window.webkitURL).createObjectURL(new Blob([content]));
            var a = document.createElement('a');
            a.href = url;
            a.download = 'export.csv';
            a.target = '_blank';
            a.click();
        });
    };
    $scope.exportCounter = function () {
        $items = $scope.items.filter(function (x) {
            return x.checked == true;
        });
        if ($items.length == 0)
            $items = $scope.items;
        return $items.length;
    };
    $scope.login = function () {
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                $scope.form.accessToken = response.authResponse.accessToken;
                $scope.login_status = true;
                //if(FB.getAuthResponse());
                console.log('kjlkjlk');
                console.log(FB.getAuthResponse());
                $scope.search();
            }
            else {
                FB.login(function (response) {
                    if (response.authResponse) {
                        $scope.search();
                    } else {
                        $scope.loading = false;
                        $scope.error("<span>User cancelled login or did not fully authorize.</span>");
                        return;
                    }
                }, {return_scopes: true});
            }
        });
    }
    $scope.selectAll = function () {
        if ($('.selectAll').prop('checked')) {
            angular.forEach($scope.items, function (x) {
                x.checked = true;
            });
        }
        else {
            angular.forEach($scope.items, function (x) {
                x.checked = false;
            });
        }
    };
    function activeTooltip() {
        $('a[data-toggle="tooltip"]').tooltip({
            animated: 'fade',
            placement: 'right',
            html: true
        });

    }

});


(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
ga('create', 'UA-79608829-1', 'auto');
ga('send', 'pageview');
