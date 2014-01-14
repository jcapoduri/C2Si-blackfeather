define([
    'jquery',
    'underscore',
    'backbone',
    'jquery_cookie',
    'jquery_ui',
    'bootbox',
    'app/router',
    'models/application.model',
    'views/application.view'
], function($, _, Backbone, cookie, ui, bootbox, Router, appModel, appView){
    var application = function () {
        var router = new Router(),
            access_token = '',
            application = new appModel(),
            main_view = new appView(application);

        var
        initialize = function (){
            main_view.render();
            this.access_token = $.cookie('ACCESS_TOKEN');
            if (this.access_token) {
                //get info from token
                $.ajaxSetup({
                    headers: { 'ACCESS_TOKEN': this.access_token }
                });
                application.setUp();
                Backbone.history.start();
            } else {
                //go to login
                debugger;
                Backbone.history.start();
                router.navigate('/login', {trigger: true});
            };
        },
        publicRegion = {
            init: function () {
                initialize();
                return publicRegion;
            },
            get router() {
                return router;
            },
            get app() {
                return application;
            },
            get view() {
                return main_view;
            },
            addPath: function(path, fn) {
                router.on(path, fn);
                return publicRegion;
            },
            removePath: function(path, fn) {
                router.off(path, fn);
                return publicRegion;
            },
            showLoader: function() { $('#loader').show(); },
            hideLoader: function() { $('#loader').hide(); }
        };


        return publicRegion;
    };

    return application;
});