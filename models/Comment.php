<?php


class Comment{

    public static function addComments( $options){
        $db = Db::getConnection();

        $sql = 'INSERT INTO comments '
                . '(`id_comment`, `id_product`, `name_user`, `id_user`, `text_comments`, `date_comments`) '
                . 'VALUES '
                . '(NULL, :id_product, :name_user, :id_user, :text_comments, CURRENT_TIMESTAMP)';
        $result = $db->prepare($sql);
        $result->bindParam(':id_product', $options['id_product'], PDO::PARAM_INT);
        $result->bindParam(':name_user', $options['name_user'], PDO::PARAM_STR);
        $result->bindParam(':id_user', $options['id_user'], PDO::PARAM_INT);
        $result->bindParam(':text_comments', $options['text_comments'], PDO::PARAM_STR);
        if (!$result->execute()) {
            echo "\nPDO::errorInfo():\n";
            print_r($db->errorInfo());
            print_r($result);
        }
        return 0;
    }
    public static function getCommentsProduct ($idProduct){
        $db = Db::getConnection();
        $sql = 'SELECT  `name_user`, `id_user`, `text_comments`, `date_comments` FROM comments '
                . 'WHERE id_product = :id_product '
                . 'ORDER BY date_comments ASC';
        $result = $db->prepare($sql);
        $result->bindParam(':id_product', $idProduct, PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        $comments = array();
        while ($row = $result->fetch()) {
            $comments[$i]['name_user'] = $row['name_user'];
            $comments[$i]['id_user'] = $row['id_user'];
            $comments[$i]['text_comments'] = $row['text_comments'];
            $comments[$i]['date_comments'] = $row['date_comments'];
            $i++;
        }
        return  $comments;
    
    }

    public static function dateComments($date){
        $formatDate = "$3.$2.$1";
        $shablonDate = '/'."([0-9]+)-([0-9]+)-([0-9]+) ([0-9]+):([0-9]+):([0-9]+)".'/i';
        return preg_replace($shablonDate, $formatDate, $date);
    }
    public static function getCommentsList (){
        $db = Db::getConnection();
        $result = $db->query('SELECT id_comment, id_product, name_user, id_user, text_comments, date_comments FROM comments ORDER BY date_comments ASC');
        $commentsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $commentsList[$i]['id_comment'] = $row['id_comment'];
            $commentsList[$i]['id_product'] = $row['id_product'];
            $commentsList[$i]['name_user'] = $row['name_user'];
            $commentsList[$i]['id_user'] = $row['id_user'];
            $commentsList[$i]['text_comments'] = $row['text_comments'];
            $commentsList[$i]['date_comments'] = $row['date_comments'];
            $i++;
        }
        return $commentsList;
    }
    public static function deleteCommentById($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM comments WHERE id_comment = :id_comment';
        $result = $db->prepare($sql);
        $result->bindParam(':id_comment', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    public static function updateCommentById($id, $options)
    { 
        $db = Db::getConnection();
        $sql = "UPDATE comments SET name_user = :name_user, id_user = :id_user, text_comments = :text_comments WHERE id_comment = :id_comment";
        $result = $db->prepare($sql);
        $result->bindParam(':name_user', $options['name_user'], PDO::PARAM_STR);
        $result->bindParam(':id_user', $options['id_user'], PDO::PARAM_INT);
        $result->bindParam(':text_comments', $options['text_comments'], PDO::PARAM_STR);
        $result->bindParam(':id_comment', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    public static function getCommentById($id)
    {
        
        $db = Db::getConnection();

       
        $sql = 'SELECT * FROM comments WHERE id_comment = :id_comment';

       
        $result = $db->prepare($sql);
        $result->bindParam(':id_comment', $id, PDO::PARAM_INT);

      
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }
}






?>