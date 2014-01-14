define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){
    var userModel = Backbone.Model.extend({
        initialize: function(){},
        url: '/api/apps',
        defaults: {
            name: "",
            url: ""
        }
    })

    return userModel;
});