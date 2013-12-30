define(['jquery', 'underscore', 'backbone', 'app/router'], function($, _, Backbone, router){
    var init = function () {
        router.init();
    };

    return {
        init : init
    };
});