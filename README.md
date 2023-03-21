# Parser Manager Plugin for WordPress <sup><sup>[Beta](https://ru.wikipedia.org/wiki/Бета-тестирование)</sup></sup>

> **Warning**: Плагин в разработке!<br>
> Может работать не стабильно.

Представляем вашему вниманию плагин, с которым без знаний программирования, сможете создавать свои парстеры данных и выводит их на график.

### Добавление нового парсера
1. Выберете метод `Start/End Selector`
2. В поле **Link** вводите ссылку на страницу, откуда будут браться данные
3. В поле **Start Selector** вводите html, который находится до вашего значения
4. В поле **End Selector** вводите html, который находится после вашего значения

Например, ваше значение находится в данном блоке `<span itemprop="price">265</span>`, то в поле **Start Selector**, нужно ставить `<span itemprop="price">`, а в поле **End Selector** , нужно ставить `</span>`.

![Parser Settings](./resources/screenshots/parser-settings.png)

Поле этого всё что между кодом **Start Selector** и **End Selector** будет парситься

Доступные методы парсеров:
- Start/End Selector
- XPatch
- Steam

### Особенности:
- Парсинг запускается один раз в сутки
- Для вывода графика используется удобная библиотека Highcharts

## Демо
![Demo](./resources/screenshots/demo.png)