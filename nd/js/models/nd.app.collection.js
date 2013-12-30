define(['jquery', 'underscore', 'backbone', 'models/nd.app'], function($, _, Backbone, appModel){
    var collection = Backbone.Collection.extend({
        model: appModel
    });

    return collection;
});