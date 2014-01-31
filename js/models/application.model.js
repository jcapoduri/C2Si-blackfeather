define(['jquery', 'underscore', 'backbone', 'bootstrap', 'bootbox', 'models/raven/user.model'], function($, _, Backbone, bootstrap, bootbox, userModel){
    var appModel = userModel.extend({
        initialize: function(){
            this.on('change:availableBusiness', this.setCurrentBusiness, this);
        },
        defaults: {
            loged: false,
            ready: false,
            currentBusiness: "[None]",
            currentLocal: "[None]"
        },
        setCurrentBusiness: function () {
            this.attributes.currentBusiness = this.get('availableBusiness').at(0);
            this.attributes.currentLocal = this.get('currentBusiness');
            this
        },
        setUp: function() {
            Raven.showLoader();
            this.fetch({
                success: function (data) {
                    this.set('loged', true);
                    this.set('ready', true);
                    Raven.hideLoader();
                    Raven.router.navigate('');
                }.bind(this),
                error: this.logout.bind(this)
            })
        },
        logout: function() {
            this.set('loged', false);
            this.set('ready', true);
            this.set('token', '');
            Raven.router.navigate('/login', {trigger: true});
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
                        Raven.hideLoader();
                    }
            })
        }
    })

    return appModel;
});