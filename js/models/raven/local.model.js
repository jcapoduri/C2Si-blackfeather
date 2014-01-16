define(['jquery', 'underscore', 'backbone'], function($, _, Backbone){
    var localModel = Backbone.Model.extend({
        initialize: function(){},
        url: '/api/apps',
        defaults: {
            name: "",
            url: ""
        }
    })

    return localModel;
});