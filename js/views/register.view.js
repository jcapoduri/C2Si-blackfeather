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
            this.$el.find('input').change();
            Raven.showLoader();
            this.model.save(this.model.toJSON(), {
                success: function () {
                    bootbox.dialog({
                      message: "Se ha registrado exitosamente, por favor compruebe el correo que proporciono para terminar de verificar la cuenta",
                      title: "Registro Exitoso!",
                      buttons: {
                        main: {
                          label: "Ok",
                          className: "btn-primary",
                          callback: function() {}
                        }
                      }
                    });
                    Raven.hideLoader();
                },
                error: function (model, response) {
                    errData = JSON.parse(response.responseText);
                    bootbox.dialog({
                      message: errData.message,
                      title: "Error al registrarse",
                      buttons: {
                        main: {
                          label: "Ok",
                          className: "btn-primary",
                          callback: function() {}
                        }
                      }
                    });
                    Raven.hideLoader();
                }
            });

            evt.preventDefault();
            return false;
        }
    });

    return view;
});