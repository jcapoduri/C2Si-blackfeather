define(['jquery',
        'underscore',
        'backbone',
        'bootbox',
        'handlebars',
        'models/login.model',
        'text!templates/login.tpl.html'
    ],
    function($, _, Backbone, bootbox, handlebars, loginModel, tpl){

    var view = Backbone.View.extend({
        initialize: function (elem, model) {
            this.$el = elem;
            this.el = elem[0];
            this.model = model ? model : new loginModel();
        },
        el: document.body,
        events: {
            "change input": "change",
            "click button": "login"
        },
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
                case 'passinput':
                    this.model.set('password', value);
                    break;
                default:
            }
        },
        showErrors: function (model, errors, options) {},
        login: function (evt) {
            Raven.showLoader();
            this.model.save({
                success: function(response) {
                    $.ajaxSetup({
                        headers: { 'ACCESS_TOKEN': response }
                    });
                    $.cookie('ACCESS_TOKEN', response);
                    Raven.router.navigate('/home', {trigger: true});
                },
                error: function() {
                        bootbox.dialog({
                          message: "Error al ingresar, compruebe usuario y password",
                          title: "Error al ingreso",
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