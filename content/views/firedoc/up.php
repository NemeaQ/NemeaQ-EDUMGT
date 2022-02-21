<input class="btn btn-green" id="b-up" type="file" name="sortpic"/><input name="name" id="f-name" type="text">
<button class="btn btn-blue" id="upload">Загрузить</button>
<script>
    $('#upload').on('click', function() {
        var file_data = $('#b-up').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('name', $('#f-name').value);
        $.ajax({
            url: '/fd/up',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response) {
                alert(php_script_response);
            }
        });
    });
</script>
