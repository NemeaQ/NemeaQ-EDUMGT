<div class="dashboard">
    <table class="server-stat">
        <thead>
        <tr>
            <th id="server">Сервер</th>

            <th id="online">Online</th>
            <th id="ping">Ping</th>
            <th id="tps">TPS</th>
        </tr>
        </thead>
        <tbody id="stat-table">
        <?php foreach ($servers as $server): ?>
            <tr id="server-<?= $server['id'] ?>">
                <td title="<?= $server['host'] . ":" . $server['port'] ?>">
                    <div class="status-offline"></div>
                    <b><?= $server['name'] ?></b></td>
                <td>---</td>
                <td>---</td>
                <td>---</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <!--    <table class="server-stat">-->
    <!---->
    <!--    </table>-->
    <!--    <table class="server-stat">-->
    <!---->
    <!--    </table>-->
</div>
<script>
    (function() {
        httpRequest = new XMLHttpRequest();

        httpRequest.onload = function() {
            let data = JSON.parse(this.response);
            for (const [key, value] of Object.entries(data)) {
                let str = document.getElementById('server-' + key);
                if (str != null) {
                    if (value[1]) {
                        str.childNodes[1].childNodes[1].className = 'status-online';
                        str.childNodes[3].textContent = value[1] + '/' + value[2];
                        str.childNodes[5].textContent = value[3];
                        str.childNodes[7].textContent = value[4];
                    } else {
                        str.childNodes[1].childNodes[1].className = 'status-offline';
                        str.childNodes[3].textContent = '---';
                        str.childNodes[5].textContent = '---';
                        str.childNodes[7].textContent = '---';
                    }

                }
            }
        };

        httpRequest.open('GET', 'api/status', true);
        httpRequest.send();
        setTimeout(arguments.callee, 60000);
    })();
</script>
