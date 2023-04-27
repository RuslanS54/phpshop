<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <h3>Кабинет пользователя</h3>
            
            <h4>Привет, <?php echo $user['name'];?>!</h4>
            <img src=<?php echo User::getImage($user['id']);?> alt="" width = 200px>
            <ul>
                <li><a href="/cabinet/edit">Редактировать данные</a></li>
                <!--<li><a href="/cabinet/history">Список покупок</a></li>-->
            </ul>
            <?php foreach ( $orderId as $i): ?>
                <h5>Информация о заказе</h5>
            <table class="table-admin-small table-bordered table-striped table">
                <tr>
                    <td>Номер заказа</td>
                    <td><?php echo $order[$i]['id']; ?></td>
                </tr>
                <tr>
                    <td>Имя клиента</td>
                    <td><?php echo $order[$i]['user_name']; ?></td>
                </tr>
                <tr>
                    <td>Телефон клиента</td>
                    <td><?php echo $order[$i]['user_phone']; ?></td>
                </tr>
                <tr>
                    <td>Комментарий клиента</td>
                    <td><?php echo $order[$i]['user_comment']; ?></td>
                </tr>
            
                <tr>
                    <td><b>Статус заказа</b></td>
                    <td><?php echo Order::getStatusText($order[$i]['status']); ?></td>
                </tr>
                <tr>
                    <td><b>Дата заказа</b></td>
                    <td><?php echo $order[$i]['date']; ?></td>
                </tr>
            </table>

            <h5>Товары в заказе</h5>

            <table class="table-admin-medium table-bordered table-striped table ">
                <tr>
                    <th>ID товара</th>
                    <th>Артикул товара</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                </tr>
                <?php foreach ($products[$i] as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['code']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?> Руб.</td>
                        <td><?php echo $productsQuantity[$i][$product['id']]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>