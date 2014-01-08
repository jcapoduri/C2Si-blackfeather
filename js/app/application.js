define(['jquery', 'underscore', 'backbone', 'jquery_cookie', 'app/router'], function($, _, Backbone, cookie, Router){
    var application = function () {
        var router = new Router(),
            access_token = '';

        var
        initialize = function (){
            Backbone.history.start();
            //if ($.cookie(''))
            //chequeo si hay un usuario
            if (window.location.path != "/") {
                access_token = $.cookie('jcapoduri');
            } else { //request login

            }
        },
        publicRegion = {
            init: function () {
                initialize();
                return publicRegion;
            },
            get router() {
                return router;
            },
            addPath: function(path, fn) {
                router.on(path, fn);
                return publicRegion;
            },
            removePath: function(path, fn) {
                router.off(path, fn);
                return publicRegion;
            }
        };


        return publicRegion;
    };

    return application;
});