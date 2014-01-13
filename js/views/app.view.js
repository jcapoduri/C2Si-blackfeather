define(['jquery',
        'underscore',
        'backbone',
        'bootstrap',
        'handlebars',
        'models/application.model',
        'text!templates/raven/app.tpl.html'
    ],
    function($, _, Backbone, bootstrap, handlebars, appModel, tpl){

    var view = Backbone.View.extend({
        mainapp: null,
        initialize: function (model) {
            if (!!model) {
                this.mainapp = model;
            } else {
                this.mainapp = new appModel();
            };
            this.mainapp.on('change', this.render, this);
        },
        events: {
            "click #loadButton": "load",
            "click #saveButton": "save"
        },
        el: document.body,
        template: handlebars.compile(tpl),
        render: function (){
            this.$el.html(this.template(this.mainapp.toJSON()));
        },
        load: function() { this.project.fetch(); },
        save: function() { this.project.save(); }
    });

    return view;
});