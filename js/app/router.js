define(['jquery', 'underscore', 'backbone', 'jquery_cookie', 'app/application'], function($, _, Backbone, cookie, app){
    var startApp = function(module) {
        module.init($("#main-container"));
        Raven.hideLoader();
    };

    var startSubApp = function(module) {
        module.init($("#central-widget"));
        Raven.hideLoader();
    };

    var router = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            'login': 'showLoginForm',
            'register': 'register',
            'logout': 'logout',
            'app/raven': 'defaultAction',
            'business/:name/app/:appname': 'defaultAction',
            'home': 'start',
            // Default
            '*actions': 'defaultAction'
        },
        initialize: function () {
            //init code here
            this.access_token = $.cookie('ACCESS_TOKEN');

            if (this.access_token) {
                //get info from token
                $.ajaxSetup({
                    headers: { 'ACCESS_TOKEN': this.access_token }
                });
            };
        },
        register: function () {
            Raven.showLoader();
            require(['app/register.app'], startApp);
        },
        showLoginForm: function () {
            Raven.showLoader();
            require(['app/login.app'], startApp);
        },
        logout: function () {
          this.navigate('/login', {trigger: true});
        },
        defaultAction: function () {
            Raven.app.setUp();
        },
        start: function () {
            require(['app/raven.app'], startApp);
        }
    });

    return router;
});