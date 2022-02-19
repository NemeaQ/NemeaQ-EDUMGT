<div class="box" style="width: max-content!important">
    <h1><?php echo $vars["name"]; ?></h1>
    <form action="/report/send/" id="report" method="post">
        <input type="text" name="id" value="<?php echo $vars["id"]; ?>" hidden>

        <table class="pure-table pure-table-bordered pure-table-striped">
            <thead>
            <tr>
                <?php foreach ($vars["tasks"] as $i => $cTsk): ?>
                    <td><?php
                        if ($cTsk["text"] == "{%class%}") {
                            echo "Класс";
                        } elseif ($cTsk["text"] == "{%object%}") {
                            echo "Предмет";
                        } else echo $cTsk["text"];
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
            </thead>

            <tbody>
            <?php for ($i = 0; $i < count($vars["tasks"][0]["value"]); $i++): ?>
                <tr>
                    <?php foreach ($vars["tasks"] as $j => $kTsk): ?>
                        <td style="width:60px"><?php echo $kTsk['value'][$i] ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </form>
</div>

<a class="btn btn-green" href="/report/list">Назад</a>
<?php if ($vars['status'] != 'Принят'): ?>
    <a class="btn btn-blue" href="/report/fill/<?php echo $vars['id']; ?>">Редактировать</a>
    <button class="btn btn-blue" form="report" type="submit">Отправить на проверку (после отправки данные нельзя будет
        изменить)
    </button>
<?php endif; ?>
