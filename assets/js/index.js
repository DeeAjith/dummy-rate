// $('.__next').click(function () {
//     console.log('next click')
//     if ($('.swiper-slide[aria-label="1 / 5"]').hasClass('swiper-slide-active')) {
//         $('.__take').show();
//         console.log('next show')
//     } else {
//         $('.__take').hide();
//         console.log('next hide')
//     }
// });

// q-cards
const swiper = new Swiper('.swiper', {
    speed: 600,
    allowTouchMove: false,
    slideShadows: false,
    // simulateTouch: false,
    effect: 'cards',
    cardsEffect: {
        rotate: 15,
    },
    breakpoints: {
        0: {
            effect: 'creative',
            creativeEffect: {
                prev: {
                    // will set `translateZ(-400px)` on previous slides
                    translate: [0, 0, -400],
                },
                next: {
                    // will set `translateX(100%)` on next slides
                    translate: ['100%', 0, 0],
                },
            },
        },
        768: {
            effect: 'cards',
            cardsEffect: {
                rotate: 15,
                slideShadows: false,
            },
        }
    },
    navigation: {
        nextEl: '.swiper-slide .__action:not(.__submit)',
        prevEl: '.swiper-slide .__previous',
    },
});
swiper.on("slideChange", function () {
    console.log("slide changed - current slide is: " + this.realIndex)
    if (this.realIndex == 0) {
        $('.__take').slideDown();
    }
    else {
        $('.__take').slideUp();
    }
});

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