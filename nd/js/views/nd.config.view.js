define(['jquery',
        'underscore',
        'backbone',
        'bootstrap',
        'handlebars',
        'text!templates/nd.config.tpl.html',
        'models/nd.config'
    ],
    function($, _, Backbone, bootstrap, handlebars, tpl, configModel){

    var view = Backbone.View.extend({
        initialize: function () {
            this.model = new configModel();
        },
        template: handlebars.compile(tpl),
        render: function (){
            $(this.el).html(this.template(this.model.toJSON()));
        }
    });

    return view;
});