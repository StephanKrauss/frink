<?php
namespace tools;
/**
* Wrapper zum konvertieren von dynamischen RedBean aufrufen in statische Aufrufe
*
* @author Stephan Krauss
* @copyright Stephan Krauss
* @lisence MIT
* @package Tool
* @date 31.05.2016
*/
class redbeanWrapper
{
	public function __call($method,$args){
		return call_user_func_array('\RedBeanPHP\R::' . $method, $args);
	}
}
