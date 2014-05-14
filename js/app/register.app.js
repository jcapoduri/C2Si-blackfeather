define([
    'models/register.model',
    'views/register.view'
    ], function (registerModel, registerView) {

    var app = {
        init: function (el) {
            var view = new registerView(el);
            view.render();
        }
    };

    return app;
});