define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){

    var router = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            'login': 'showLoginForm',
            'register': 'showUsers',
            'logout': 'logout',
            'app/raven': 'defaultAction',
            'business/:name/app/:appname': 'defaultAction',
            // Default
            '*actions': 'defaultAction'

        },
        initialize: function () {
            //init code here
            this.access_token = $.cookie('ACCESS_TOKEN');
            Backbone.history.start();
            if (this.access_token) {
                //get info from token
                $.ajaxSetup({
                    headers: { 'ACCESS_TOKEN': this.access_token }
                });

            } else {
                this.navigate('/login', {trigger: true});
            };
        },
        showLoginForm: function () {
            if (!!Raven) Raven.app.logout();
        },
        logout: function () {
          this.navigate('/login', {trigger: true});
        },
        defaultAction: function () {
            debugger;

        }
    });

    /*var init = function () {
        var app_router = new router;
        app_router.on('showProjects', function(){
          // Call render on the module we loaded in via the dependency array
          // 'views/projects/list'
          console.log('projects:');
        });
          // As above, call render on our loaded module
          // 'views/users/list'
        app_router.on('showUsers', function(){
          console.log('users:');
        });
        app_router.on('defaultAction', function(actions){
          // We have no matching route, lets just log what the URL was
          console.log('No route:', actions);
        });
        Backbone.history.start();
    };*/

    return router;
});