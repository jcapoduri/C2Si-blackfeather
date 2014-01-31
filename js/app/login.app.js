define([
    'views/login.view'
    ], function (loginView) {

    var app = {
        init: function (el) {
            this.view = new loginView(el);
            this.view.render();
        }
    };

    return app;
});