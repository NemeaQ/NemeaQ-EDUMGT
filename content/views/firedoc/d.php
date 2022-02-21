<div class="box">
    <table class="table table-hover">
        <thead class="thead-dark">
        <th>Имя</th>
        <th>Загружен</th>
        <th>От</th>
        <th>До</th>
        </thead>
        <template v-for="row in rows">
            <tr @click="toggle(row.id)" :class="{ opened: opened == row.id }">
                <td>{{ row.name }}</td>
                <td>---</td>
                <td>---</td>
                <td>---</td>
            </tr>
            <tr v-if="row.opened">
                <td colspan="4">
                    <table class="table table-hover">
                        <template v-for="row in row.subRows['dir']">
                            <tr @click="toggle(row.id)" :class="{ opened: opened == row.id }">
                                <td>{{ row.name }}</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                            </tr>
                        </template>
                        <template v-for="row in row.subRows['file']">
                            <tr @click="toggle(row.id)" :class="{ opened: opened == row.id }">
                                <td>{{ row.name }}</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                            </tr>
                        </template>
                    </table>
                </td>
            </tr>
        </template>
        <?php foreach ($list['file'] as $val): ?>
            <tr>
                <td>
                    <a href="/fd/dw/<?= $val['id'] ?>"><?= $val['pub_name'] ?></a><br><small><?= formatBytes($val['size']) . " &bull; " . strtoupper($val['ext']) ?></small>
                </td>
                <th><small><?= date("d.m.Y", strtotime($val['upDateTime'])) ?></small></th>
                <th>
                    <small><?= $val['startDate'] == '0000-00-00' ? "<i class=\"fas fa-infinity\"></i>" : date("d.m.Y", strtotime($val['startDate'])) ?></small>
                </th>
                <th>
                    <small><?= $val['endDate'] == '0000-00-00' ? "<i class=\"fas fa-infinity\"></i>" : date("d.m.Y", strtotime($val['endDate'])); ?></small>
                </th>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
    var app = new Vue({
        el: '.box',
        data: {
            opened: -1,
            rows: {
                <?php foreach ($list['dir'] as $index=>$value): ?><?= $value['id'] ?>: {
                    id: <?= $value['id'] ?>,
                    name: '<?= $value['name']?>',
                    opened: false
                },<?php endforeach; ?>},
            subRows: [],
        },
        methods: {
            toggle(id) {
                if (this.rows[id].opened == true) {
                    this.rows[id].opened = false;
                } else {
                    let xhr = new XMLHttpRequest();
                    xhr.open('GET', '/fd/sub/' + id);
                    xhr.send();

                    xhr.onload = function() {
                        if (xhr.status == 200) app.$data.rows[id].subRows = JSON.parse(xhr.response);
                    };

                    this.rows[id].opened = true;
                }


            }
        }
    });
</script>

<?php function formatBytes($bytes, $precision = 1)
{
    $factor = floor((strlen($bytes) - 1) / 3);
    if ($factor > 0) $sz = 'KMGT';
    return sprintf("%.{$precision}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
}
