// hero-switch
$(".home-hero .__heroContent .__action").on("click", function () {
    $('#q-cards,#q-hero').fadeIn(1000, function() {
        // run extra code here
        $("#q-cards").switchClass("d-none", "d-block");
        $("#q-hero").switchClass("d-block", "d-none");
      });
});

// q-cards
const swiper = new Swiper('.swiper', {
    speed: 600,
    slideShadows: false,
    simulateTouch: false,
    navigation: {
        nextEl: '.swiper-slide .__action',
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