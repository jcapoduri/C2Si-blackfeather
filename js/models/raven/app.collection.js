define(['jquery', 'underscore', 'backbone', 'models/raven/app.model'], function($, _, Backbone, appModel){
    var collection = Backbone.Collection.extend({
        model: appModel
    });

    return collection;
});