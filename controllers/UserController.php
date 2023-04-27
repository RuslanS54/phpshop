<?php


class UserController
{

    public function actionRegister()
    {
        $name = false;
        $email = false;
        $password = false;
        $result = false;
        if (isset($_POST['submit'])) {
            $errors = false;
            $name = $_POST['name'];
            $email = $_POST['email'];
            if ($_POST['password1'] != $_POST['password2']) {
                $errors[] = 'Пароли не равны';
            }
            if (!preg_match("#[0-9]+#", $_POST['password1']) && !preg_match("#[0-9]+#", $_POST['password2'])) {
                $errors[] = "Пароль должен содержать как минимум одну цифру";
            }
            if (!preg_match("#[A-Z]+#", $_POST['password1']) && !preg_match("#[a-z]+#", $_POST['password2'])) {
                $errors[] = "Пароль должен содержать как минимум одну заглавную букву";
            }
            if (!preg_match("#[a-z]+#", $_POST['password1']) && !preg_match("#[a-z]+#", $_POST['password2'])) {
                $errors[] = "Пароль должен содержать как минимум одну прописную букву";
            }
            $password = $_POST['password1'];
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }
            if (md5($_POST['norobot']) != $_SESSION['randomnr2']) {
                $errors[] = 'Неправильная капча';
            }
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {

                $errors[] = ' Пароль не должен содержать спец. символы';
            }
            $salt = sha1($email);
            $password = md5($password . $salt);
            if ($errors == false) {

                $result = User::register($name, $email, $password);
                $id = User::checkUserData($email, $password);
                if ($result) {

                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/users/user_{$id}.jpg");
                    }
                };
            }
        }


        require_once(ROOT . '/views/user/register.php');
        return true;
    }


    public function actionLogin()
    {
        $email = false;
        $password = false;
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $errors = false;
            $file = 'error.txt';
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            $salt = sha1($email);
            $password = md5($password . $salt);
            $userId = User::checkUserData($email, $password);
            $db = Db::getConnection();
            if ($userId == false) {
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                User::auth($userId);
                if (isset($_POST["remember_me"])) {
                    $password_cookie_token = md5($email . $password . time());
                    $sql = "UPDATE user SET password_cookie_token='" . $password_cookie_token . "' WHERE email = '" . $email . "'";
                    $update_password_cookie_token = $db->prepare($sql);
                    $update_password_cookie_token = $update_password_cookie_token->execute();
                    if (!$update_password_cookie_token) {
                        echo "ERRROR!";
                    }
                    setcookie("password_cookie_token", $password_cookie_token, time() + (1000 * 60 * 60 * 24 * 30));
                } else {
                    if (isset($_COOKIE["password_cookie_token"])) {
                        $sql = "UPDATE users SET password_cookie_token = '' WHERE email = '" . $email . "'";
                        $update_password_cookie_token = $db->prepare($sql);
                        $update_password_cookie_token = $update_password_cookie_token->execute();
                        setcookie("password_cookie_token", "", time() - 3600);
                    }
                }
                header("Location: /cabinet");
            }
        }
        require_once(ROOT . '/views/user/login.php');
        return true;
    }


    public function actionLogout()
    {
        session_start();
        unset($_SESSION["user"]);
        header("Location: /");
    }
}
