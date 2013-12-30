define(['jquery', 'underscore', 'backbone', 'views/nd.project.view'], function($, _, Backbone, projectView){

    var router = Backbone.Router.extend({
        routes: {
        // Define some URL routes
        '/projects': 'showProjects',
        '/users': 'showUsers',

        // Default
        '*actions': 'defaultAction'
        },
        initialize: function () {
            var mainView = new projectView();
            mainView.render();
            window.project = mainView;
        }
    });

    var init = function () {
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
    };

    return {
        init: init
    };
});