<?php

namespace Nd;

require 'error.php';

class persistence {
    protected $nd;
    static protected $basis = 'CREATE TABLE IF NOT EXISTS `basic` (
                                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `deleted` tinyint(1) NOT NULL DEFAULT \'0\',
                                  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  `mtime` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                                  `dtime` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                                  PRIMARY KEY (`id`),
                                  KEY `deleted` (`deleted`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;'

    static protected $basisrel = 'CREATE TABLE IF NOT EXISTS `basic_rel` (
                                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `deleted` tinyint(1) NOT NULL DEFAULT \'0\',
                                  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  `mtime` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                                  `dtime` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                                  `father` int(11) NOT NULL,
                                  `child` int(11) NOT NULL,
                                  PRIMARY KEY (`id`),
                                  KEY `deleted` (`deleted`),
                                  KEY `father` (`father`,`child`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';

    public function __construct (neodynium $system) {
        $this->nd = $system;
    };

    public function generatePersistence() {

    }

    protected function generateBasis () {};

    protected function generateEntity () {};

    protected function generateRelation () {};

    /*public function () {}

    public function () {}*/
};

?>