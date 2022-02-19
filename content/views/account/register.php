<section class="flex-vertical full-height flex-center">
    <form id="ajax_form" class="form__box" action="register" method="post">
        <h1 class="form__title">Регистрация</h1>
        <input class="form__control" type="email" name="email" placeholder="Элеткронная почта"
               aria-label="Элеткронная почта"
               required><br>
        <input class="form__control" type="text" name="lname" placeholder="Фамилия" aria-label="Фамилия"
               required><br>
        <input class="form__control" type="text" name="fname" placeholder="Имя" aria-label="Имя"
               required><br>
        <input class="form__control" type="text" name="mname" placeholder="Отчество" aria-label="Отчество"><br>
        <input class="form__control" type="password" name="password" placeholder="Пароль" aria-label="Пароль"
               required><br>
        <input class="form__control" type="password" name="password2" placeholder="Повторите пароль"
               aria-label="Повтор пароля" required><br>

        <label class="check">
            <input class="check__input" type="checkbox">
            <span class="check__box"></span>
            Я принимаю условия <a href="/copy" target="_blank">Пользовательского соглашения</a> и даю согласие на
            обработку персональных данных в соответствии с законодательством России
        </label>

        <!--        <div class="g-recaptcha" data-sitekey="6LePM70bAAAAAFW11vG0zzZ6wjkR_jK8dOUizpaG"></div>-->

        <button type="submit" class="btn btn-accent">Зарегистрироваться</button>
    </form>
</section>
<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
<script type="text/javascript">
(() => {


})();
</script>