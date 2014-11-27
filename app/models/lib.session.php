<?php

function session() {
	session_name(_SES_NAME);
    session_start();
}

function set_var( $var_name, $var_value ) {
    if( !$var_name || !$var_value ) {
        return false;
    }
    $_SESSION[$var_name] = $var_value;
}

function get_var( $var_name ) {
    return $_SESSION[$var_name];
}

function del_var( $var_name ) {
    unset( $_SESSION[$var_name] );
}

function del_vars( $arr ) {
    if( !is_array( $arr ) )
    {
        return false;
    }
    foreach( $arr as $element )
    {
        unset( $_SESSION[$element] );
    }
    return true;
}

function del_all_vars() {
    del_all_vars();
}

function destroy_session() {
    unset($_SESSION['USER']);
}
function destroy_admin_session() {
    unset($_SESSION['ADMIN-USER']);
	
	//setcookie(COOKIE_NAME . "[admin_login]", '', time() - 3600);
	//setcookie(COOKIE_NAME . "[admin_password]", '', time() - 3600);
}

function attempt_admin_login($mail, $password) {
			
	
	$accounts = get_array_from_query("SELECT * FROM " . _TABLE__ADMIN_USERS . " WHERE mail = :mail AND password = :mdp", 
	$mail, $password);
	
	// No account found
	if(sizeof($accounts) == 0) {
		//$notice = new Notice('failure', 'Aucun compte correspondant.');
		//$notice->sessionize();
		return false;
	}
	// More than one account found
	elseif(sizeof($accounts) > 1) {
		//$notice = new Notice('failure', 'Plus d\'un compte correspondant à ces identifiants.');
		//$notice->sessionize();
		return false;
	}
	// One account found - login
	else {
		
		if($accounts[0]->statut != 0) {
			$session_authed = true;
			
			$_SESSION["ADMIN-USER"]["authed"] 		= $session_authed;
			$_SESSION["ADMIN-USER"]["id"] 			= $accounts[0]->id;
			$_SESSION["ADMIN-USER"]["mail"] 		= $accounts[0]->mail;
			$_SESSION["ADMIN-USER"]["firstname"] 	= $accounts[0]->firstname;
			$_SESSION["ADMIN-USER"]["name"] 		= $accounts[0]->name;
			$_SESSION["ADMIN-USER"]["statut"] 		= $accounts[0]->statut;

			return true;
		}
		else {
			return false;
		}
		
	}
}

function attempt_login($mail, $password, $remember = false) {
		
	global $lang;
	
	$this->user_mail = mysql_real_escape_string($mail);
	$this->user_password = mysql_real_escape_string($password);
	
	$accounts = Sql::get_array_from_query(sprintf("SELECT id, login, password, statut FROM " . TABLES__ADMIN_USERS . " WHERE login = '%s' AND password = '%s'", 
	$this->user_mail, $this->user_password));
	
	// No account found
	if(sizeof($accounts) == 0) {
		$notice = new Notice('failure', 'Aucun compte correspondant.');
		$notice->sessionize();
		return false;
	}
	// More than one account found
	elseif(sizeof($accounts) > 1) {
		$notice = new Notice('failure', 'Plus d\'un compte correspondant à ces identifiants.');
		$notice->sessionize();
		return false;
	}
	// One account found - login
	else {
		
		if($accounts[0]['statut'] == 1) {
			$this->session_admin_authed = true;
			
			$session_admin_user = New Admin_User($accounts[0]['id']);
			
			$_SESSION["ADMIN-USER"]["authed"] 	= $this->session_admin_authed;
			$_SESSION["ADMIN-USER"]["id"] 		= $session_admin_user->id;
			$_SESSION["ADMIN-USER"]["login"] 	= $session_admin_user->login;
			$_SESSION["ADMIN-USER"]["level"] 	= $session_admin_user->level;
			
			if($remember !== false) {
				setcookie(COOKIE_NAME . "[admin_login]", $session_admin_user->login, time() + 60*60*24*30*365);
				setcookie(COOKIE_NAME . "[admin_password]", $session_admin_user->password, time() + 60*60*24*30*365);
			}
			
			return true;
		}
		else {
			$notice = new Notice('failure', 'Votre compte est désactivé. Authentification impossible.');
			$notice->sessionize();
			return false;
		}
		
	}
}

function log_auth($user) {		
	sql_query(sprintf("INSERT INTO " . TABLES__AUTH_LOGS . " (log_id, log_datetime, log_user_id, log_user_ip) VALUES('', NOW(), '%d', '%s')", $user->id(), $_SERVER['REMOTE_ADDR']));
}

function is_authed() {
	if(isset($_SESSION["USER"]["authed"])) {
		return $_SESSION["USER"]["authed"];
	}
	else {
		return false;
	}
}
function is_admin_authed() {
	if(isset($_SESSION["ADMIN-USER"]["authed"])) {
		return $_SESSION["ADMIN-USER"]["authed"];
	}
	else {
		return false;
	}
}











?>