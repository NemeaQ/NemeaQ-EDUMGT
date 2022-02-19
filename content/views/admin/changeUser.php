<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">Список групп</div>
            <div class="card-body">
                <ul class="object-tools">
                    <li>
                        <a href="/tutor/doadmin/tstudent/173634/history/" class="historylink">TOOLS</a>
                    </li>
                </ul>
                <form enctype="multipart/form-data" action="" method="post" id="tstudent_form" novalidate="">
                    <input type="hidden" name="csrfmiddlewaretoken"
                           value="YXn7d5Uh8Rn0NbC6dGqVNqmkDbMPdmLvpputLlhMIElsYzTrkNBw4cocwgMHEhmT">
                    <div>
                        <fieldset class="module">

                            <div class="form-group row">
                                <label for="id_surname" class="col-sm-3 col-md-2 col-form-label">Фамилия</label>
                                <div class="col-sm-9 col-md-10 col-lg-3">
                                    <input type="text" class="form-control" id="id_surname" placeholder="Password"
                                           maxlength="50" required="" value="Анкудинова">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_name" class="col-sm-3 col-md-2 col-form-label">Имя</label>
                                <div class="col-sm-9 col-md-10 col-lg-3">
                                    <input type="text" name="name" value="София" class="form-control" maxlength="50"
                                           required="" id="id_name">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="id_midname" class="col-sm-3 col-md-2 col-form-label">Отчёство</label>
                                <div class="col-sm-9 col-md-10 col-lg-3">
                                    <input type="text" name="midname" value="Андреевна" class="form-control"
                                           maxlength="50" required="" id="id_midname" placeholder="Отчёство">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_birthdate" class="col-sm-3 col-md-2 col-form-label">Дата рождения</label>
                                <div class="col-9 col-sm-3">
                                    <input type="text" class="form-control" id="id_birthdate"
                                           placeholder="Дата рождения" value="10.04.2008">
                                </div>
                                <button type="submit" class="btn btn-primary">Сегодня</button>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-sm-3 col-md-2">
                                    <label>Пользователь в системе</label>
                                    <div class="readonly"><i>AnkudinovaSA</i></div>
                                </div>
                                <div class="form-group col-sm-9 col-md-10 col-lg-3">
                                    <label class="inline" for="id_email">Адрес электронной почты</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                           maxlength="100" id="id_email">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="id_school" class="col-form-label">Образовательная организация</label>
                                    <select class="form-control" name="school" required="" id="id_school">
                                        <option value="">---------</option>
                                        <option value="238" selected="">СОШ 24</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="id_schoolForm" class="col-form-label">Класс</label>
                                    <select class="form-control" name="schoolForm" required="" id="id_schoolForm"
                                            data-chainfield="school"
                                            data-url="/chaining/filter/doadmin/SchoolForm/school/doadmin/Student/schoolForm"
                                            data-value="2588" data-auto_choose="true" data-empty_label="--------"
                                            class="chained-fk">
                                        <option value="">--------</option>
                                        <option value="6389">1А</option>
                                        <option value="6390">1Б</option>
                                        <option value="6391">1В</option>
                                        <option value="6392">1Г</option>
                                        <option value="6393">1Д</option>
                                        <option value="6394">1Е</option>
                                        <option value="5157">2А</option>
                                        <option value="5158">2Б</option>
                                        <option value="5159">2В</option>
                                        <option value="5160">2Г</option>
                                        <option value="5162">2Д</option>
                                        <option value="5161">2Е</option>
                                        <option value="2603">3А</option>
                                        <option value="2604">3Б</option>
                                        <option value="2605">3В</option>
                                        <option value="2607">3Г</option>
                                        <option value="2620">3Д</option>
                                        <option value="2619">3Е</option>
                                        <option value="2585">4А</option>
                                        <option value="2586">4Б</option>
                                        <option value="2587">4В</option>
                                        <option value="2611">4Г</option>
                                        <option value="2588">5А</option>
                                        <option value="2589">5Б</option>
                                        <option value="2590">5В</option>
                                        <option value="2613">5Г</option>
                                        <option value="2591">6А</option>
                                        <option value="2592">6Б</option>
                                        <option value="2593">6В</option>
                                        <option value="2615">6г</option>
                                        <option value="2594">7А</option>
                                        <option value="2595">7Б</option>
                                        <option value="2596">7В</option>
                                        <option value="2616">7Г</option>
                                        <option value="2597">8А</option>
                                        <option value="2598">8Б</option>
                                        <option value="2606">8В</option>
                                        <option value="2599">9А</option>
                                        <option value="2600">9Б</option>
                                        <option value="2610">9В</option>
                                        <option value="2617">9Г</option>
                                        <option value="2601">10А</option>
                                        <option value="2602">Выпуск/10Б</option>
                                        <option value="2612">Выпуск/10В</option>
                                        <option value="2618">Выпуск/10Г</option>
                                        <option value="2608">Выпуск/11А</option>
                                        <option value="2609">Выпуск/11Б</option>
                                        <option value="2614">Выпуск/11В</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label">Начальный пароль</label>
                                <div class="col-sm-9 col-md-10 col-lg-3">
                                    <div class="readonly">wW2V5RK</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_surname" class="col-sm-3 col-md-2 col-form-label">Портфолио</label>
                                <div class="col-sm-9 col-md-10 col-lg-3">
                                    <a readonly class="form-control-plaintext" href="/selfie/?sid=173634"
                                       target="_blank">Открыть</a></div>
                            </div>
                    </div>

                    </fieldset>

                    <div class="form-row">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>

                    <script type="text/javascript" id="django-admin-form-add-constants"
                            src="/static/admin/js/change_form.js"></script>
                    <script type="text/javascript" id="django-admin-prepopulated-fields-constants"
                            src="/static/admin/js/prepopulate_init.js" data-prepopulated-fields="[]"></script>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
