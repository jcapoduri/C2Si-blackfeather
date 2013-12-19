require(
  [
    './js/config.js'
  ],
  function() {
    'use strict';
    //Start ApplicationModule
    require(
      [
        'app/application'
      ],
      function(Application) {
        Application.init();
      });
  }
);