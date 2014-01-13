define(['jquery', 'underscore', 'backbone', 'bootbox'], function($, _, Backbone, bootbox){
    var appModel = Backbone.Model.extend({
        initialize: function(){},
        defaults: {
            token: "",
            username: "",
            admin: false,
            loged: false
        },
        setUp: function() {
            debugger;
            $.ajax({
                url: "/api/noop",
                type: "GET",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    this.set('loged', true);
                    Raven.hideLoader();
                    Raven.router.navigate('');
                }.bind(this),
                error: this.logout.bind(this)
            });
        },
        logout: function() {
            debugger;
            this.set('loged', false);
            this.set('token', '');
            Raven.hideLoader();
        },
        login: function(login) {
            $.ajax({
                url: 'api/login',
                type: "POST",
                data: JSON.stringify(login),
                processData: false,
                contentType: "application/json; charset=utf-8",
                success: function(response) {
                    $.ajaxSetup({
                        headers: { 'ACCESS_TOKEN': response }
                    });
                    this.set('loged', true);
                    this.set('token', response);
                    $.cookie('ACCESS_TOKEN', response);
                    this.setUp();
                }.bind(this),
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
                    }
            })
        }
    })

    return appModel;
});