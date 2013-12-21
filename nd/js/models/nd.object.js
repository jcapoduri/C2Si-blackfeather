define(['jquery', 'underscore', 'backbone', 'models/nd.field.collection'], function($, _, Backbone, fieldCollection){
    var config = Backbone.Model.extend({
        defaults: {
            "name" : "",
            "nd_fields": true,
            "fields": new fieldCollection()
        },
        parse: function(response, options) {
            var parsed = {};
            parsed.name  = response.name;
            parsed.nd_fields = response.nd_fields;
            parsed.fields = new fieldCollection(response.fields);
            return parsed;
        }
    });
    return config;
});