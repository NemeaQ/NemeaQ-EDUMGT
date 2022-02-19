<div class="box" style="position: relative;">
    <form action="/cont/list" method="POST" id="no_ajax" style="margin-right: 240px;">
        <h1>Контингент</h1>
        <table class="pure-table pure-table-horizontal" id="table">
            <thead>
            <th class="th-icon"><input type="checkbox"></th>
            <th class="th-icon"><i class="fas fa-question-circle"></i></th>
            <th>ФИО</th>
            <th>Класс</th>
            <th>Дата рождения</th>
            <th>Действия</th>
            </thead>
            <tbody>
            <template v-for="row in rows">
                <tr @click="toggle(row.id)" :class="{ opened: opened == row.id }">
                    <td><input type="checkbox"></td>
                    <td></td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.class }}</td>
                    <td>{{ row.birth }}</td>
                    <td><a class="">SOME ACTIONS</a></td>
                </tr>
                <tr v-if="opened == row.id">
                    <td colspan="6">
                        <div>
                            <label> uID-code: <input type="text"> </label> <label> HEX-code: <input type="text">
                            </label>
                        </div>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </form>

    <script>
        var app = new Vue({
            el: '#table',
            data: {
                opened: -1,
                rows: [<?php foreach ($list as $index=>$value): ?>{
                    id: <?= $index ?>,
                    name: '<?= $value['sname'] . " " . $value['fname'] . " " . $value['mname'] ?>',
                    class: '<?= $value['name'] ?>',
                    birth: '<?= $value['birth'] ?>'
                },<?php endforeach; ?>]
            },
            methods: {
                toggle(id) {
                    if (this.opened == id)
                        this.opened = -1;
                    else

                        this.opened = id;

                }
            }
        })
    </script>

    <div id="changelist-filter">
        <h2 class="h5">Фильтр</h2>
        <section>
            <span class="h4">Статус</span>
            <div class="filter_controls">
                <span><a href="?" title="Все">Все</a></span> <span><a href="?" title="Все">Ошибка</a></span>
                <span><a href="?" title="Все">Хорошо</a></span>
            </div>
        </section>
        <section>
            <span class="h4">Класс</span>
            <div class="filter_controls">
                <span <?= isset($_GET['class']) ? '' : 'class="selected"' ?>><a href="?" title="Все">Все</a></span>
                <?php foreach ($classList as $class): ?>
                    <span <?= isset($_GET['class']) ? ($class['id'] == $_GET['class'] ? 'class="selected"' : '') : '' ?>><a
                                href="?class=<?= $class['id'] ?>"><?= $class['name'] ?></a></span>
                <?php endforeach; ?>
            </div>
        </section>
        <section>
            <span class="h4">Соглашение принято</span>
            <div class="filter_controls">
                <span class="selected"><a href="?" title="Все">Все</a></span>
                <span><a href="?accepted__exact=1" title="Да">Да</a></span>
                <span><a href="?accepted__exact=0" title="Нет">Нет</a></span>
            </div>
        </section>
        <section>
            <span class="h4">Закончил обучение</span>
            <div class="filter_controls">
                <span class="selected"><a href="?" title="Все">Все</a></span>
                <span><a href="?finished__exact=1" title="Да">Да</a></span>
                <span><a href="?finished__exact=0" title="Нет">Нет</a></span>
            </div>
        </section>
    </div>

    <style>
        .child-info {
            height: 300px;
            background-color: #eee;
        }

        .th-icon {
            width: 25.8px;
        }

        .h4 {
            font-size: 100%;
            font-weight: 700;
            margin-bottom: 0;
            color: #000000;
        }

        .h5 {
            margin: 0;
            margin-bottom: 0px;
            padding: 8px;
            font-weight: 400;
            font-size: 13px;
            text-align: left;
            background: #fdca00;
            color: #666;
            border-radius: 5px;
        }

        section {
            padding: 15px 20px;
        }

        .filter_controls {
            line-height: 1.45;
            padding-top: .5em;
        }

        .filter_controls span {
            margin: 0 4% 0 0;
            padding: 0;
            font-size: 13px;
            display: inline-block;
            line-height: 1.2;
            color: #999;
        }

        .selected a {
            border-radius: 3px;
            background: #d2dce1;
            padding: 2px 4px;
        }

        .filter_controls li {
            list-style-type: none;
            margin-left: 0;
            padding-left: 0;
        }

        #changelist-filter {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 1000;
            width: 240px;
            background: #f8f8f8;
            border-left: none;
            margin: 0;
        }

        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }

        .pagination > li {
            display: inline;
        }

        .pagination > li:first-child > a, .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .pagination > li > a, .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
    </style>
</div>
