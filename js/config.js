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
            }
    	},
    	paths: {
    	    text: 'vendors/requirejs/text',
    	    backbone: 'vendors/backbone/backbone',
    		underscore: 'vendors/underscore/underscore',
    		jquery: 'vendors/jquery/jquery.min',
    		handlebars: 'vendors/handlebars/handlebars',
    		bootstrap: 'vendors/bootstrap/bootstrap.min'
    	}
    });
});