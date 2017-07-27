<?php

class Utils {
    public static function redirect($uri = '') {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$uri, TRUE, 302);
        exit;
    }
}

class OAuthFB {

    const APP_ID = 1234567890; //App ID/API Key
    const APP_SECRET = 'sometestappsecret'; //App Secret
    const URL_CALLBACK = 'http://example.com/oauth/fb.php'; //URL Вашего сайта, на который произойдет перенаправление 
    const URL_OATH = 'https://www.facebook.com/dialog/oauth';
    const URL_ACCESS_TOKEN = 'https://graph.facebook.com/oauth/access_token';
    const URL_GET_ME = 'https://graph.facebook.com/me';

    private static $token;
    public static $userId;
    public static $userData;

    /**
     * @url https://developers.facebook.com/docs/reference/dialogs/oauth
     */
    public static function goToAuth()
    {
        $_SESSION['state'] = md5(uniqid(rand(), TRUE));
        Utils::redirect(self::URL_OATH .
            '?client_id=' . sprintf('%.0f', self::APP_ID) .
            '&redirect_uri=' . urlencode(self::URL_CALLBACK) .
            "&state=" . $_SESSION['state']);
    }

    public static function getToken($code) {

        $url = self::URL_ACCESS_TOKEN .
            '?client_id=' . sprintf('%.0f', self::APP_ID) .
            '&redirect_uri=' . urlencode(self::URL_CALLBACK) .
            '&client_secret=' . self::APP_SECRET .
            '&code=' . $code;

        if (!($response = @file_get_contents($url))) {
            return false;
        }

        parse_str($response, $result);

        if (empty($result['access_token'])) {
            return false;
        }

        self::$token = $result['access_token'];
        return true;
    }

    /**
     * Если данных недостаточно, то посмотрите что можно ещё запросить по этой ссылке
     * @url https://developers.facebook.com/docs/graph-api/reference/user
     */
    public static function getUser() {

        if (!self::$token) {
            return false;
        }

        $url = self::URL_GET_ME . '?fields=id,name&access_token=' . self::$token;

        if (!($user = @file_get_contents($url))) {
            return false;
        }

        $user = json_decode($user);
        if (empty($user)) {
            return false;
        }

        self::$userId = $user->id;
        return self::$userData = $user;
    }

    public static function checkState($state) {
        return (isset($_SESSION['state']) && ($_SESSION['state'] === $state));
    }
}

// Пример использования класса:
session_start();
if (!empty($_GET['error'])) {
    // Пришёл ответ с ошибкой. Например, юзер отменил авторизацию.
    die($_GET['error']);
} elseif (empty($_GET['code'])) {
    // Самый первый запрос
    OAuthFB::goToAuth();
} else {
    // Пришёл ответ без ошибок после запроса авторизации

    if (!OAuthFB::checkState($_GET['state'])) {
        die("The state does not match. You may be a victim of CSRF.");
    }

    if (!OAuthFB::getToken($_GET['code'])) {
        die('Error - no token by code');
    }

    $user = OAuthFB::getUser();
    print_r($user);
    /*
     * Вот и всё - мы узнали основные данные авторизованного юзера.
     * $user в этом примере состоит из двух полей: id, name.
     * Делайте с ними что угодно - регистрируйте, авторизуйте, ругайте...
     */
}

