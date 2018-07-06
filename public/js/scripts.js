(function ($) {

var px = ''; //'rt--'

/**
 * Функция для вывода набора jQuery по селектору, к селектору добавляются
 * префиксы
 *
 * @param {string} selector Принимает селектор для формирования набора
 * @return {jQuery} Возвращает новый jQuery набор по выбранным селекторам
 */
function $x(selector) {
    return $( x(selector) );
}

/**
 * Функция для автоматического добавления префиксов к селекторы
 *
 * @param {string} selector Принимает селектор для формирования набора
 * @return {string} Возвращает новый jQuery набор по выбранным селекторам
 */
function x(selector) {
    var arraySelectors = selector.split('.'),
        firstNotClass = !!arraySelectors[0];

    selector = '';

    for(var i=0; i<arraySelectors.length; i++) {
        if (!i) {
            if (firstNotClass) selector += arraySelectors[i];
            continue;
        }
        selector += '.' + px + arraySelectors[i];
    }

    return selector;
}

$(function(){
    //= ../../bricks/basic/index.js
    //= ../../bricks/extra/index.js
});

})(jQuery);
