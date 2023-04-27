<?php


class AdminCommentController extends AdminBase
{

    public function actionIndex()
    { 
        self::checkAdmin();
        $commentsList = Comment::getCommentsList();
        require_once(ROOT . '/views/admin_comment/index.php');
        return true;
    }




    public function actionUpdate($id)
    {
        self::checkAdmin();
        $comment = Comment::getCommentById($id);
        if (isset($_POST['submit'])) {

            $options['id_user'] = $_POST['id_user'];
            $options['text_comments'] = $_POST['text_comments'];
            if (Comment::updateCommentById($id, $options)) {
                header("Location: /admin/comment");
            }
        }
        require_once(ROOT . '/views/admin_comment/update.php');
        return true;
    }


    public function actionDelete($id)
    {
        self::checkAdmin();

        if (isset($_POST['submit'])) {
            Comment::deleteCommentById($id);
            header("Location: /admin/comment");
        }
        require_once(ROOT . '/views/admin_comment/delete.php');
        return true;
    }
}
