<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">Список групп</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php if (empty($listUsers)): ?>
                            <p>Список групп пуст</p>
                        <?php else: ?>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Название</th>
                                    <th>Участников</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($listUsers as $val): ?>
                                    <tr>
                                        <td><?= $val['id'] ?></td>
                                        <td><?= $val['name'] ?></td>
                                        <td><?= $val['members'] ?></td>
                                        <td>
                                            <form action="/admin/groups" method="post">
                                                <input type="hidden" name="type" value="user">
                                                <input type="hidden" name="id" value="<?php echo $val['id']; ?>">
                                                <button type="submit" class="btn btn-primary">Добавить участников
                                                </button>
                                                <button type="submit" class="btn btn-danger">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
