<div class="p-1">
    <div class="jumbotron">
        <?php
        switch ($_SERVER["HTTP_REFERER"]) {
            case "https://sch24perm.ru/ep/question":

                echo '<h1 class="display-4">Вопрос сохранен!</h1>
        <p class="lead">Ваш вопрос отправлен директору образовательного учреждения. В скоре ответ приёдет на указанный вами Email адресс</p>
        <hr class="my-4">
        <p>На нашем сайте появляются разнообразные электронные сервисы: <a href="#">подробнее...</a></p>
        <a class="btn btn-blue btn-lg" href="/ep/question" role="button">Вернуться на страницу "задать вопрос"</a>';

                break;
            case "https://sch24perm.ru/ep/record":

                echo '<h1 class="display-4">Запись сохранена!</h1>
        <p class="lead">Время выбора на сайте указано предварительно. Для уточнения времени с Вами свяжиться менеджер.</p>
        <hr class="my-4">
        <p>На нашем сайте появляются разнообразные электронные сервисы: <a href="#">подробнее...</a></p>
        <a class="btn btn-blue btn-lg" href="/ep/record" role="button">Вернуться на страницу записи</a>';

                break;
            default:

        }
        ?>

    </div>
</div>

