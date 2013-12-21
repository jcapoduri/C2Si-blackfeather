define(['jquery', 'underscore', 'backbone', 'models/nd.object'], function($, _, Backbone, objectModel){
    var collection = Backbone.Collection.extend({
        model: objectModel,
        parse: function(response, options) {
            var collection = this;
            _.each(response, function(item){
                collection.add(new objectModel(item));
            });
        }
    });

    return collection;
});