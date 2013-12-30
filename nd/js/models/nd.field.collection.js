define(['jquery', 'underscore', 'backbone', 'models/nd.field'], function($, _, Backbone, fieldModel){
    var collection = Backbone.Collection.extend({
        model: fieldModel,
        parse: function(response, options) {
            var collection = this;
            _.each(response, function(item){
                collection.add(new fieldModel(item));
            });
        }
    });

    return collection;
});