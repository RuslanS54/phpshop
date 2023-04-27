<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li class="active">Управление комментариями</li>
                </ol>
            </div>

            
            <h4>Список комментариев</h4>

            <br/>

            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID комментария</th>
                    <th>ID продукта</th>
                    <th>Имя пользователя</th>
                    <th>ID пользователя</th>
                    <th>Текст комментария</th>
                    <th>Дата</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($commentsList as $comment): ?>
                    <tr>
                        <td><?php echo $comment['id_comment']; ?></td>
                        <td><?php echo $comment['id_product']; ?></td>
                        <td><?php echo $comment['name_user']; ?></td>
                        <td><?php echo $comment['id_user']; ?></td>  
                        <td><?php echo $comment['text_comments']; ?></td>
                        <td><?php echo $comment['date_comments']; ?></td>  
                        <td><a href="/admin/comment/update/<?php echo $comment['id_comment']; ?>" title="Редактировать"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td><a href="/admin/comment/delete/<?php echo $comment['id_comment']; ?>" title="Удалить"><i class="fa fa-times"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

