<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/user">Управление пользователями</a></li>
                    <li class="active">Редактировать пользователя</li>
                </ol>
            </div>


            <h4>Редактировать пользователя #<?php echo $id; ?></h4>

            <br/>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">
                    


                        <p>Имя</p>
                        <input type="text" name="name" placeholder="" value="<?php echo $product['name']; ?>">

                        <p>Email</p>
                        <input type="text" name="email" placeholder="" value="<?php echo $product['email']; ?>">
                        <p>Пароль</p>
                        <input type="text" name="password" placeholder="" value="<?php echo $product['password']; ?>">
                        <p>Роль</p>
                        <input type="text" name="role" placeholder="" value="<?php echo $product['role']; ?>">


                        
                        <p>Аватар</p>
                        <img src="<?php echo User::getImage($id); ?>" width="200" alt="" />
                        <input type="file" name="image" placeholder="" value="<?php echo $product['image']; ?>">

                    
                        
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                        
                        <br/><br/>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

