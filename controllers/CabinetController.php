<?php


class CabinetController
{


    public function actionIndex()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $orderId = Order::getOrdersListByUser($userId);
        $order = array();
        $productsQuantity = array();
        $productsIds = array();
        $products = array();
        foreach ($orderId as $i) {
            $order[$i] = Order::getOrderById($i);
            $productsQuantity[$i] = json_decode($order[$i]['products'], true);
            $productsIds[$i] = array_keys($productsQuantity[$i]);
            $products[$i] = Product::getProdustsByIds($productsIds[$i]);
        }
        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }


    public function actionEdit()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $name = $user['name'];
        $password = $user['password'];
        $result = false;
        if (isset($_POST['submit'])) {
            $errors = false;
            if ($_POST['password1'] != $_POST['password2']) {
                $errors[] = 'Пароли не равны';
            }
            if (!preg_match("#[0-9]+#", $_POST['password1']) || !preg_match("#[0-9]+#", $_POST['password2'])) {
                $errors[] = "Пароль должен содержать как минимум одну цифру";
            }
            if (!preg_match("#[A-Z]+#", $_POST['password1']) || !preg_match("#[a-z]+#", $_POST['password2'])) {
                $errors[] = "Пароль должен содержать как минимум одну заглавную букву";
            }
            if (!preg_match("#[a-z]+#", $_POST['password1']) || !preg_match("#[a-z]+#", $_POST['password2'])) {
                $errors[] = "Пароль должен содержать как минимум одну прописную букву";
            }
            $name = $_POST['name'];
            $password = $_POST['password1'];
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            $salt = sha1($user['email']);
            $password = md5($password . $salt);
            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
                if ($result) {

                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/users/user_{$userId}.jpg");
                    }
                };
            }
        }
        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }
}
