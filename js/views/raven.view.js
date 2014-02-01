define([
    'jquery',
    'underscore',
    'backbone',
    'bootbox',
    'handlebars',
    'text!templates/raven/app.tpl.html'
],
function($, _, Backbone, bootbox, handlebars, tpl){

    var view = Backbone.View.extend({
        operations: [
            {
                "name": "Inicio",
                "url": "raven",
                "op": null
            },
            {
                "name": "Listado Usuarios",
                "url": "raven/users",
                "op": {}
            }
        ],
        tiles: [],
        initialize: function (elem, model) {
            this.$el = elem;
            this.el = elem[0];
            this.model = model;
        },
        el: document.body,
        template: handlebars.compile(tpl),
        render: function (){
            this.$el.html(this.template(this.model));
            this.$el.find('input').tooltip();
        },
        change: function (evt) {
            var $el = $(evt.currentTarget),
                value = $el.val();
            switch (evt.target.id) {
                case 'userinput':
                    this.model.set('username', value);
                    break;
                case 'emailinput':
                    this.model.set('email', value);
                    break;
                case 'email2input':
                    this.model.set('email2', value);
                    break;
                case 'passinput':
                    this.model.set('password', value);
                    break;
                case 'pass2input':
                    this.model.set('password2', value);
                    break;
                default:
            }
        },
        showErrors: function (model, errors, options) {}
    });

    return view;
});