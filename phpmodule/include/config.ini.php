<?PHP
$debug_mod   = "Y";
$host_name   = "localhost";
$protocol    = "http";
$domain_name = "localhost";
$web_root_path = "/var/www/html";

############################################################################
# defient
############################################################################
$config["project_id"]             = "tool"; 
$config["default_main"]           = "/tool"; 
$config["default_charset"]        = "UTF-8";
$config["sql_charset"]            = "utf8";
$config["cookie_path"]            = "/";  
$config["cookie_domain"]          = "";  
$config["tpl_type"]               = "php"; 
$config["module_type"]            = "php";	  		// or xml
$config["fix_time_zone"]          = -8 ;                          // modify time zone 
$config["default_time_zone"]      = 8 ;                           // default time zone 
$config["max_page"]               = 20 ;
$config["max_page5"]              = 50 ;
$config["max_range"]              = 10 ;
$config["encode_type"]            = "aes-128-gcm" ; 			// crypt or md5
$config["encode_key"]             = "%^$#@%S_d_+!" ; 			// crypt encode key
$config["encode_iv"]              = "ji3!g4@au4#a83$";
$config["session_time"]           = 15 ; 			// Session time out
$config["default_lang"]           = "zh_TW"	; 			// en , tc
$config["default_template"]       = "default"	; 		// 
$config["default_topn"]           = 10 ; 			// default top n
$config["debug_mod"]              = $debug_mod ; 			// enable all the debug console , N : disable , Y : enable 
$config["domain_name"]            = $domain_name;
$config["protocol"]               = $protocol;
$config["transaction_time_limit"] = 5; //The minimized time between two transaction

############################################################################
# path
############################################################################
$config["path_admin"]           = $web_root_path.$config["default_main"]."/phpmodule";
$config["path_admin_root"]      = $web_root_path.$config["default_main"];
$config["path_class"]           = $config["path_admin"]."/class" ; 
$config["path_function"]        = $config["path_admin"]."/function" ; 
$config["path_include"]         = $config["path_admin"]."/include" ; 
$config["path_bin"]             = $config["path_admin"]."/bin" ; 
$config["path_data"]            = $config["path_admin"]."/data" ; 
$config["path_cache"]           = $config["path_admin"]."/data/cache" ; 
$config["path_sources"]         = $config["path_admin"]."/sources/".$config["module_type"] ; 
$config["path_style"]           = $config["path_admin"]."/template/".$config["tpl_type"]; 
$config["path_language"]        = $config["path_admin"]."/language" ; 
$config["path_images"]          = dirname($config["path_admin"])."/imgs" ; 
$config["path_javascript"]      = $config["path_admin"]."/javascript/" ; 
$config['path_upload_data'] 	= $config['path_admin_root'].'/data';
//$config["path_atd"]             = "/Library/WebServer/Documents/lib"; // atd lib path

$config["path_block"]           = $config['path_style'].'/'.$config['default_template'].'/block';
$config["path_onload"]          = $config['path_style'].'/'.$config['default_template'].'/onload';
$config["path_left"]            = $config['path_onload'].'/left.php';
$config["path_header"]          = $config['path_onload'].'/header.php';
$config["path_head"]            = $config["path_block"].'/head.php';
$config["path_footer"]          = $config["path_block"].'/footer.php';
$config["path_css"]             = $config["default_main"]."/css";
$config["path_js"]              = $config["default_main"]."/js";
$config["path_assets"]          = $config["default_main"]."/assets";
$config["path_mysql"]           = $config["path_class"]."/mysql.ini.php";
$config["path_lib"]             = $web_root_path."/lib";
$config["path_uploadfilePath"]  = $config['path_admin_root'].'/upload';
$config["path_examplefilePath"]  = $config['path_admin_root'].'/example';

############################################################################
# sql Shaun 
############################################################################
$config["db"][0]["charset"]  = "utf8" ;
$config["db"][0]["host"]     = $host_name ;
$config["db"][0]["type"]     = "mysql";
$config["db"][0]["username"] = "root"; 
$config["db"][0]["password"] = 'see321';
$config["db"][0]["prefixid_db"] = $config["project_id"];
$config["db"][0]["prefixid_table"] = $config["project_id"];
$config["db"][0]["prefixid_index"] = $config["project_id"];

$config["db"][0]["db_name_0"] = $config["db"][0]["prefixid_db"]."_member";
$config["db"][0]["db_name_1"] = $config["db"][0]["prefixid_db"]."_tools";

############################################################################
# Facebook 
############################################################################
$config["fb"][0]["path_facebook_sdk"] = $config['path_lib']."/facebook-sdk-v5/autoload.php";

$config["fb"][0]["app_id"] = "1681645575432526";
$config["fb"][0]["app_secret"] = "89f49450a200674fdd3add8380eb53ed";
$config["fb"][0]["default_graph_version"] = "v2.5";

###########################################################################
# shopee 
############################################################################

$config['shopee'][0]['shopid'] = 12537246;
$config['shopee'][0]['partner_id'] = 841065;
$config['shopee'][0]['key'] = "91d64020ebd5750af635016f70e36dda6f4575710d60bb5778e141286cdf75ba";
