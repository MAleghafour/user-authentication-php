<?php

require "bootstrap/init.php";

if(isLoggedIn()){
    redirect();
}

// deleteExpiredTokens();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = $_GET['action'];
    $params = $_POST;

    # validation data
    if ($action == 'register') {

        if (empty($params['name']) || empty($params['phone']) || empty($params['email']))
            setErrorAndRedirect('All input feilds required!', 'auth.php?action=register');
        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL))
            setErrorAndRedirect('Enter the valid email address!', 'auth.php?action=register');
        if (isUserExists($params['email'], $params['phone']))
            setErrorAndRedirect('User Exists with this data!', 'auth.php?action=register');
        #requested data is ok
        if (createUser($params)) {
            redirect('auth.php?action=login');
        }
    }

    if ($action == 'login') {
        # validation data
        if (empty($params['input']))
            setErrorAndRedirect('Please enter your email or number!', 'auth.php?action=login');
        if (is_numeric($params['input']) && !preg_match('/^[0-9]{11,13}\z/',$params['input'])){
            setErrorAndRedirect('Enter the valid phone number!', 'auth.php?action=login');
        }
        if (!is_numeric($params['input']) && (!filter_var($params['input'], FILTER_VALIDATE_EMAIL))){
            setErrorAndRedirect('Enter the valid email address!', 'auth.php?action=login');
        }
        if (is_numeric($params['input'])){
            if (!isUserExists(phone: $params['input'])){
                setErrorAndRedirect('User Not Exists: <br>' . $params['input'], 'auth.php?action=login');
            }
        }else{
            if (!isUserExists(email: $params['input']))
                setErrorAndRedirect('User Not Exists: <br>' . $params['input'], 'auth.php?action=login');
        }
        

        $_SESSION['emailORphon'] = $params['input'];
        redirect('auth.php?action=verify');
    }

    if ($action == 'verify') {
        try {
            $token = findTokenByHash($_SESSION['hash'])->token;
            if ($token === $params['token']) {
                $session = bin2hex(random_bytes(32));
                if (is_numeric($_SESSION['emailORphon'])){
                    changeLoginSession(phone: $_SESSION['emailORphon'], session: $session);
                }else{
                    changeLoginSession(email: $_SESSION['emailORphon'], session: $session);
                }
                setcookie('auth', $session, time() + 1728000, '/');
                deleteTokenByHash($_SESSION['hash']);
                unset($_SESSION['hash'], $_SESSION['emailORphon']);
                redirect();
            } else {
                setErrorAndRedirect('The entered Token is wrong!', 'auth.php?action=verify');
            }
        } catch (Exception $e) {
            setErrorAndRedirect('Please enter your email', 'auth.php?action=login');
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'verify' && !empty($_SESSION['emailORphon'])) {
    if (is_numeric($_SESSION['emailORphon'])){
        if (!isUserExists(phone:$_SESSION['emailORphon']))
            setErrorAndRedirect('User Not Exists with this data!', 'auth.php?action=login');
    }else{
        if (!isUserExists(email: $_SESSION['emailORphon']))
            setErrorAndRedirect('User Not Exists: <br>' . $params['input'], 'auth.php?action=login');
    }
    

    if (isset($_SESSION['hash']) && isAliveToken($_SESSION['hash'])) {
        
        if (is_numeric($_SESSION['emailORphon'])){
            try {
                sendTokenByPhon($_SESSION['emailORphon'], findTokenByHash($_SESSION['hash'])->token);
            } catch (Exception $e) {
                setErrorAndRedirect('Please enter your email', 'auth.php?action=login');
            }
        }
        else{
            sendTokenByMail($_SESSION['emailORphon'], findTokenByHash($_SESSION['hash'])->token);
        }
        
    } else {
        if (is_numeric($_SESSION['emailORphon'])){
            try {
                $tokenResult = createLoginToken();
                sendTokenByPhon($_SESSION['emailORphon'], $tokenResult['token']);
                $_SESSION['hash'] = $tokenResult['hash'];
            } catch (Exception $e) {
                setErrorAndRedirect('Please enter your email', 'auth.php?action=login');
            }
        }
        else{
            $tokenResult = createLoginToken();
            sendTokenByMail($_SESSION['emailORphon'], $tokenResult['token']);
            $_SESSION['hash'] = $tokenResult['hash'];
        }
    }
        include 'tpl/verify-tpl.php';
}

if (isset($_GET['action']) and $_GET['action'] == 'register') {
    include "tpl/register-tpl.php";
} else {
    include "tpl/login-tpl.php";
}


