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
            application.setUp();
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