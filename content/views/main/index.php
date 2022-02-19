<section class="flex-vertical">
    <div class="card card--hover card--2">
        <div class="card__header">
            <img class="card__icon"
                 src="https://cdn3.iconfinder.com/data/icons/business-and-finance-icons/512/Credit_Card-512.png">
            <p class="card__title">Работа с картами</p>
            <div class="card__actions">
                <input type="date" id="cardDate">
                <label><input type="checkbox" id="cardEnable"> ОК</label>
                <button class="btn btn-accent" id="btn_sendStart">Проверить карты</button>
            </div>
        </div>
        <div class="card__body">
            <pre id="socketOutput"></pre>
        </div>
    </div>
    <div class="card card--hover card--2">
        <div class="card__header">
            <img class="card__icon"
                 src="https://cdn3.iconfinder.com/data/icons/business-and-finance-icons/512/Credit_Card-512.png">
            <p class="card__title">Проценты за прошлые дни</p>
            <div class="card__actions">
                <button class="btn btn-accent" disabled>Обновить</button>
            </div>
        </div>
        <div class="card__body">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</section>