define(['jquery', 'underscore', 'backbone', 'models/raven/business.model'], function($, _, Backbone, businessModel){
    var collection = Backbone.Collection.extend({
        model: businessModel,
        parse: function(response, options) {
            var collection = this;
            _.each(response, function(item){
                collection.add(new businessModel(item));
            });
        }
    });

    return collection;
});