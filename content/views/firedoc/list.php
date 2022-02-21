<div class="box" style="border-radius: 43px">
    <a class="btn btn-green" href="/fd/list/<?= $parent ?>" title="К родительскому каталогу"><i
            class="fas fa-arrow-up"></i></a>
    <input id="file" type="file" style="display: none"/>
    <button class="btn btn-green" id="upload" title="Загрузить файл"><i class="fas fa-plus-square"></i></button>
    <button class="btn btn-green" id="addDir" title="Новый католог"><i class="fas fa-folder-plus"></i></button>
    <script>
        $('#addDir').on('click', function() {
            var txt = prompt('Введите имя каталога:', 'Новая папка');
            let form_data = new FormData();
            form_data.append('txt', txt);
            form_data.append('dir', <?= isset($this->route['id']) ? $this->route['id'] : '0' ?>);
            $.ajax({
                url: '/fd/createDir',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(result) {
                    $('.notify')
                        .removeClass()
                        .text(result.message)
                        .attr('data-notification-status', result.status)
                        .addClass('top-right notify')
                        .addClass('do-show');
                    location.reload();
                    setTimeout(function() {
                        $('.notify').removeClass('do-show');
                    }, 4000);
                }
            });

        });

        $('#upload').on('click', function() {
            $('#file').trigger('click');
        });

        $('#file').change(function(e) {
            let form_data = new FormData();
            form_data.append('file', e.target.files[0]);
            form_data.append('name', 'test');
            form_data.append('dir', <?= isset($this->route['id']) ? $this->route['id'] : '0' ?>);
            $.ajax({
                url: '/fd/up',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(result) {
                    $('.notify')
                        .removeClass()
                        .text(result.message)
                        .attr('data-notification-status', result.status)
                        .addClass('top-right notify')
                        .addClass('do-show');
                    location.reload();
                    setTimeout(function() {
                        $('.notify').removeClass('do-show');
                    }, 4000);
                }
            });
        });

    </script>
</div>
<table class="pure-table pure-table-horizontal">
    <thead class="thead-dark">
    <th style="width: 32px;"><input type="checkbox"></th>
    <th style="width: 32px;"></th>
    <th>Имя</th>
    <th style="width: 32px;"></th>
    <th style="width: 32px;"></th>
    <th style="width: 64px;">Размер</th>
    <th style="width: 32px;">Изменеён</th>
    </thead>
    <?php foreach ($list['dir'] as $val): ?>
        <tr>
            <td><input type="checkbox"></td>
            <td class="tb-icon"><i class="fas fa-folder icon-blue"></i></td>
            <td><a href="/fd/list/<?= $val['id'] ?>"><?= $val['name'] ?></a></td>
            <!--            <td>--><? //= $val['creationDate'] ?><!--</td>-->
            <td>
                <div class="fd-author"
                    style="background-image: url('<?php echo 'https://sch24perm.ru/fd/show/' . $val['photo']; ?>');"
                    data-content="<?php echo $val['author'] ?>" data-placement="top" data-trigger="hover"></div>
            </td>
            <td class="cm"><i class="fas fa-ellipsis-h"></i></td>
            <td>---</td>
            <td>---</td>
            <!--            --><? //= $val['id'] ?>
            <!--            <a id="del" action="/fd/del/-->
            <? //= $val['id'] ?><!--" class="btn btn-ob" href="javascript:void(0);">Удалить</a>-->
        </tr>
    <?php endforeach; ?>
    <?php foreach ($list['file'] as $val): ?>
        <tr>
            <td><input type="checkbox"></td>
            <td class="tb-icon">

                <?php switch ($val['ext']):
                    case 'jpg':
                    case 'png': ?>
                        <img style="width: 64px" src="/fd/dw/<?= $val['id'] ?>">
                        <?php break;

                    case 'pdf': ?>
                        <i class="fas fa-file-pdf icon-red"></i>
                        <?php break;

                    case 'doc':
                    case 'docx': ?>
                        <i class="fas fa-file-word icon-blue"></i>
                        <?php break;

                    case 'xls':
                    case 'xlsx': ?>
                        <i class="fas fa-file-excel icon-green"></i>
                        <?php break;

                    default: ?>
                        <i class="fas fa-file"></i>
                    <?php endswitch ?>

            </td>
            <? //= $val['id'] ?>
            <td><?= $val['name'] ?>.<?= $val['ext'] ?><br>
                <small><a href="/fd/dw/<?= $val['id'] ?>"><?= $val['pub_name'] ?></a></small>
            </td>
            <td>
                <div class="fd-author"
                    style="background-image: url('<?php echo 'https://sch24perm.ru/fd/show/' . $val['photo']; ?>');"
                    data-content="<?php echo $val['author'] ?>" data-placement="top" data-trigger="hover"></div>
            </td>
            <td class="cm" data="<?= $val['id'] ?>"><i class="fas fa-ellipsis-h"></i></td>
            <td><?= $val['size'] ?> bytes</td>
            <td><?= $val['upDateTime'] ?></td>
            <!--        <td>--><? //= date("d.m.Y", strtotime($val['startDate'])) ?><!--</td>-->
            <!--        <td>--><? //= date("d.m.Y", strtotime($val['endDate'])); ?><!--</td>-->
        </tr>
    <?php endforeach; ?>

    <!--    --><?php //foreach ($list['0'] as $val): ?>
    <!--        <tr>-->
    <!--            <td><input type="checkbox"></td>-->
    <!--            <td class="tb-icon"><i class="fas fa-folder icon-blue"></i></td>-->
    <!--            <td><a href="/fd/list/--><? //= $val[2] ?><!--">--><? //= $val[2] ?><!--</a></td>-->
    <!--            <td>--><? //= $val['creationDate'] ?><!--</td>-->
    <!--            <td>-->
    <!--                <div class="fd-author" style="background-image: url('--><?php //echo 'https://sch24perm.ru/fd/show/' . $val['photo']; ?>
    <!--                    /*/*');" data-content="*/*/-->
    <!--                --><?php //echo $val['author'] ?><!--" data-placement="top" data-trigger="hover"></div>-->
    <!--            </td>-->
    <!--            <td class="cm"><i class="fas fa-ellipsis-h"></i></td>-->
    <!--            <td>--><? //= $val[1] ?><!-- byte</td>-->
    <!--            <td>---</td>-->
    <!--            --><? //= $val['id'] ?>
    <!--            <a id="del" action="/fd/del/-->
    <? //= $val['id'] ?><!--" class="btn btn-ob" href="javascript:void(0);">Удалить</a>-->
    <!--        </tr>-->
    <!--    --><?php //endforeach; ?>

</table>
<script type="text/javascript">
    $(function() {
        $.contextMenu({
            selector: '.cm',
            trigger: 'left',
            build: function(element, e) {
                return {
                    callback: function(key, options) {
                        switch (key) {
                            case 'show':
                                window.location.href = '/fd/show/' + $(element).attr('data');
                                break;
                            case 'rename':

                                break;
                            case 'download':
                                window.location.href = '/fd/dw/' + $(element).attr('data');
                                break;
                            case 'delete':
                                $.ajax({
                                    url: '/fd/del/' + $(this).attr('data'),
                                    dataType: 'json',
                                    success: function(result) {
                                        $('.notify')
                                            .removeClass()
                                            .text(result.message)
                                            .attr('data-notification-status', result.status)
                                            .addClass('top-right notify')
                                            .addClass('do-show');
                                        $(element).parent().remove();
                                        setTimeout(function() {
                                            $('.notify').removeClass('do-show');
                                        }, 4000);
                                    },
                                });

                                break;
                            default:

                        }
                    },
                };
            },

            callback: function() {
            },
            items: {
                'show': {name: 'Просмотреть', icon: 'fas fa-eye'},
                'rename': {name: 'Переименовать', icon: 'fas fa-edit'},
                'download': {name: 'Скачать', icon: 'fas fa-cloud-download-alt'},
                'sep1': '---------',
                'delete': {name: 'Удалить', icon: 'fas fa-trash-alt icon-red'},
            }
        });

        $('.cm').on('click', function(e) {
            console.log('clicked', this);
        });
    });

</script>
