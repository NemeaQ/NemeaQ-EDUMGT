let bootstrap = require('bootstrap')
let parse = require('chart.js')

let exampleSocket = new WebSocket("ws://edumgt.hanriel.ru:7777");
let socketOutput = document.getElementById('socketOutput');
let cardDate = document.getElementById('cardDate');
let cardEnable = document.getElementById('cardEnable');

let today = new Date();
cardDate.value = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

exampleSocket.onopen = function (event) {
    exampleSocket.send("checkSession");
};

exampleSocket.onmessage = function (event) {
    socketOutput.innerHTML += event.data;
};

function sendStart() {
    exampleSocket.send("start " + cardDate.value + " " + cardEnable.checked);
}

const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            '7 дек',
            '8 дек',
            '9 дек',
            '10 дек',
            '11 дек',
            '13 дек',
            '14 дек',
            '15 дек',
            '16 дек',
            '17 дек'
        ],
        datasets: [{
            label: 'Посещаемость',
            data: [89, 821, 836, 822, 95, 893, 1237, 1238, 944, 936],
            borderColor: 'rgb(54, 162, 235)',
            tension: 0.4
        }]
    }
});

const form = document.querySelector('form');
const notificator = document.querySelector('.notify');

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
