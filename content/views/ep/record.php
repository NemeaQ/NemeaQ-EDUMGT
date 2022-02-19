<div class="p-1">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Запись на приём к руководителю</h4>
        <p>Для записи на прием к руководителю заполните форму ниже.<br>
            <b>Приём осуществляется каждый Вторник c 16:00 до 18:00</b> (В остальные дни прием не ведется)</p>
        <hr>
        <p class="mb-0">Время выбора на сайте указано предварительно. Для уточнения времени с Вами свяжиться
            менеджер.</p>
    </div>
    <form action="/ep/save" method="POST" onsubmit="return check_form(this)">
        <div class="form-group">
            <label for="name">Ф.И.О.</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Введите Ф.И.О." required>
        </div>
        <div class="form-group">
            <label for="time">Время Приёма</label> <select class="form-control" id="time" name="time" required>
                <option value="0">Выберите Время</option>
                <option value="1">16:00 - 16:30</option>
                <option value="2">16:30 - 17:00</option>
                <option value="3">17:00 - 17:30</option>
                <option value="4">17:30 - 18:00</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                   placeholder="Введите email" required>
        </div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp"
                   placeholder="+7 (___) ___-__-__" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="personal" name="personal" required>
            <label class="form-check-label" for="personal">Даю согласие на обработку своих персональных данных</label>
        </div>
        <button type="submit" class="btn btn-blue">Отправить</button>
    </form>
    <script type="text/javascript">
        function check_form(form) {
            var errors = [];
            if (form.name.value === '')
                errors.push('Введите Ф.И.О.!');
            if (form.time.selectedIndex === 0)
                errors.push('Выберите Время!');
            if (form.phone.value === '' || form.email.value === '')
                errors.push('Введите телефон или email!');
            if (!form.personal.checked)
                errors.push('Необходимо согласие на обработку перс. данных!');
            if (errors.length === 0) return true;
            $('.modal-body').text(errors.join("\n"));
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
