<div class="box">
    <h1><?php echo $vars["name"]; ?></h1>
    <form action="/report/save2/" id="report" method="post">
        <input type="text" name="id" value="<?php echo $vars["id"]; ?>" hidden>
        <?php foreach ($vars["classes"] as $i => $object): ?>
            <h2><?= $i ?></h2>
            <div class="objectTable">
                <div class="objectRow objectHeadRow">
                    <span class="objectColHead">Класс: </span>
                    <p>На "4" и "5": </p>
                    <p>На "2": </p>
                    <p>Процнет: </p>
                </div>
                <?php foreach ($object as $j => $class): ?>
                    <div class="objectRow">
                        <span class="objectColHead"><?= $class[1] ?> <sub><input type="text"
                                                                                 name="<?= $i . "_" . $class[0] . "_0" ?>"
                                                                                 value="<?= $class[2] ?>"> чел</sub></span>
                        <p><input type="number" name="<?= $i . "_" . $class[0] . "_1" ?>" value="<?= $class[3] ?>"></p>
                        <p><input type="number" name="<?= $i . "_" . $class[0] . "_2" ?>" value="<?= $class[4] ?>"></p>
                        <p>0 % / 100%</p>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </form>
</div>

<a class="btn btn-green" href="/report/list">Назад</a>
<button class="btn btn-blue" form="report" type="submit">Сохранить</button>

<style>
    .objectTable {
        display: flex;
    }

    .objectRow {
        display: flex;
        flex-direction: column;
        text-align: center;
    }

    .objectRow:first-child .objectColHead {
        border-top-left-radius: 10px;
    }

    .objectRow:last-child .objectColHead {
        border-top-right-radius: 10px;
    }


    .objectRow p {
        margin: 0px;
        height: 26px;
    }

    .objectRow input {
        width: 100px;
    }

    .objectRow input:read-only {
        width: 15px;
    }

    .objectHeadRow {
        text-align: right;
        width: 108px;
    }

    .objectHeadRow p {
        padding-right: 8px;
    }

    .objectColHead {
        background-color: #797CD5;
        color: #fff;
        padding: 4px 6px;
    }

    .objectColHead input {
        width: 16px;
    }

</style>

<script>
    $("input").change(function () {
        let parent = this.closest('.objectRow');

        let el1 = parent.childNodes[1].lastChild.firstChild.value;
        let el2 = parent.childNodes[3].firstChild.value;
        let el3 = parent.childNodes[5].firstChild.value;

        let quality = Math.round(el2 / el1 * 100);
        let progress = Math.round((el1 - el3) / el1 * 100);

        parent.childNodes[7].innerHTML = quality + " % / " + progress + "%";
    });
</script>
