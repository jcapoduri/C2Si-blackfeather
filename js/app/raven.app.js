define([
    'views/raven.view'
    ], function (appView) {

    var app = {
        operations: [
            {
                "name": "Inicio",
                "url": ""
            }
        ],
        tiles: [
            {
                "title": "cargar empresa",
                "info": "",
                "module": "name"
            },
            {
                "title": "cargar usuario",
                "info": "",
                "module": ""
            }
        ],
        init: function (el, subapp) {
            this.view = new appView(el, this);
            this.view.render();
        }
    };

    return app;
});