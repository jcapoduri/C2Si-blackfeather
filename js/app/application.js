define([
    'jquery',
    'underscore',
    'backbone',
    'jquery_cookie',
    'jquery_ui',
    'bootbox',
    'app/router',
    'models/application.model',
    'views/app.view'
], function($, _, Backbone, cookie, ui, bootbox, Router, appModel, appView){
    var application = function () {
        var router = new Router(),
            access_token = '',
            application = new appModel(),
            main_view = new appView(application);

        var
        initialize = function (){
            Backbone.history.start();
            //assign router behavior

            //this.router.on('showLoginForm', this.renderLogin);

            this.access_token = $.cookie('ACCESS_TOKEN');
            if (this.access_token) {
                //get info from token
                $.ajaxSetup({
                    headers: { 'ACCESS_TOKEN': this.access_token }
                });
                application.setUp();
            } else {
                //go to login
                router.navigate('/login', {trigger: true});
            };
            debugger;
            main_view.render();
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