require(
  [
    'js/config.js'
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
          window.Raven = null;
          var app = new Application();
          window.Raven = _.extend(app, Backbone.Events);
          window.Raven.init();
      });
  }
);