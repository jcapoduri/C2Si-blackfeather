require(
  [
    'config.js'
  ],
  function() {
    'use strict';
    //Start ApplicationModule
    require(
      [
        'backbone',
        'app/application'
      ],
      function(Backbone, Application) {
          var app = new Application;
          window.Raven = _.extend(app, Backbone.Events);
      });
  }
);