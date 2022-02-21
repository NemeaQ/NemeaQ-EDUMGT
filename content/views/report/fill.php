<div class="box">
    <h1><?php echo $vars["name"]; ?></h1>
    <form action="/report/save/" id="report" method="post">
        <input type="text" name="id" value="<?php echo $vars["id"]; ?>" hidden>
        <table class="pure-table pure-table-bordered pure-table-striped">
            <thead>
            <tr>
                <?php foreach ($vars["tasks"] as $i => $cTsk): ?>
                    <td>
                        <?php if ($cTsk["text"] == "{%class%}"): ?>Класс:<?php elseif ($cTsk["text"] == "{%object%}"): ?>Предмет:<?php else:
                            echo $cTsk["text"];
                        endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < count($vars["tasks"][0]["value"]); $i++): ?>
                <tr>
                    <?php foreach ($vars["tasks"] as $j => $kTsk): ?>
                        <td>
                            <?php if (isset($kTsk["variants"])): ?>
                                <label>
                                    <select name="i<?= $j ?>[]">
                                        <?PHP foreach ($kTsk["variants"] as $item): ?><?php if (isset($kTsk["value"][$i])): ?>
                                            <option <?= $item["name"] == $kTsk["value"][$i] ? " selected" : "" ?>><?= $item["name"] ?></option>
                                        <?php else: ?>
                                            <option><?= $item["name"] ?></option>
                                        <?php endif; ?><?PHP endforeach; ?>
                                    </select>
                                </label>
                            <?php else: ?>
                                <input type="text" name="i<?= $j ?>[]" style="width:60px"
                                    value="<?= isset($kTsk["value"][$i]) ? $kTsk["value"][$i] : '' ?>">
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                    <td><a onclick="rmLine(this)" class="btn btn-blue mg2">- строка</a></td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </form>
    <a class="btn btn-green mg2" onclick="addLine()">+ строка</a>
</div>

<a class="btn btn-green" href="/report/list">Назад</a>
<button class="btn btn-blue" form="report" type="submit">Сохранить</button>

