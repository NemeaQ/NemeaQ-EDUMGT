/*
 * MIT License
 *
 * Copyright (c) 2021 NemeaQ
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

let lib_chartjs = require('chart.js');
let lib_bs = require('bootstrap/dist/js/bootstrap.min');

const menuButton = document.querySelector('.menu__button');
const menuList = document.querySelector('.menu__list');

if (!!menuButton) {
    menuButton.addEventListener('click', () => {
        let expanded = menuButton.getAttribute('aria-expanded') === 'true';
        menuButton.setAttribute('aria-expanded', !expanded);
        menuButton.classList.toggle('menu__button--open');
        menuList.classList.toggle('menu__list--open');
    });
}

let cardDate = document.getElementById('cardDate');
if(!!cardDate){
    let exampleSocket = new WebSocket("ws://edumgt.hanriel.ru:7777");
    let socketOutput = document.getElementById('socketOutput');
    let cardEnable = document.getElementById('cardEnable');

    let today = new Date();
    cardDate.value = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

    // exampleSocket.onopen = function (event) {
        // exampleSocket.send("checkSession");
    // };

    exampleSocket.onmessage = function (event) {
        socketOutput.innerHTML += event.data;
    };

    let btn_sendStart = document.getElementById('btn_sendStart');
    btn_sendStart.addEventListener('click', () => {
        exampleSocket.send("start " + cardDate.value + " " + cardEnable.checked);
    });

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1 дек','2 дек', '3 дек',
                '6 дек', '7 дек', '8 дек','9 дек','10 дек',
                '13 дек','14 дек','15 дек','16 дек','17 дек',
                '20 дек','21 дек','22 дек'
            ],
            datasets: [{
                label: 'План',
                data: [827, 784, 742, 775, 789, 821, 836, 822, 893, 1237, 1238, 944, 936, 1239, 994, 1239],
                borderColor: 'rgb(54, 162, 235)',
                tension: 0.4
            }]
        },
        options: { scales: { y: { max: 1246 } } }
    });
}

document.addEventListener("DOMContentLoaded", page_ready);

