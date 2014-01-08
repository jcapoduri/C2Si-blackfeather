define(function() {
    'use strict';

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
            },
            'jquery_cookie': {
                deps: ['jquery'],
                exports: 'jquery_cookie'
            }
    	},
    	paths: {
    	    text: 'vendors/requirejs/text',
    	    backbone: 'vendors/backbone/backbone',
    		underscore: 'vendors/underscore/underscore',
    		jquery: 'vendors/jquery/jquery.min',
    		jquery_cookie: 'vendors/jquery/jquery-cookie',
    		handlebars: 'vendors/handlebars/handlebars',
    		bootstrap: 'vendors/bootstrap/bootstrap.min'
    	}
    });
});