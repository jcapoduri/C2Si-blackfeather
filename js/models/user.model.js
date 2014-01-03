define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){
    var userModel = Backbone.Model.extend({
        initialize: function(){},
        defaults: {
            name: "",
            username: "",
            admin: "",
            email: ""
        }
    })

    return userModel;
});