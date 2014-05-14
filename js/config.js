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
            'bootbox': {
                deps: ['jquery', 'bootstrap'],
                exports: 'bootbox'
            },
            'handlebars': {
                exports: 'Handlebars'
            },
            'jquery_cookie': {
                deps: ['jquery'],
                exports: 'jquery_cookie'
            },
            'jquery_ui': {
                deps: ['jquery'],
                exports: 'jquery_ui'
            }
    	},
    	paths: {
    	    text: 'vendors/requirejs/text',
    	    backbone: 'vendors/backbone/backbone',
    	    epoxy: 'vendors/backbone/epoxy',
    		underscore: 'vendors/underscore/underscore',
    		jquery: 'vendors/jquery/jquery.min',
    		jquery_cookie: 'vendors/jquery/jquery-cookie',
    		jquery_ui: 'vendors/jquery/jquery-ui',
    		handlebars: 'vendors/handlebars/handlebars',
    		bootstrap: 'vendors/bootstrap/bootstrap.min',
    		bootbox: 'vendors/bootstrap/bootbox'
    	}
    });
});