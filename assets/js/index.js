// hero-switch
$(".home-hero .__heroContent .__action").on("click", function () {
    $('#q-cards,#q-hero').fadeIn(1000, function () {
        // run extra code here
        $("#q-cards").switchClass("d-none", "d-block");
        $("#q-hero").switchClass("d-block", "d-none");
    });
});

// q-cards
const swiper = new Swiper('.swiper', {
    speed: 600,
    allowTouchMove: false,
    slideShadows: false,
    // simulateTouch: false,
    navigation: {
        nextEl: '.swiper-slide .__action:not(.__submit)',
        prevEl: '.swiper-slide .__previous',
    },
    effect: 'creative',
    creativeEffect: {
        prev: {
            translate: [0, 0, -400],
        },
        next: {
            translate: ['100%', 0, 0],
        },
    },
});
$

// userForm
$('input.form-input').focus(function () {
    $(this).parents('.field').addClass('focused');
});

$('input').blur(function () {
    var inputValue = $(this).val();
    if (inputValue == "") {
        $(this).parents('.field').removeClass('focused');
    } else {
        $(this).addClass('filled');
    }
})

// popover init
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})