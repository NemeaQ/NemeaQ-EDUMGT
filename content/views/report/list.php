<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<?php

$db = new \application\lib\Db();

$objects = $db->row('SELECT DISTINCT object FROM sn_drafts2 WHERE uID=' . $_SESSION['account']['id']);

$rawObjectList = $db->row("SELECT * FROM sn_object");
$objectList = [];
foreach ($rawObjectList as $item) {
    $objectList[$item['id']] = $item['name'];
}

$objects = $db->row('SELECT * FROM sn_forms');

?>

<div class="box">
    <h1>Аналитика <a class="btn btn-blue" href="/report/analyse">Анализ</a></h1>
    <div style="display: inline-flex;">
        <?php foreach ($objects as $index => $value): ?>
            <!--            <div class="chart-container">-->
            <!--                <canvas id="ch---><? //= $value['object'] ?><!--"></canvas>-->
            <!--            </div>-->
            <script>
                var ctx = document.getElementById('ch-<?= $value['object']?>').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {labels: ['1 четверть', '2 четверть', '3 четверть']},
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    suggestedMin: 0,
                                    suggestedMax: 100
                                }
                            }]
                        },
                        layout: {
                            padding: {
                                left: 16,
                                right: 16,
                                top: 8,
                                bottom: 8
                            }
                        },
                        title: {
                            display: true,
                            text: '<?= $objectList[$value['object']] ?>'
                        }
                    }
                });

                chart.data.datasets.push({
                    label: '% качества',
                    backgroundColor: "rgba(255,99,132,0.2)",
                    borderColor: "rgba(255,99,132,1)",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(255,99,132,0.4)",
                    hoverBorderColor: "rgba(255,99,132,1)",
                    data: [10, 10, 10]
                });

                chart.data.datasets.push({
                    label: '% успеваемости',
                    backgroundColor: "rgba(132,154,255,0.2)",
                    borderColor: "rgb(136,187,255)",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(131,205,255,0.4)",
                    hoverBorderColor: "rgb(120,209,255)",
                    data: [10, 10, 10]
                });

                chart.update();
            </script>

        <?php endforeach; ?>
    </div>
    <!--    <h1>Отчёты</h1>-->
    <!--    <table class="pure-table pure-table-horizontal">-->
    <!--        <thead>-->
    <!--        <th class="th-icon"><i class="fas fa-question-circle" title="Статус отчёта"></i></th>-->
    <!--        <th>Отчёт</th>-->
    <!--        <th>Период</th>-->
    <!--        <th>Закрывается</th>-->
    <!--        <th>Действия</th>-->
    <!--        </thead>-->
    <!--        <tr>-->
    <!--            <td><i class="fas fa-exclamation-circle icon-red"></i></td>-->
    <!--            <td>Качетво предмет</td>-->
    <!--            <th>3 четверть</th>-->
    <!--            <th>30 марта 2020 г.</th>-->
    <!--            <td>-->
    <!--                <a class="btn btn-blue" href="/report/fill2/3">Редактировать</a>-->
    <!--            </td>-->
    <!--        </tr>-->
    <!--        <tr>-->
    <!--            <td><i class="fas fa-check-circle icon-green"></i></td>-->
    <!--            <td>Качетво предмет</td>-->
    <!--            <th>2 четверть</th>-->
    <!--            <th>30 декабря 2020 г.</th>-->
    <!--            <td>-->
    <!--                <a class="btn btn-blue" href="/report/fill2/2">Редактировать</a>-->
    <!--            </td>-->
    <!--        </tr>-->
    <!--        <tr>-->
    <!--            <td><i class="fas fa-check-circle icon-green"></i></td>-->
    <!--            <td>Качетво предмет</td>-->
    <!--            <th>1 четверть</th>-->
    <!--            <th>30 октября 2020 г.</th>-->
    <!--            <td>-->
    <!--                <a class="btn btn-blue" href="/report/fill2/1">Редактировать</a>-->
    <!--            </td>-->
    <!--        </tr>-->
    <!--    </table>-->

    <h1>Формы</h1>
    <table class="pure-table pure-table-horizontal">
        <thead>
        <th class="th-icon"><i class="fas fa-question-circle" title="Статус отчёта"></i></th>
        <th>Форма</th>
        <th>Действия</th>
        </thead>
        <tr>
            <td><i class="fas fa-exclamation-circle icon-red"></i></td>
            <td>Корректировка учебной программы</td>
            <td>
                <a class="btn btn-blue" href="/report/fill3/3">Редактировать</a>
            </td>
        </tr>
        <tr>
            <td><i class="fas fa-exclamation-circle icon-red"></i></td>
            <td>Учет посещения занятий в дистанционной форме</td>
            <td>
                <a class="btn btn-blue" href="/report/fill4/4">Редактировать</a>
            </td>
        </tr>
    </table>


    <style>
        .child-info {
            height: 300px;
            background-color: #eee;
        }

        .th-icon {
            width: 25.8px;
        }

        .chart-container {
            position: relative;
            margin: 10px;
            height: 224px;
            width: 448px;
            box-shadow: 0px 0px 5px #ccc;
            border-radius: 10px;
        }
    </style>
