define(['jquery', 'underscore', 'backbone'], function ($, _, Backbone) {
    var model = Backbone.Model.extend({
        defaults: {
            "username": "",
            "password": ""
        },
        url: 'api/login',
        validate: function (attrs) {
            var error = {};

			if (attrs.password) {
				if (attrs.password.length < 8) {
					error.password = "password demasiado corto";
				}
			}

			if (attrs.password2) {
				if (attrs.password.length < 8) {
					error.password = "password demasiado corto";
				}
			}

			if (!_.isEmpty(error)) return error;
        }
    });

    return model;
});