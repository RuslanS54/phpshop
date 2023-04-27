<?php


class ProductController
{

    
    public function actionView($productId)
    {
        $categories = Category::getCategoriesList();
        $product = Product::getProductById($productId);
        $comments = Comment::getCommentsProduct($productId);
        if (!User::isGuest()) {   
            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $userName = $user['name'];
        } else {   
            $userId = NULL;
            $userName = "";
        }
        if (isset($_POST['submit'])) {
            $option["name_user"] = $_POST["name"];
            $option["id_product"] = $productId;
            $option["id_user"] = $userId;
            $option["text_comments"] = $_POST["text_comments"];
            $errors = false;
            if (User::isGuest()){
                if (md5($_POST['norobot']) != $_SESSION['randomnr2']) {
                    $errors[] = 'Неправильная капча';
                }
        }
            if ($errors == false) {
                Comment::addComments( $option);
                header("Location: http://kad/product/$productId");
        }
        }
        $s = Product::getImage5($productId);
      
        require_once(ROOT . '/views/product/view.php');
        return true;
    }

}
