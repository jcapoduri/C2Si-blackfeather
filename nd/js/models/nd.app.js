define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){
    var app = Backbone.Model.extend({
        defaults: {
            "system_name" : "",
            "version": ""
        }
    });
    return app;
});