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
            Backbone.history.start();
            //application.setUp();
        },
        publicRegion = {
            initialize: function () {
                initialize();
                return publicRegion;
            },
            get router () {
                return router;
            },
            get app() {
                return application;
            },
            get view() {
                return main_view;
            },
            showLoader: function() { $('#loader').show(); },
            hideLoader: function() { $('#loader').hide(); }
        };


        return publicRegion;
    };

    return new application();
});