<div class="content-wrapper">
    <h2>Список пользователей</h2>
    <?php if (empty($listUsers)): ?>
        <p>Список пользователей системы пуст</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>ФИО</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listUsers as $val): ?>
                <tr>
                    <td><?= $val['id'] ?></td>
                    <td><?= $val['lname'] . ' ' . $val['fname'] ?></td>
                    <td><?= $val['email'] ?></td>
                    <td>
                        <form action="/admin/users" method="post">
                            <input type="hidden" name="type" value="user">
                            <input type="hidden" name="id" value="<?php echo $val['id']; ?>">
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
