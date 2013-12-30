require(
  [
    './js/config.js'
  ],
  function() {
    'use strict';
    //Start ApplicationModule
    require(
      [
        'app/application.module'
      ],
      function(Application) {
        Application.init();
      });
  }
);