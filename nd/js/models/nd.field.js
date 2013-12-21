define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){
    var config = Backbone.Model.extend({
        defaults: {
            "name" : "",
            "type": "string"
        }
    });
    return config;
});