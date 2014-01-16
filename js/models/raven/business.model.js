define([
    'jquery',
    'underscore',
    'backbone',
    'models/raven/app.collection',
    'models/raven/local.collection'
], function($, _, Backbone, appCollection, localCollection){
    var businessModel = Backbone.Model.extend({
        user: null,
        defaults: {
            name: "",
            locals: [],
            availableApps: new appCollection(),
            locals: new localCollection()
        },
        parse: function (data) {
            var parsed = {};
            parsed.name = data.name;
            parsed.availableApps = new appCollection(data.apps);
            parsed.locals = new localCollection(data.locals);
            return parsed;
        }
    })

    return businessModel;
});