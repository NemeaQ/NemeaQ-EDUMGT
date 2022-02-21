<div class="p-1">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Задать вопрос директору образовательного учреждения</h4>
        <p>Для отправки вопроса руководителю заполните форму ниже.<br> <b>Ответ прийдёт на Email указанный в форме</b>
        </p>
        <hr>
        <!--        <p class="mb-0">Время выбора на сайте указано предварительно. Для уточнения времени с Вами свяжиться-->
        <!--            менеджер.</p>-->
    </div>
    <form action="/ep/save" method="POST" onsubmit="return check_form(this)">
        <div class="form-group">
            <label for="name">Ф.И.О.</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Введите Ф.И.О." required>
        </div>
        <div class="form-group">
            <label for="text">Вопрос директору ОУ</label>
            <textarea class="form-control" id="text" name="text" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                placeholder="Введите email" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="personal" name="personal" required>
            <label class="form-check-label" for="personal">Даю согласие на обработку своих персональных данных</label>
        </div>
        <input hidden type="text" value="question" name="type">
        <button type="submit" class="btn btn-blue">Отправить</button>
    </form>
    <script type="text/javascript">
        function check_form(form) {
            var errors = [];
            if (form.name.value === '')
                errors.push('Введите Ф.И.О.!');
            if (form.text.value === '')
                errors.push('Напишите ваш вопрос!');
            if (form.email.value === '')
                errors.push('Введите email, на него прийдёт ответ!');
            if (!form.personal.checked)
                errors.push('Необходимо согласие на обработку перс. данных!');
            if (errors.length === 0) return true;
            $('.modal-body').text(errors.join('\n'));
            $('#info').modal('toggle');
            return false;
        }
    </script>
    <div class="modal" tabindex="-1" role="dialog" id="info">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Заполните пожайлуста все поля!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Ок</button>
                </div>
            </div>
        </div>
    </div>
</div>
