define([
    'views/raven.view'
    ], function (registerView) {

    var app = {
        operations: [
            {
                "name": "Inicio",
                "url": "",
                "op": {}
            }
        ],
        widgets: [],
        init: function (el) {
            this.view = new registerView(el, this);
            view.render();
        }
    };

    return app;
});