<?php


class User
{


    public static function register($name, $email, $password, $role='')
    {
        $db = Db::getConnection();
        $sql = "INSERT INTO user (id, name, email, password, role) "
                . "VALUES (NULL, :name, :email, :password, :role)";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':role', $role, PDO::PARAM_STR);
        return $result->execute();
    }


    public static function edit($id, $name, $password)
    {
        $db = Db::getConnection();
        $sql = "UPDATE user 
            SET name = :name, password = :password 
            WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }


    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();
        $user = $result->fetch();
        if ($user) {
  
            return $user['id'];
        }
        return false;
    }

   
 
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }
    public static function updateUserById($id, $options)
    {
        $db = Db::getConnection();
        $sql = "UPDATE user
            SET 
                name = :name, 
                email = :email, 
                password = :password, 
                role = :role
            WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':email', $options['email'], PDO::PARAM_STR);
        $result->bindParam(':password', $options['password'], PDO::PARAM_STR);
        $result->bindParam(':role', $options['role'], PDO::PARAM_INT);

        return $result->execute();
    }

    
    public static function createUser($options)
    {
        $db = Db::getConnection();
        $sql = "INSERT INTO user (id, name, email, password, role) "
                . "VALUES (NULL, :name, :email, :password, '')";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
        return 0;
    }

    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /user/login");
    }

   
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

   
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

   
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }

    
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

  
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

   
    public static function checkEmailExists($email)
    {     
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function getUserById($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    public static function getUsersList()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT id, name, email, password, role FROM user ORDER BY id ASC');
        $productsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['email'] = $row['email'];
            $productsList[$i]['password'] = $row['password'];
            $productsList[$i]['role'] = $row['role'];
            $i++;
        }
        return $productsList;
    }
  
    public static function deleteUserById($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM user WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
  
    public static function getImage($name, $pre='user_')
    {
        $noImage = 'no-image.jpg';
        $path = '/upload/images/users/';
        $pathToProductImage = $path . $pre . $name . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            return $pathToProductImage;
        }
        return $path . $noImage;
    }

}
