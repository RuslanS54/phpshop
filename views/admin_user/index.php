<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li class="active">Управление пользователями</li>
                </ol>
            </div>

            <a href="/admin/user/create" class="btn btn-default back"><i class="fa fa-plus"></i> Добавить пользователя</a>
            
            <h4>Список пользователей</h4>

            <br/>

            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID пользователя</th>
                    <th>Имя</th>
                    <th>Почта</th>
                    <th>Пароль</th>
                    <th>Роль</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($productsList as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['email']; ?></td>
                        <td><?php echo $product['password']; ?></td>  
                        <td><?php echo $product['role']; ?></td>  
                        <td><a href="/admin/user/update/<?php echo $product['id']; ?>" title="Редактировать"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td><a href="/admin/user/delete/<?php echo $product['id']; ?>" title="Удалить"><i class="fa fa-times"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

