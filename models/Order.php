<?php


class Order
{

   
    public static function save($userName, $userPhone, $userComment, $userId, $products)
    {
        $db = Db::getConnection();
        if ($userId == ''){
            $userId = NULL;
        
        }
        $sql = 'INSERT INTO product_order (id, user_name, user_phone, user_comment,  user_id, products, status) '
                . 'VALUES (NULL, :user_name, :user_phone, :user_comment,  :user_id, :products, 1)';
        $products = json_encode($products);
        $result = $db->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);
        return $result->execute();
    }

    public static function getOrdersList()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT id, user_name, user_phone, date, status, user_id, products  FROM product_order ORDER BY id DESC');
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['status'] = $row['status'];
            $ordersList[$i]['user_id'] = $row['user_id'];
            $ordersList[$i]['products'] = $row['products'];
            $i++;
        }
        return $ordersList;
    }

    public static function getOrdersListByUser($userId)
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT id  FROM product_order WHERE user_id = $userId");
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[] = $row['id'];
        }
        return $ordersList;
    }


    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Новый';
                break;
            case '2':
                return 'Обработанный';
                break;
            case '3':
                return 'Оплаченный';
                break;
            case '4':
                return 'Отправленный';
                break;
            case '5':
                return 'Выполненный';
                break;
        }
    }


    public static function getOrderById($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product_order WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }


    public static function deleteOrderById($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM product_order WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }


    public static function updateOrderById($id, $userName, $userPhone, $userComment, $date, $status)
    {
        $db = Db::getConnection();
        $sql = "UPDATE product_order
            SET 
                user_name = :user_name, 
                user_phone = :user_phone, 
                user_comment = :user_comment, 
                date = :date, 
                status = :status 
            WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }
    public static function validate_nuber_phone ($number){
        if (strlen($number) != 12){
            return FALSE;
        }
        $number = substr($number, 1, 11);
        if(!preg_match("#^[0-9]{11,11}+$#", $number)){
            return FALSE;
        }
        return TRUE;

    }
}

