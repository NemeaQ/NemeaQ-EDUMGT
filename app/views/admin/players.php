<h2>Список пользователей</h2>

<?php if (empty($listPLayers)): ?>
    <p>Список пользователей системы пуст</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>UUID</th>
            <th>Никнейм</th>
            <th>Люф</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listPLayers as $val): ?>
            <tr>
                <td><?= $val['uuid'] ?></td>
                <td><?= $val['name'] ?></td>
                <td><?= $val['units'] ?></td>
                <td>
                    <form action="/admin/players" method="post">
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