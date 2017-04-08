<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('cn_topspace', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
  'dsn' => 'mysql:host=localhost;dbname=topspacecn',
  'user' => 'root',
  'password' => 'root',
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => false,
  ),
));
$manager->setName('cn_topspace');
$serviceContainer->setConnectionManager('cn_topspace', $manager);
$serviceContainer->setAdapterClass('us_topspace', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
  'dsn' => 'mysql:host=mysql.leowrd.com;dbname=topspacehl',
  'user' => 'admintopspace',
  'password' => 'adminadmin',
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => false,
  ),
));
$manager->setName('us_topspace');
$serviceContainer->setConnectionManager('us_topspace', $manager);
$serviceContainer->setDefaultDatasource('us_topspace');