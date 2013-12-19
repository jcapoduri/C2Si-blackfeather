define(['jquery', 'underscore', 'backbone', 'models/nd.field'], function($, _, Backbone, fieldModel){
    var collection = Backbone.Collection.extend({
        model: fieldModel
    });

    return collection;
});