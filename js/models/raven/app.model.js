define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){
    var appModel = Backbone.Model.extend({
        initialize: function(){},
        url: '/api/apps',
        defaults: {
            name: "",
            url: ""
        }
    })

    return appModel;
});