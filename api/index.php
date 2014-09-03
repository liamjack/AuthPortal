<?php

// Includes

require 'flight/Flight.php';
require 'classes/auth.class.php';
require 'classes/config.class.php';

require 'languages/en.php';
require 'database.php';

// Settings 

Flight::set('lang', $lang);

Flight::set('flight.log_errors', true);
Flight::set('flight.views.path', 'views/');

// Register classes

Flight::register('db', 'PDO', array("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass));
Flight::register('config', 'Config', array(Flight::db()));
Flight::register('auth', 'Auth', array(Flight::db(), Flight::config()));

// Set Timezone

date_default_timezone_set(Flight::config()->site_timezone);

// Check if user is logged in

if(Flight::request()->cookies->{Flight::config()->cookie_name} == false) {
	Flight::set('loggedin', false);
} else {
	if(Flight::auth()->checkSession(Flight::request()->cookies->{Flight::config()->cookie_name})) {

		Flight::set('loggedin', true);

		$uid = Flight::auth()->getSessionUID(Flight::request()->cookies->{Flight::config()->cookie_name});
		Flight::set('userdata', Flight::auth()->getUser($uid));
	} else {
		Flight::set('loggedin', false);

		setcookie(Flight::config()->cookie_name, "", time() - 3600, Flight::config()->cookie_path, Flight::config()->cookie_domain, Flight::config()->cookie_secure, Flight::config()->cookie_http);
	}
}

// Routes

Flight::route('POST /auth/login', function(){
	
	if(Flight::get('loggedin') == true) {
		$call['message'] = Flight::get('lang')['already_authenticated'];
		$call['code'] = 403;
	} else {
	    $call = Flight::auth()->login(Flight::request()->data->username, Flight::request()->data->password, Flight::request()->data->remember);
	    $call['message'] = Flight::get('lang')[$call['message']];

	    if($call['code'] == 200) {
	    	setcookie(Flight::config()->cookie_name, $call['hash'], $call['expire'], Flight::config()->cookie_path, Flight::config()->cookie_domain, Flight::config()->cookie_secure, Flight::config()->cookie_http);
	    }
	}

    Flight::json($call, $call['code']);
});

Flight::route('POST /auth/register', function(){
	if(Flight::get('loggedin') == true) {
		$call['message'] = Flight::get('lang')['already_authenticated'];
		$call['code'] = 403;
	} else {
	    $call = Flight::auth()->register(Flight::request()->data->email, Flight::request()->data->username, Flight::request()->data->password, Flight::request()->data->repeatpassword);
	    $call['message'] = Flight::get('lang')[$call['message']];
	}

    Flight::json($call, $call['code']);
});

Flight::route('POST /auth/reset', function(){
	if(Flight::get('loggedin') == true) {
		$call['message'] = Flight::get('lang')['already_authenticated'];
		$call['code'] = 403;
	} else {
	    $call = Flight::auth()->requestReset(Flight::request()->data->email);
	    $call['message'] = Flight::get('lang')[$call['message']];
	}

    Flight::json($call, $call['code']);
});

Flight::route('POST /auth/resetpass', function(){
	if(Flight::get('loggedin') == true) {
		$call['message'] = Flight::get('lang')['already_authenticated'];
		$call['code'] = 403;
	} else {
	    $call = Flight::auth()->resetPass(Flight::request()->data->key, Flight::request()->data->password, Flight::request()->data->repeatpassword);
	    $call['message'] = Flight::get('lang')[$call['message']];
	}

    Flight::json($call, $call['code']);
});

Flight::route('POST /auth/activate', function(){
	if(Flight::get('loggedin') == true) {
		$call['message'] = Flight::get('lang')['already_authenticated'];
		$call['code'] = 403;
	} else {
	    $call = Flight::auth()->activate(Flight::request()->data->key);
	    $call['message'] = Flight::get('lang')[$call['message']];
	}

    Flight::json($call, $call['code']);
});

Flight::route('POST /auth/resendactivation', function(){
	if(Flight::get('loggedin') == true) {
		$call['message'] = Flight::get('lang')['already_authenticated'];
		$call['code'] = 403;
	} else {
	    $call = Flight::auth()->resendActivation(Flight::request()->data->email);
	    $call['message'] = Flight::get('lang')[$call['message']];
	}

    Flight::json($call, $call['code']);
});

Flight::route('POST /auth/password', function(){
	if(Flight::get('loggedin') == false) {
		$call['message'] = Flight::get('lang')['authentication_required'];
		$call['code'] = 401;
	} else {
	    $call = Flight::auth()->changePassword(Flight::get('userdata')['uid'], Flight::request()->data->password, Flight::request()->data->newpassword, Flight::request()->data->repeatnewpassword);
	    $call['message'] = Flight::get('lang')[$call['message']];
	}

    Flight::json($call, $call['code']);
});

Flight::route('POST /auth/email', function(){
	if(Flight::get('loggedin') == false) {
		$call['message'] = Flight::get('lang')['authentication_required'];
		$call['code'] = 401;
	} else {
	    $call = Flight::auth()->changeEmail(Flight::get('userdata')['uid'], Flight::request()->data->email, Flight::request()->data->password);
	    $call['message'] = Flight::get('lang')[$call['message']];
	}

    Flight::json($call, $call['code']);
});

Flight::route('POST /auth/delete', function(){
	if(Flight::get('loggedin') == false) {
		$call['message'] = Flight::get('lang')['authentication_required'];
		$call['code'] = 401;
	} else {
	    $call = Flight::auth()->deleteUser(Flight::get('userdata')['uid'], Flight::request()->data->password);
	    $call['message'] = Flight::get('lang')[$call['message']];

	    if($call['code'] == 200) {
	    	setcookie(Flight::config()->cookie_name, "", time() - 3600, Flight::config()->cookie_path, Flight::config()->cookie_domain, Flight::config()->cookie_secure, Flight::config()->cookie_http);
	    }
	}

    Flight::json($call, $call['code']);
});

Flight::route('GET /auth/logout', function(){
	if(Flight::get('loggedin') == false) {
		$call['message'] = Flight::get('lang')['authentication_required'];
		$call['code'] = 401;
	} else {
	    $call = Flight::auth()->logout(Flight::request()->cookies->{Flight::config()->cookie_name});    
	    setcookie(Flight::config()->cookie_name, "", time() - 3600, Flight::config()->cookie_path, Flight::config()->cookie_domain, Flight::config()->cookie_secure, Flight::config()->cookie_http);

	    $call['message'] = Flight::get('lang')['logged_out'];
		$call['code'] = 200;
	} 

	Flight::json($call, $call['code']);
});

Flight::route('GET /auth', function(){
	if(Flight::get('loggedin') == false) {
		$call['loggedin'] = false;
	} else {
		$call['loggedin'] = true;
	    $call['userdata'] = Flight::get('userdata');

	    unset($call['userdata']['id']);
	    unset($call['userdata']['password']);
		unset($call['userdata']['salt']);
		unset($call['userdata']['isactive']);
	}

	$call['code'] = 200;

    Flight::json($call, $call['code']);
});

// Error mapping

Flight::map('error', function(Exception $ex){
    Flight::render('500', array('message' => $ex->getMessage(), 'file' => $ex->getFile(), 'line' => $ex->getLine()));
});

Flight::map('notFound', function(){
    Flight::render('404');
});

// Execute Framework

Flight::start();

?>