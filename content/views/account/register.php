<section class="flex-vertical full-height flex-center">
    <form class="form__box" action="register" method="post">
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
    const menuButton = document.querySelector('.menu__button');
    const menuList = document.querySelector('.menu__list');
    const form = document.querySelector('form');
    const notificator = document.querySelector('.notify');
    const ipCopyBtn = document.querySelector('#ipCopyBtn');

    if (!!ipCopyBtn) {
        ipCopyBtn.addEventListener('click', () => copyText());
    }

    if (!!menuButton) {
        menuButton.addEventListener('click', () => {
            let expanded = menuButton.getAttribute('aria-expanded') === 'true';
            menuButton.setAttribute('aria-expanded', !expanded);
            menuButton.classList.toggle('menu__button--open');
            menuList.classList.toggle('menu__list--open');
        });
    }

    if (!!form) {
        form.addEventListener('submit', () => {
            if (form.id === 'no_ajax') {
                return;
            }
            event.preventDefault();

            let request = new XMLHttpRequest();
            request.open(form.method, form.action, true);

            request.onload = function () {
                if (this.status >= 200 && this.status < 400) {
                    let data = JSON.parse(this.response);
                    if (data.url) {
                        window.location.href = "/" + data.url;
                    } else if (data.reload) {
                        window.location.reload();
                    } else {
                        notify(data.message, data.status);
                    }
                } else {
                    notify('Ошибка при подключении к серверу, повторите попыку позднее', 'error');
                }
            };

            request.onerror = (e) => notify(e.returnValue, 'error');
            request.send(new FormData(form));
        });
    }

    function copyText(text = 'obsidianorder.ru') {
        if (text) {
            navigator.clipboard.writeText(ip)
                .then(() => notify('Текст скопирован!'))
                .catch(() => notify('Что-то пошло не так', 'error'))
        }
    }

    function notify(text, type = 'notice') {
        if (text) {
            notificator.innerHTML = text;
            notificator.setAttribute("data-notification-status", type);
            notificator.classList.add('do-show');
            setTimeout(function () {
                notificator.classList.remove('do-show');
            }, 4000);
        }
    }

    window.notify = notify;

})();
</script>