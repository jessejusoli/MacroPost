<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("Brazil/East");
require_once('_config.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Definiçoes
if($_SERVER['HTTP_HOST'] == 'localhost'){
    define("SERVIDOR", $config['SERVIDOR_LOCAL']);
    define("USUARIO", $config['USUARIO_LOCAL']);
    define("SENHA", $config['SENHA_LOCAL']);
    define("BANCO", $config['BANCO_LOCAL']);
} else {
    define("SERVIDOR", $config['SERVIDOR']);
    define("USUARIO", $config['USUARIO']);
    define("SENHA", $config['SENHA']);
    define("BANCO", $config['BANCO']);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Definiçoes de Pastas
if($config['SSL']){

    //para ssl
    if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) { } else {
        $new_url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        echo "<script>window.location='$new_url';</script>";
        exit;
    }

    if($_SERVER['HTTP_HOST'] == 'localhost'){
    	$config_dominio = "https://".$_SERVER['HTTP_HOST']."/".$config['PASTA_LOCAL']."/";
    } else {
        if($config['PASTA']){
    	    $config_dominio = "https://".$_SERVER['HTTP_HOST']."/".$config['PASTA']."/"; 
    	} else {
    		$config_dominio = "https://".$_SERVER['HTTP_HOST']."/";
    	}
    }

} else {

    if($_SERVER['HTTP_HOST'] == 'localhost'){
        $config_dominio = "http://".$_SERVER['HTTP_HOST']."/".$config['PASTA_LOCAL']."/";
    } else {
        if($config['PASTA']){
            $config_dominio = "http://".$_SERVER['HTTP_HOST']."/".$config['PASTA']."/"; 
        } else {
            $config_dominio = "http://".$_SERVER['HTTP_HOST']."/";
        }
    }

}

define("DOMINIO", $config_dominio);
define("PASTA_CLIENTE", $config_dominio."sistema/arquivos/");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Outras Definições
define("AUTOR", "ComprePronto.com.br");
define("TOKEN", md5($config['TOKEN']) );
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//SISTEMA
session_start();

define("CONTROLLERS", '_controllers/'); 
define("VIEWS", '_views/');
define("MODELS", '_models/');
define("LAYOUT", $config_dominio.VIEWS);

require_once('_system/system.php');
require_once('_system/mysql.php');
require_once('_system/controller.php');
require_once('_system/model.php');

//analytcs
define("analytics", $config['analytics']);

function __autoload( $arquivo ){
 	require_once(MODELS.$arquivo.".php");
}

$start = new system();
$start->run();