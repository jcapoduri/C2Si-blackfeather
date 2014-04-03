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
          window.Raven = Application;
          window.Raven.initialize();
      });
  }
);