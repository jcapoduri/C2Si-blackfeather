define(['jquery',
        'underscore',
        'backbone',
        'bootstrap',
        'handlebars',
        'text!templates/nd.project.tpl.html',
        'models/nd.project',
        'views/nd.config.view'
    ],
    function($, _, Backbone, bootstrap, handlebars, tpl, projectModel, configView){

    var view = Backbone.View.extend({
        initialize: function () {
            this.project = new projectModel();
            this.configView  = new configView();
        },
        el: $("#main-container"),
        template: handlebars.compile(tpl),
        render: function (){
            var $el = $(this.el);
            $el.html(this.template(this));
            this.configView.el = $el.find("#config");
            this.configView.render();
        }
    });

    return view;
});