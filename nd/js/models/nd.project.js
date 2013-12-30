// To DO

define(['jquery',
        'underscore',
        'backbone',
        'models/nd.object.collection',
        'models/nd.storage.collection',
        'models/nd.app.collection',
        'models/nd.config'
    ], function(
        $,
        _,
        Backbone,
        objCollection,
        stoCollection,
        appCollection,
        configModel
){
    var project = Backbone.Model.extend({
        urlRoot : 'api/config',
        defaults: {
            "config" : new configModel(),
            "meta": {},
            "objects": new objCollection()
        },
        initialize: function() {
        },
        parse: function(response, options) {
            var parsed = {};
            parsed.config = new configModel(response.config);
            parsed.meta = response.meta;
            parsed.objects = new objCollection(response.objects);

            return parsed;

        }
    });
    return project;
});