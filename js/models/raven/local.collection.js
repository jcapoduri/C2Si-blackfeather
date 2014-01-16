define(['jquery', 'underscore', 'backbone', 'models/raven/local.model'], function($, _, Backbone, localModel){
    var collection = Backbone.Collection.extend({
        model: localModel
    });

    return collection;
});