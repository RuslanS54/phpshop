<?php


class AdminUserController extends AdminBase
{
    public function actionIndex()
    {
        self::checkAdmin();
        $productsList = User::getUsersList();
        require_once(ROOT . '/views/admin_user/index.php');
        return true;
    }

  
    public function actionCreate()
    {
        self::checkAdmin();
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $errors = false;
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
            if ($errors == false) {
                $result = User::register($name, $email, $password, $role);
                if ($result) {
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/users/user_{$result}.jpg");
                    }
                };
                header("Location: /admin/user");
            }
        }
        require_once(ROOT . '/views/admin_user/create.php');
        return true;
    }


    public function actionUpdate($id)
    {
        self::checkAdmin();
        $product = User::getUserById($id);
        if (isset($_POST['submit'])) {     
            $options['name'] = $_POST['name'];
            $options['email'] = $_POST['email'];
            $options['password'] = $_POST['password'];
            $options['role'] = $_POST['role'];
            $errors = false; 
            if (!User::checkName($options['name'])) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkEmail($options['email'])) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($options['password'])) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }   
            if ($errors == false) {
                if (User::updateUserById($id, $options)) {
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/user_{$id}.jpg");
                    }
                };
                header("Location: /admin/user");
            }
        }
       
        require_once(ROOT . '/views/admin_user/update.php');
        return true;
    }

   
    public function actionDelete($id)
    {
        self::checkAdmin();
        if (isset($_POST['submit'])) {
            User::deleteUserById($id);
            header("Location: /admin/user");
        }
        require_once(ROOT . '/views/admin_user/delete.php');
        return true;
    }

}
