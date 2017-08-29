<?php
if (PHP_VERSION < 5.4)
    die("Your PHP version is not compatible with Brightery Facebook Business Scraper, You could get a suitable and reliable hosting from <a href=\"https://www.brightery.com.eg/en/order\">Brightery</a>");

$config = require_once "config.php";

foreach ($config as $item)
    if (!isset($item['app_id']) || empty($item['app_id']) || !isset($item['app_secret']) || empty($item['app_secret']))
        die("Your app is not configured correctly, please check the installation tutorial from <a href=\"https://www.brightery.com.eg/en/post/how-to-install-brightery-facebook-business-scraper\">https://www.brightery.com.eg/en/post/how-to-install-brightery-facebook-business-scraper</a>, or you can order for a <a href=\"https://www.brightery.com.eg/en/order\">professional installation service</a>");
?><!DOCTYPE html>
<html lang="en" data-ng-app="BrighteryFacebookBusinessScraper" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Brightery Facebook Business Scraper</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/autocomplete.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-sanitize.min.js"></script>
    <script src="js/ng-csv.min.js"></script>
    <script src="js/customSelect.js"></script>
    <script src="js/app.js"></script>
</head>
<body data-ng-controller="mainCtrl">
<div class="fb-navbar">
    <div class="container">
        <form class="form-horizontal" role="form" data-ng-submit="search()">
            <div class="form-group  has-feedback">
                <div class="pull-left">
                    <span class="fa-stack fa-lg">
                      <i class="fa fa-square fa-stack-2x fa-inverse"></i>
                      <i class="fa fa-facebook fa-stack-1x"></i>
                    </span>
                </div>

                <div class="col-sm-6">
                    <input type="text" class="form-control" id="search" placeholder="Search" data-ng-model="form.query">
                    <button type="submit" class="form-control-feedback btn-primary">
                        <span class="glyphicon glyphicon-search" ng-hide="loading"></span>
                        <span class="fa fa-spinner fa-pulse fa-fw active" ng-show="loading">
                            <i class="icon-spin icon-refresh"></i>
                        </span>
                    </button>
                </div>

                <div class="col-sm-3">
                    <div custom-select="item.name for item in searchAsync($searchTerm)"
                         custom-select-options="{ 'async': true }" ng-model="form.location">
                        <div class="pull-left">
                            <strong>{{ item.name }}</strong><br/>
                            <span>({{ item.type }})</span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-control" onclick="$('.limit').focus()">
                        <lable>Limit</lable>
                        <input type="text" class="form-control-feedback limit" data-ng-model="form.limit"
                               data-ng-init="form.limit = '20'"/>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="container">
    <h1>Brightery Facebook Business Scraper</h1>

    <p>Search up to 1000 results using keywords such as "Brightery" or "Restaurants {{country}}"</p>


    <div class="col-md-12">
        <div class="col-md-2" ng-repeat="type in types">
            <div class="type_container {{form.type == type.raw ? 'active' : null}}" ng-click="selectType(type)">
                <i class="fa fa-5x" aria-hidden="true" ng-class="type.icon"></i><br/>
                <span>{{type.name}}</span>
            </div>
        </div>


        <div class="col-md-2">
            <div class="type_container" ng-click="settings()">
                <i class="fa fa-cog fa-5x" aria-hidden="true"></i><br/>
                <span>Settings</span>
            </div>
        </div>

    </div>

    <div class="clearfix"></div>
    <br/>


    <form class="form-horizontal" role="form">
        <div class="form-group  has-feedback">
            <div class="col-sm-8">
                <!--<button type="button" ng-show="form.type == 'group'" class="btn btn-primary" ng-click="userGroups()"> Get all groups that I belong to b</button>-->
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="filter" placeholder="Filter"
                       data-ng-model="filterEntries">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
            <div class="col-sm-1">
                ({{results()}}) results
            </div>
        </div>
    </form>

    <table class="table table-hover" ng-if="fields && results()">
        <thead>
        <tr>
            <th><input type="checkbox" ng-model="selectStatus" ng-change="selectAll()" class="selectAll"/></th>
            <th data-ng-repeat="field in fields" ng-if="!field.merge && field.checked">{{field.name}}</th>
        </tr>
        </thead>

        <tbody data-ng-if="resType == 'page'">
        <tr data-ng-repeat="item in items | filter:filterEntries">
            <td><input type="checkbox" ng-model="item.checked"/></td>

            <td alt="{{item.about}}" ng-if="activeField('id')">{{item.id}}</td>
            <td>
                <a target="_bank" data-ng-href="{{item.link}}" ng-if="activeField('name') && activeField('link')">{{item.name}}</a>
                <span ng-if="activeField('name') && ! activeField('link')">{{item.name}}</span>
                <i data-ng-show="item.is_verified == true" class="fa fa-check-square-o"
                   ng-if="activeField('is_verified')"></i>
            </td>
            <td ng-if="activeField('single_line_address')">{{item.single_line_address}}</td>
            <td ng-if="activeField('phone')">{{item.phone}}</td>
            <td ng-if="activeField('emails')">{{item.emails.join()}}</td>
            <td ng-if="activeField('website')">{{item.website}}</td>
            <td ng-if="activeField('fan_count')">{{item.fan_count}}</td>
            <td ng-if="activeField('about')">{{item.about}}</td>
            <td ng-if="activeField('picture')"><img ng-src="{{ item.picture.data.url }}"/></td>
        </tr>
        </tbody>

        <tbody data-ng-if="resType == 'group'">

        <tr data-ng-repeat="item in items | filter:filterEntries">
            <td><input type="checkbox" ng-model="item.checked"/></td>
            <td ng-if="activeField('id')">{{item.id}}</td>
            <td ng-if="activeField('name')">
                <img ng-src="{{ item.icon }}" ng-if="activeField('icon')"/>
                <a data-ng-href="http://fb.com/{{item.id}}" target="_blank">{{item.name}}</a>
            </td>
            <td ng-if="activeField('description')">{{item.description | limitTo:100 }}</td>
            <td ng-if="activeField('email')">{{item.email ? item.email: item.email = item.id + '@facebook.com'}}</td>
            <td ng-if="activeField('privacy')">{{item.privacy}}</td>
            <td ng-if="activeField('members')">
                <button class="btn btn-warning" ng-click="groupMembers(item.id)">Members</button>
            </td>
        </tr>
        </tbody>

        <tbody data-ng-if="resType == 'place'">

        <tr data-ng-repeat="item in items | filter:filterEntries">
            <td><input type="checkbox" ng-model="item.checked"/></td>
            <td ng-if="activeField('id')">{{item.id}}</td>
            <td ng-if="activeField('name')"><a data-ng-href="http://fb.com/{{item.id}}"
                                               target="_blank">{{item.name}}</a></td>
            <td ng-if="activeField('location')">Street: {{item.location.street}}, City: {{item.location.city}}, State:
                {{item.location.state}},
                Country:
                {{item.location.country}}, Zip: {{item.location.zip}}
            </td>
            <td>
                <a ng-href="https://www.google.com.eg/maps/@{{item.location.latitude}},{{item.location.longitude}},20z"
                   target="_blank">MAP</a>
            </td>
        </tr>
        </tbody>

        <tbody data-ng-if="resType == 'user'">

        <tr data-ng-repeat="item in items | filter:filterEntries">
            <td><input type="checkbox" ng-model="item.checked"/></td>
            <td ng-if="activeField('id')">{{item.id}}</td>
            <td ng-if="activeField('name')">
                <img class="img-circle" ng-src="{{ item.picture.data.url }}"/>
                <a data-ng-href="{{item.link}}" target="_blank">{{item.name}}</a>
                <i data-ng-show="item.is_verified == true" class="fa fa-check-square-o"
                   ng-if="activeField('is_verified')"></i>
            </td>
            <td ng-if="activeField('birthday')">{{item.birthday}}</td>
            <td ng-if="activeField('email')">{{item.email ? item.email: item.email = item.id + '@facebook.com'}}</td>
            <td ng-if="activeField('gender')">{{item.gender}}</td>
            <td ng-if="activeField('interested_in')">{{item.interested_in}}</td>
            <td ng-if="activeField('location')">{{item.location}}</td>
            <td ng-if="activeField('meeting_for')">{{item.meeting_for}}</td>
            <td ng-if="activeField('religion')">{{item.religion}}</td>
            <td ng-if="activeField('relationship_status')">{{item.relationship_status}}</td>
            <td ng-if="activeField('website')">{{item.website}}</td>
            <td ng-if="activeField('work')">{{item.work}}</td>
            <!--<td ng-if="activeField('cover')">{{item.cover}}</td>-->
            <td ng-if="activeField('devices')">{{(item.devices) | json}}</td>
            <td ng-if="activeField('education')">{{item.education}}</td>
            <td ng-if="activeField('hometown')">{{item.hometown}}</td>
            <td ng-if="activeField('languages')">{{item.languages}}</td>
            <td ng-if="activeField('age_range')">{{item.age_range}}</td>
        </tr>
        </tbody>

        <tbody data-ng-if="resType == 'event'">
        <tr data-ng-repeat="item in items | filter:filterEntries">
            <td><input type="checkbox" ng-model="item.checked"/></td>
            <td ng-if="activeField('id')">
                <a class="thumbnail" class="enlarge">
                    {{item.id}} <span><img ng-src="{{ item.cover.source }}" ng-if="activeField('cover')"/></span>
                </a>
            </td>
            <td ng-if="activeField('name')">
                <a data-ng-href="http://fb.com/{{item.id}}" class="enlarge" target="_blank">{{item.name| limitTo:
                    50}} </a>
            </td>
            <td ng-if="activeField('attending_count')">{{item.attending_count}}</td>
            <td ng-if="activeField('noreply_count')">{{item.noreply_count}}</td>
            <td ng-if="activeField('maybe_count')">{{item.maybe_count}}</td>
            <td ng-if="activeField('interested_count')">{{item.interested_count}}</td>
            <td ng-if="activeField('declined_count')">{{item.declined_count}}</td>
            <td ng-if="activeField('owner')"><a href="http://fb.com/{{item.owner.id}}" target="_blank">{{item.owner.name}}</a>
            </td>
            <td ng-if="activeField('place')">{{item.place.name}}</td>
            <td ng-if="activeField('category')">{{item.category}}</td>
            <td ng-if="activeField('can_guests_invite')">{{item.can_guests_invite}}</td>
            <td ng-if="activeField('cover')">{{item.cover}}</td>
            <td ng-if="activeField('start_time')">{{item.start_time}}</td>
            <td ng-if="activeField('end_time')">{{item.end_time}}</td>
            <td ng-if="activeField('type')">{{item.type}}</td>
            <td ng-if="activeField('ticket_uri')">{{item.ticket_uri}}</td>
        </tr>
        </tbody>

    </table>


    <div class="col-md-12">
        <button class="btn btn-primary pull-right" ng-if="paging.next && results()" ng-click="page(paging.next)"> Next
            <i class="fa fa-arrow-right"></i></button>
        <div class="pull-right" style="width: 5px;margin: 5px;"></div>
        <button class="btn btn-primary pull-right" ng-if="paging.previous && results()"
                ng-click="page(paging.previous)"><i
                class="fa fa-arrow-left"></i> Prev
        </button>
    </div>

    <div class="clearfix"></div>
    <br/>
    <button class="btn btn-success pull-right" ng-click="export()" ng-if="fields && results()">
        <i class="fa fa-download"></i> ({{exportCounter()}}) Export to CSV
    </button>
    <p>Powered By <a href="http://www.brightery.com.eg">Brightery</a></p>
</div>


<div class="modal fade" id="popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span> Brightery Facebook Business
                    Scraper</h4>
            </div>

            <div class="modal-body">
                <div ng-include="template"></div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> Close
                </button>
            </div>
        </div>
    </div>
</div>






</body>
</html>
