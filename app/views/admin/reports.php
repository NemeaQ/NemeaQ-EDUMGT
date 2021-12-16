<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">Проверка отчётов</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>ФИО</th>
                                <?php foreach ($reportsList as $val): ?>
                                    <th style="writing-mode: vertical-rl; text-orientation: mixed;"><?= $val[1] ?></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($reportsTest as $val): ?>
                                <tr>
                                    <td><?= $val['id'] ?></td>
                                    <td><?= $val['name'] ?></td>
                                    <?php foreach ($reportsList as $value): ?><?php if (isset($val['drafts'][$value[0]])): ?>
                                        <td bgcolor="<?php
                                        $tmp0 = $val['drafts'][$value[0]];
                                        //print_r($tmp0);
                                        if (!$tmp0[0] && !$tmp0[1])
                                            echo 'Khaki';
                                        elseif ($tmp0[0])
                                            echo 'LightSkyBlue';
                                        elseif ($tmp0[1])
                                            echo 'MediumSeaGreen';
                                        ?>">+
                                        </td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?><?php endforeach; ?>

                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">Проверка отчётов</div>
            <div class="card-body">

                <div class="box" style="width: max-content!important">
                    <h1>Свод отчётов, 3 четверть</h1>
                    <?php
                    $exp = [];
                    foreach ($myArch as $index0 => $val) {
                        if ($val['fId'] != 3) continue;
                        $colmns = explode('$$', $val['keys']);
                        foreach ($colmns as $index => $val2) {
                            $rows = explode('&&', $val2);
                            foreach ($rows as $index2 => $val3) {
                                $tmp1[$index2][7] = $val['fId'];
                                $tmp1[$index2][8] = $val['uId'];
                                $tmp1[$index2][$index] = $val3;
                            }
                        }
                        ksort($tmp1, SORT_ASC);
                        $exp = array_merge($exp, $tmp1);
                        $tmp1 = array();
                    }

                    print_r(json_encode($exp));

                    foreach ($exp as $index => $val) {
                        $exp[$index][] = $val[3] / $val[2];
                        $exp[$index][] = ($val[2] - $val[4]) / $val[2];
                    }

                    print_r(json_encode($exp));

                    $need = [];
                    foreach ($exp as $index => $val) {
                        $need[$val[0]][$val[8]][] = $val;
                    }
                    $exp = $need;
                    ?>

                    <table class="pure-table pure-table-horizontal">
                        <thead>
                        <th>Предмет</th>
                        <th>Преподаватель</th>
                        <th>% качества</th>
                        <th>% успеваемости</th>
                        </thead>
                        <?php foreach ($exp as $index => $val): ?><?php foreach ($val as $index2 => $val2): ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $users[$index2]; ?></td>
                                <td><?php
                                    $middle = 0;
                                    foreach ($val2 as $val3) $middle += $val3[9];
                                    $middle /= count($val2);
                                    $data[$index][$users[$index2]][0] = round($middle * 100, 2);
                                    echo $data[$index][$users[$index2]][0]; ?>
                                </td>

                                <td><?php
                                    $middle = 0;
                                    foreach ($val2 as $val3) $middle += $val3[10];
                                    $middle /= count($val2);
                                    $data[$index][$users[$index2]][1] = round($middle * 100, 2);
                                    echo round($middle * 100, 2); ?>
                                </td>

                                <?php if ($val2 == array_values($val)[0]): ?>
                                    <td rowspan="<?= count($val) ?>">
                                        <canvas id="ch-<?= $index; ?>" width="640px" height="360px"></canvas>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?><?php endforeach; ?>

                    </table>

                </div>

                <script>
                    <?php
                    foreach ($data as $index => $value):
                    ?>
                    var ctx = document.getElementById('ch-<?=$index?>').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {labels: ['% качества', '% успеваемости']},
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        suggestedMin: 0,
                                        suggestedMax: 100
                                    }
                                }]
                            }
                        }
                    });
                    <?php foreach ($value as $index2 => $value2): ?>
                    chart.data.datasets.push({
                        label: '<?=$index2?>',
                        backgroundColor: '<?=sprintf('#%06X', mt_rand(0, 0xFFFFFF))?>',
                        borderWidth: 1,
                        data: <?=json_encode($value2)?>
                    });
                    <?php
                    endforeach;
                    ?>
                    chart.update();
                    <?php
                    endforeach;
                    ?>
                </script>



                <div class="box" style="width: max-content!important">
                    <h1>Свод отчётов, 4 четверть</h1>
                    <?php
                    $exp = [];
                    foreach ($myArch as $index0 => $val) {
                        if ($val['fId'] != 3) continue;
                        $colmns = explode('$$', $val['keys']);
                        foreach ($colmns as $index => $val2) {
                            $rows = explode('&&', $val2);
                            foreach ($rows as $index2 => $val3) {
                                $tmp1[$index2][7] = $val['fId'];
                                $tmp1[$index2][8] = $val['uId'];
                                $tmp1[$index2][$index] = $val3;
                            }
                        }
                        ksort($tmp1, SORT_ASC);
                        $exp = array_merge($exp, $tmp1);
                        $tmp1 = array();
                    }

                    print_r(json_encode($exp));

                    foreach ($exp as $index => $val) {
                        $exp[$index][] = $val[3] / $val[2];
                        $exp[$index][] = ($val[2] - $val[4]) / $val[2];
                    }

                    print_r(json_encode($exp));

                    $need = [];
                    foreach ($exp as $index => $val) {
                        $need[$val[0]][$val[8]][] = $val;
                    }
                    $exp = $need;
                    ?>

                    <table class="pure-table pure-table-horizontal">
                        <thead>
                        <th>Предмет</th>
                        <th>Преподаватель</th>
                        <th>% качества</th>
                        <th>% успеваемости</th>
                        </thead>
                        <?php foreach ($exp as $index => $val): ?><?php foreach ($val as $index2 => $val2): ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $users[$index2]; ?></td>
                                <td><?php
                                    $middle = 0;
                                    foreach ($val2 as $val3) $middle += $val3[9];
                                    $middle /= count($val2);
                                    $data[$index][$users[$index2]][0] = round($middle * 100, 2);
                                    echo $data[$index][$users[$index2]][0]; ?>
                                </td>

                                <td><?php
                                    $middle = 0;
                                    foreach ($val2 as $val3) $middle += $val3[10];
                                    $middle /= count($val2);
                                    $data[$index][$users[$index2]][1] = round($middle * 100, 2);
                                    echo round($middle * 100, 2); ?>
                                </td>

                                <?php if ($val2 == array_values($val)[0]): ?>
                                    <td rowspan="<?= count($val) ?>">
                                        <canvas id="ch-<?= $index; ?>" width="640px" height="360px"></canvas>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?><?php endforeach; ?>

                    </table>

                </div>

                <script>
                    <?php
                    foreach ($data as $index => $value):
                    ?>
                    var ctx = document.getElementById('ch-<?=$index?>').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {labels: ['% качества', '% успеваемости']},
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        suggestedMin: 0,
                                        suggestedMax: 100
                                    }
                                }]
                            }
                        }
                    });
                    <?php foreach ($value as $index2 => $value2): ?>
                    chart.data.datasets.push({
                        label: '<?=$index2?>',
                        backgroundColor: '<?=sprintf('#%06X', mt_rand(0, 0xFFFFFF))?>',
                        borderWidth: 1,
                        data: <?=json_encode($value2)?>
                    });
                    <?php
                    endforeach;
                    ?>
                    chart.update();
                    <?php
                    endforeach;
                    ?>
                </script>

                <div class="box" style="width: max-content!important">
                    <h1>Свод отчётов, годовой</h1>
                    <?php
                    $exp = [];
                    foreach ($myArch as $index0 => $val) {
                        if ($val['fId'] != 5) continue;
                        $colmns = explode('$$', $val['keys']);
                        foreach ($colmns as $index => $val2) {
                            $rows = explode('&&', $val2);
                            foreach ($rows as $index2 => $val3) {
                                $tmp1[$index2][7] = $val['fId'];
                                $tmp1[$index2][8] = $val['uId'];
                                $tmp1[$index2][$index] = $val3;
                            }
                        }
                        ksort($tmp1, SORT_ASC);
                        $exp = array_merge($exp, $tmp1);
                        $tmp1 = array();
                    }


                    foreach ($exp as $index => $val) {
                        $exp[$index][] = $val[2];
                        $exp[$index][] = $val[3];
                    }

                    //debug($exp);

                    $need = [];
                    foreach ($exp as $index => $val) {
                        $need[$val[0]][$val[8]][] = $val;
                    }
                    $exp = $need;
                    //  echo '<pre>';
                    //  echo var_dump($exp).'<br>';
                    //  echo '</pre>';
                    ?>

                    <table class="pure-table pure-table-horizontal">
                        <thead>
                        <th>Предмет</th>
                        <th>Преподаватель</th>
                        <th>% качества</th>
                        <th>% успеваемости</th>
                        </thead>
                        <?php foreach ($exp as $index => $val): ?>

                            <?php foreach ($val as $index2 => $val2): ?>
                                <tr>
                                    <td><?= $index; ?></td>
                                    <td><?= $users[$index2]; ?></td>
                                    <td><?php
                                        $middle = 0;
                                        foreach ($val2 as $val3) {
                                            $middle += $val3[9];
                                        }
                                        $middle /= count($val2);
                                        echo round($middle, 2);
                                        ?>
                                    </td>

                                    <td><?php
                                        $middle = 0;
                                        foreach ($val2 as $val3) {
                                            $middle += $val3[10];
                                        }
                                        $middle /= count($val2);
                                        echo round($middle, 2);
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endforeach; ?>

                    </table>

                </div>


            </div>
        </div>
    </div>
</div>