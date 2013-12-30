requirejs.config({
	baseUrl: 'js',
	shim: {
		'backbone': {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        'underscore': {
            exports: '_'
        },
        'bootstrap': {
            deps: ['jquery'],
            exports: 'bootstrap'
        },
        'handlebars': {
            exports: 'Handlebars'
        }
	},
	paths: {
	    text: '../../js/vendors/requirejs/text',
	    backbone: '../../js/vendors/backbone/backbone',
		underscore: '../../js/vendors/underscore/underscore',
		jquery: '../../js/vendors/jquery/jquery.min',
		handlebars: '../../js/vendors/handlebars/handlebars',
		bootstrap: '../../js/vendors/bootstrap/bootstrap.min'
	}
});