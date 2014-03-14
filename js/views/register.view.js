define(['jquery',
        'underscore',
        'backbone',
        'bootbox',
        'handlebars',
        'models/register.model',
        'text!templates/register.tpl.html'
    ],
    function($, _, Backbone, bootbox, handlebars, regModel, tpl){

    var view = Backbone.View.extend({
        initialize: function (elem) {
            this.$el = elem;
            this.el = elem[0];
            this.model.on('invalid', this.showErrors, this);
        },
        model: new regModel(),
        events: {
            "click button": "register",
            "change input": "change"
        },
        el: document.body,
        template: handlebars.compile(tpl),
        render: function (){
            this.$el.html(this.template({}));
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
        showErrors: function (model, errors, options) {},
        register: function (evt) {
            this.model.save(this.model.toJSON(), {
                success: function () {},
                error: function () {}
            });

            evt.preventDefault();
            return false;
        }
    });

    return view;
});