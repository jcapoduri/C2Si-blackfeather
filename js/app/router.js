define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){
    var startApp = function(module) {
        module.init($("#main-container"));
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
            if (!!Raven) Raven.app.logout();
        },
        logout: function () {
          this.navigate('/login', {trigger: true});
        },
        defaultAction: function () {

        }
    });

    return router;
});