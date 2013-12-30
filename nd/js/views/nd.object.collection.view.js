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
            var $el = $(this.el);
            $el.empty();
            var view = this;
            _.each(this.model.models, function(item) { $el.append(view.template(item));});

        }
    });

    return view;
});