define(['jquery', 'underscore', 'backbone', 'models/nd.storage'], function($, _, Backbone, storageModel){
    var collection = Backbone.Collection.extend({
        model: storageModel
    });

    return collection;
});