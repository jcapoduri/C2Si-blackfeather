define(['jquery', 'underscore', 'backbone', 'models/raven/business.collection', 'models/raven/app.collection'], function($, _, Backbone, businessCollection, appCollection){
    var userModel = Backbone.Model.extend({
        url: 'api/my',
        initialize: function(){},
        defaults: {
            name: "",
            username: "",
            admin: "",
            email: "",
            availableBusiness: []
        },
        parse: function (data) {
            var json = {};
            json.username = data.username;
            json.email = data.email;
            if (data.available_business) {
                json.availableBusiness = new businessCollection(data.available_business);
                json.availableApplications = new appCollection(data.available_business)
            };
            return json;
        }
    })

    return userModel;
});