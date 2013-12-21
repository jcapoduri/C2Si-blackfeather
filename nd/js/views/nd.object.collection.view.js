define(['jquery',
        'underscore',
        'backbone',
        'bootstrap',
        'handlebars',
        'text!templates/nd.object.tpl.html',
        'models/nd.object.collection'
    ],
    function($, _, Backbone, bootstrap, handlebars, tpl, objectCollectionModel){

    var view = Backbone.View.extend({
        initialize: function () {
            this.model = new objectCollectionModel();
        },
        template: handlebars.compile(tpl),
        render: function (){
            $(this.el).html(this.template(this.model));
        }
    });

    return view;
});