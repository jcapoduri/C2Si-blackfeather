define(['jquery', 'underscore', 'backbone'], function ($, _, Backbone) {
    var model = Backbone.Model.extend({
		url: 'api/register/user',
        defaults: {
            "email": "",
            "email2": "",
            "username": "",
            "password": "",
            "password2": ""
        },
        validate: function (attrs) {
            var error = {};
		    /*if (attrs.email) {
				if (attrs.email.length !== 11) {
		            error.email = "CUIT invalido, no contiene 11 caracteres";
		        }
		        if (!(!isNaN(parseFloat(attrs.cuit)) && isFinite(attrs.cuit))) {
		            error.email += "\r\nCUIT invalido, no es numerico";
		        }
		    };

		    if (attrs.email2) {
		        if (attrs.email.length !== 11) {
		            error.email = "CUIT invalido, no contiene 11 caracteres";
		        }
		        if (!(!isNaN(parseFloat(attrs.cuit)) && isFinite(attrs.cuit))) {
		            error.email += "\r\nCUIT invalido, no es numerico";
		        }
		    };

		    if (attrs.password) {
		        if (attrs.password.length < 8) {
		            error.password = "password demasiado corto";
		        }
		    };

		    if (attrs.password2) {
		        if (attrs.password.length < 8) {
		            error.password = "password demasiado corto";
		        }
		    };*/

		    if (!_.isEmpty(error)) return error;
        }
    });

    return model;
});