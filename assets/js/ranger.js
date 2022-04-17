let handleEl = ".ui-slider-handle";
// q1
$(".__questions .q-1 .range-wrap .range").slider({
    range: "min",
    min: 00,
    max: 150,
    value: 50,
    create: function () {
        return $(this).find(handleEl).html($(this).slider("value"));
    },
    slide: function (e, ui) {
        return $(this).find(handleEl).html(ui.value);
    }
});
// q2
$(".__questions .q-2 .range-wrap .range").slider({
    range: "min",
    min: 00,
    max: 10,
    value: 05,
    create: function () {
        return $(this).find(handleEl).html($(this).slider("value"));
    },
    slide: function (e, ui) {
        return $(this).find(handleEl).html(ui.value);
    }
});
$(".__questions .q-3 .range-wrap .range").slider({
    range: "min",
    min: 00,
    max: 15,
    value: 02,
    create: function () {
        return $(this).find(handleEl).html($(this).slider("value"));
    },
    slide: function (e, ui) {
        return $(this).find(handleEl).html(ui.value);
    }
});
$(".__questions .q-9 .range-wrap .range").slider({
    range: "min",
    min: 00,
    max: 10,
    value: 4,
    create: function () {
        return $(this).find(handleEl).html($(this).slider("value"));
    },
    slide: function (e, ui) {
        return $(this).find(handleEl).html(ui.value);
    }
});