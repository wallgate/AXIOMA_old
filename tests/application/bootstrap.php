<?

error_reporting(E_ALL | E_STRICT);

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

define('APPLICATION_ENV', 'testing');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));

require_once 'Zend/Application.php';

$application = new Zend_Application( APPLICATION_ENV, APPLICATION_PATH.'/configs/application.ini');
$application->getBootstrap()->bootstrap('doctrine');

$config = $application->getOption('doctrine');

$cli = new Doctrine_Cli($config);
@$cli->run(array('Doctrine', 'build-all-reload', 'force'));