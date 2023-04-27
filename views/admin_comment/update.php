<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/comment">Управление комментарий</a></li>
                    <li class="active">Редактировать комментарий</li>
                </ol>
            </div>


            <h4>Редактировать комментарий #<?php echo $id; ?></h4>

            <br/>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">

                        <p>Имя</p>
                        <input type="text" name="name_user" placeholder="" value="<?php echo $comment['name_user']; ?>">

                        <p>ID пользователя</p>
                        <input type="text" name="id_user" placeholder="" value="<?php echo $comment['id_user']; ?>">

                        <p>Комментарий</p>
                        <textarea name="text_comments"><?php echo $comment['text_comments']; ?></textarea>
                        
                        
                        
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                        
                        <br/><br/>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

