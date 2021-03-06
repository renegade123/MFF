<?php 
/** 检查是否是开发环境并选择报错方式 **/
function serReporting(){
	if(DEVELOPMENT_ENVIRONMENT == true){
		error_reporting(E_ALL);
		ini_set(('display_errors','On');
	}else{
		error_reporting(E_ALL);
		ini_set('display_errors','Off');
		ini_set('log_errors','On');
		ini_set('error_log', ROOT.DS.'tmp'.DS.'error.log');
	}
}
/** **/
function stripSlashesDeep($value) {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}
 
function removeMagicQuotes() {
	if ( get_magic_quotes_gpc() ) {
		$_GET    = stripSlashesDeep($_GET   );
		$_POST   = stripSlashesDeep($_POST  );
		$_COOKIE = stripSlashesDeep($_COOKIE);
	}
}

/** 移除全局变量 **/
function unregisterGlobals(){
	if(ini_get('register_globals'){
		$array = ['_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES'];
		foreach($array as $value){
			foreach($GLOBALS[$valus] as $key=>$value){
				if($value === $GLOBALS[$key]){
					unset($value);
				}
			}
		}
	}
}
/** 主程序 **/
function callHook(){
	global $url;
	$urlArray = array();
	$urlArray = explode($url,'/');

//解析url获取controller和action
	$controller = $urlArray[0];
	array_shift($urlArray);
	$action = $urlArray[0];
	array_shift($urlArray);
	$queryString = $urlArray;
/*创建controller,model对象
	*controller规则：itemsController
	*model规则：Item
*/
	$controllerName = $controller;
	$controller = ucwords($controller);
	$model = rtrim($controller,'s');
	$controller .= 'Controller';
	$dispatch = new $controller($model,$controllerName,$action);
	if(int(method_exists($controller,$action)){
		call_user_func_array(array($dispatch,$action),$queryString);
	}else{
		
	}
}
/** 自动加载需要的类 **/
function __autoload($className){
	if(file_exists(ROOT.DS.'library' . DS . strtolower($className).'.class.php')){
		 require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
	} else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
	} else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
	} else {
		/* Error Generation Code Here */
	}
}