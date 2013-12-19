define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){
    var config = Backbone.Model.extend({
        defaults: {
            "system_name" : "",
            "version": ""
        }
    });
    return config;
});