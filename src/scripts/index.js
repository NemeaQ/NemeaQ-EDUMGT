/*
 * MIT License
 *
 * Copyright (c) 2022 NemeaQ
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

const {Chart} = require('chart.js');
require('bootstrap/dist/js/bootstrap.min');

let cardDate = document.getElementById('cardDate');
if (cardDate) {
    let exampleSocket = new WebSocket('ws://edumgt.hanriel.ru:7777');
    let socketOutput = document.getElementById('socketOutput');
    let cardEnable = document.getElementById('cardEnable');

    let today = new Date();
    cardDate.value = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

    // exampleSocket.onopen = function (event) {
    // exampleSocket.send("checkSession");
    // };

    exampleSocket.onmessage = function(event) {
        socketOutput.innerHTML += event.data;
    };

    let btnSendStart = document.getElementById('btnSendStart');
    btnSendStart.addEventListener('click', () => {
        exampleSocket.send('start ' + cardDate.value + ' ' + cardEnable.checked);
    });

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1 ??????', '2 ??????', '3 ??????',
                '6 ??????', '7 ??????', '8 ??????', '9 ??????', '10 ??????',
                '13 ??????', '14 ??????', '15 ??????', '16 ??????', '17 ??????',
                '20 ??????', '21 ??????', '22 ??????',
            ],
            datasets: [{
                label: '????????',
                data: [827, 784, 742, 775, 789, 821, 836, 822, 893, 1237, 1238, 944, 936, 1239, 994, 1239],
                borderColor: 'rgb(54, 162, 235)',
                tension: 0.4,
            }],
        },
        options: {scales: {y: {max: 1246}}},
    });
}

const menuButton = document.querySelector('.menu__button');
const menuList = document.querySelector('.menu__list');
const form = document.querySelector('#ajax_form');
const notificator = document.querySelector('.notify');
const ipCopyBtn = document.querySelector('#ipCopyBtn');

if (ipCopyBtn) {
    ipCopyBtn.addEventListener('click', () => copyText());
}

if (menuButton) {
    menuButton.addEventListener('click', () => {
        let expanded = menuButton.getAttribute('aria-expanded') === 'true';
        menuButton.setAttribute('aria-expanded', !expanded);
        menuButton.classList.toggle('menu__button--open');
        menuList.classList.toggle('menu__list--open');
    });
}

if (form) {
    form.addEventListener('submit', (event) => {
        if (form.id === 'no_ajax') {
            return;
        }
        event.preventDefault();

        let request = new XMLHttpRequest();
        request.open(form.method, form.action, true);

        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                let data = JSON.parse(this.response);
                if (data.url) {
                    window.location.href = '/' + data.url;
                } else if (data.reload) {
                    window.location.reload();
                } else {
                    notify(data.message, data.status);
                }
            } else {
                notify('???????????? ?????? ?????????????????????? ?? ??????????????, ?????????????????? ???????????? ??????????????', 'error');
            }
        };

        request.onerror = (e) => notify(e.returnValue, 'error');
        request.send(new FormData(form));
    });
}

function copyText(text = 'obsidianorder.ru') {
    if (text) {
        navigator.clipboard.writeText(text)
            .then(() => notify('?????????? ????????????????????!'))
            .catch(() => notify('??????-???? ?????????? ???? ??????', 'error'));
    }
}

function notify(text, type = 'notice') {
    if (text) {
        notificator.innerHTML = text;
        notificator.setAttribute('data-notification-status', type);
        notificator.classList.add('do-show');
        setTimeout(function() {
            notificator.classList.remove('do-show');
        }, 4000);
    }
}

window.notify = notify;
