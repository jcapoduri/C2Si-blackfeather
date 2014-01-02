define(['jquery', 'underscore', 'backbone', 'app/router'], function($, _, Backbone, Router){
    var application = function () {
        var router = new Router();

        var
        initialize = function (){
            Backbone.history.start();
        },
        publicRegion = {
            init: function () {
                this.initialize();
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