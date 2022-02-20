# EDUMGT

[![](https://github.com/nemeaq/nemeaq-edumgt/workflows/EditorConfig/badge.svg)](https://github.com/nemeaq/nemeaq-edumgt/actions?query=workflow%3AEditorConfig)
[![](https://github.com/nemeaq/nemeaq-edumgt/workflows/Markdown/badge.svg)](https://github.com/nemeaq/nemeaq-edumgt/actions?query=workflow%3AMarkdown)
[![](https://github.com/nemeaq/nemeaq-edumgt/workflows/HTML/badge.svg)](https://github.com/nemeaq/nemeaq-edumgt/actions?query=workflow%3AHTML)
[![](https://github.com/nemeaq/nemeaq-edumgt/workflows/Stylelint/badge.svg)](https://github.com/nemeaq/nemeaq-edumgt/actions?query=workflow%3AStylelint)
[![](https://github.com/nemeaq/nemeaq-edumgt/workflows/ESLint/badge.svg)](https://github.com/nemeaq/nemeaq-edumgt/actions?query=workflow%3AESLint)
[![](https://github.com/nemeaq/nemeaq-edumgt/workflows/Deploy/badge.svg)](https://github.com/nemeaq/nemeaq-edumgt/actions?query=workflow%3ADeploy)

Система управления оразовательным учреждением (EDUMGT - Education Organization Management System)

## Дизайн

- [Макет в Figma](https://www.figma.com/file/***).

## Разработка

- Установка зависимостей: `npm install`
- Старт сервера для локальной разработки: `npm start`
- Запуск сборки для деплоя: `npm run build`

## Участие в разработке

Вы можете выбрать [ишью из списка](https://github.com/nemeaq/nemeaq-edumgt/issues) и сказать, что берётесь за работу.

Форкните и присылайте пулреквесты.

Для разработчиков проекта есть чат в Телеграме, где можно синхронизироваться, обсуждать и планировать процесс.
Постучите [@hanriel](https://t.me/hanriel) в Телеграме, если хотите попасть туда.

[//]: # (## Окружение и технологии)

[//]: # (Движок [Eleventy]&#40;https://www.11ty.io/&#41; собирает Markdown и JSON по шаблонам [Nunjucks]&#40;https://mozilla.github.io/nunjucks/&#41; и генерирует статичные HTML-страницы. Стили пишутся на чистом CSS, соединяются импортами, сжимаются и оптимизируются. Браузерная совместимость описана в ключе `browserlist` в [package.json]&#40;https://github.com/web-standards-ru/web-standards.ru/blob/master/package.json&#41;, если коротко — «без IE11».)

## Принципы верстки

**Mobile-first.** Сначала мы делаем мобильную версию интерфейса, а потом начинаем увеличивать с помощью `@media`.
Например, кнопка открытия главного меню спрячется, когда для меню будет достаточно места на экране.

**Нет брекпоинтов для адаптации.** Каждый компонент для себя решает, когда ему адаптироваться. Например, когда пункты
меню начинают помещаться — пора развернуть его во всю ширину и спрятать кнопку-гамбургер.

**Проект начат 2 октября 2021г.**
