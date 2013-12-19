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
        defaults: {
            "config" : new configModel(),
            "meta": {},
            "objects": new objCollection()
        },
        initialize: function() {
            debugger;
        }
    });
    return project;
});