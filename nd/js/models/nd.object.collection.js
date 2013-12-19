define(['jquery', 'underscore', 'backbone', 'models/nd.object'], function($, _, Backbone, objectModel){
    var collection = Backbone.Collection.extend({
        model: objectModel
    });

    return collection;
});