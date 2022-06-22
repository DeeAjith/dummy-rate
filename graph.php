<!DOCTYPE html>
<html lang="en">
<?php
if (isset($_POST['submit'])) {
    /*
  F4 = $churn;
  E4 = $_POST['properties'];
  E5 = $_POST['team'];
  E6 = $_POST['ota'];
  */
    // print_r(json_encode($_POST));
    $propertyCreation = [];
    $propertyUpdate = [];
    $efficiencyScalability = [];
    $churn = round($_POST['properties'] * 0.06);
    $propertyCreation['manual_effort']['single'] = (($churn + $_POST['properties']) * 2.5 * $_POST['ota']);
    $propertyCreation['manual_effort']['multiple'] = $propertyCreation['manual_effort']['single'] * 60;

    $propertyCreation['content_ai']['single'] = ((($churn + $_POST['properties']) * 2.5 * $_POST['ota']) / (0.05 * $_POST['ota'] + $_POST['ota']));
    $propertyCreation['content_ai']['multiple'] = $propertyCreation['content_ai']['single'] * 60;

    $propertyCreation['hours_saved']['single'] = round($propertyCreation['manual_effort']['single']) - round($propertyCreation['content_ai']['single']);
    $propertyCreation['days']['single'] = number_format((float)$propertyCreation['hours_saved']['single'] / 8, 2, '.', '');
    $propertyCreation['hours_saved']['multiple'] = round($propertyCreation['manual_effort']['multiple']) - round($propertyCreation['content_ai']['multiple']);
    $propertyCreation['percentage'] = round((1 - round($propertyCreation['content_ai']['single']) / round($propertyCreation['manual_effort']['single'])) * 100);

    // print_r(json_encode($propertyCreation));


    $propertyUpdate['manual_effort']['single'] = (($churn + $_POST['properties']) * 0.75 * $_POST['ota'] * 4);
    $propertyUpdate['manual_effort']['multiple'] = $propertyUpdate['manual_effort']['single'] * 60;

    $propertyUpdate['content_ai']['single'] = (($churn + $_POST['properties']) * 0.75 * $_POST['ota'] * 4) / (0.05 * $_POST['ota'] + $_POST['ota']);
    $propertyUpdate['content_ai']['multiple'] = $propertyUpdate['content_ai']['single'] * 60;

    $propertyUpdate['hours_saved']['single'] = round($propertyUpdate['manual_effort']['single']) - round($propertyUpdate['content_ai']['single']);
    $propertyUpdate['days']['single'] = number_format((float)$propertyUpdate['hours_saved']['single'] / 8, 2, '.', '');
    $propertyUpdate['hours_saved']['multiple'] = round($propertyUpdate['manual_effort']['multiple']) - round($propertyUpdate['content_ai']['multiple']);
    $propertyUpdate['percentage'] = round((1 - round($propertyUpdate['content_ai']['single']) / round($propertyUpdate['manual_effort']['single'])) * 100);

    // print_r(json_encode($propertyUpdate));


    $efficiencyScalability['hours_available'] = $_POST['team'] * 160;
    $efficiencyScalability['manual_update'] = (($churn + $_POST['properties']) * 2.5 * $_POST['ota']) + (($churn + $_POST['properties']) * $_POST['ota'] * 4 * 0.75);
    $efficiencyScalability['content_ai'] = (((($churn + $_POST['properties']) * 2.5 * $_POST['ota']) + (($churn + $_POST['properties']) * 4 * 0.75 * $_POST['ota']))) / (0.05 * $_POST['ota'] + $_POST['ota']);
    $efficiencyScalability['team_effort'] = round((1 - $efficiencyScalability['content_ai'] / $efficiencyScalability['manual_update']) * 100);
    $efficiencyScalability['hours_saved'] = round($efficiencyScalability['manual_update'] - $efficiencyScalability['content_ai']);
    $efficiencyScalability['days'] = number_format((float)$efficiencyScalability['hours_saved'] / 8, 2, '.', '');

    // print_r(json_encode($efficiencyScalability));


    // $messages['active'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ? true : false;
    $messages['active'] = true;
    $messages['heading'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ? "Your team does not have enough bandwidth for regular updates." : "";
    $messages['content'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ?
        "Ideally there is a requirement of <span class='__text-highlight'>" . round($efficiencyScalability['manual_update'] / 160) .
        " team member(s)</span>, but can be managed by <span class='__text-highlight'>" . round($efficiencyScalability['content_ai'] / 160) .
        " member(s)</span> using Content AI." : "";

    // print_r(json_encode($messages));
    // mail("rahiovaiz@gmail.com", "Success", "Send mail from localhost using PHP");
} else {
    header('Location: index.php');
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <title>Rate Gain | Calulator</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body oncontextmenu="return false" class="rateGaincalc">
    <style type="text/css">
        input[type=checkbox] {
            transform: scale(1.5);
        }

        .w-50 {
            width: 47% !important;
            position: relative;
            left: 11px;
            bottom: 9px;
        }
    </style>
    <div class="rate-gain __page-wrapper container-md">
        <div class="__header container">
            <div class="__brand">
                <img src="assets/images/logo.png" alt="RateGain">
            </div>
        </div>
        <?php if (isset($_POST['submit'])) : ?>
            <!-- output -->
            <div class="container __output __hero">
                <img class="svgBg" src="assets/images/svg/hero-background.svg">
                <div class="rateGain-out">
                    <div class="__content">
                        <div class="__header">
                            <h2 class="text-xl">Content AI's Reporting Tool</h2>
                            <p class="text-dark">Personalized Hotel Content Score Report</p>
                            <?php if ($messages['active']) : ?>
                                <h1><?= $messages['heading'] ?></h1>
                                <span><?= $messages['content'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="row p-0 m-0 __graphVis">
                            <div class="col-6 p-0 chart-container" style="position: relative; width: 400px">
                                <div>
                                    <p>Time taken to create a new property</p>
                                    <button class="__toggle-HM" timeat="hours">
                                        <span>Hours</span>
                                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.936553 0.599895C1.20779 0.344154 1.63499 0.356719 1.89073 0.627959L4.99961 3.92525L8.10849 0.627959C8.36423 0.356719 8.79143 0.344154 9.06267 0.599895C9.33391 0.855635 9.34647 1.28284 9.09073 1.55408L5.49073 5.37226C5.3632 5.50752 5.18552 5.5842 4.99961 5.5842C4.8137 5.5842 4.63602 5.50752 4.50849 5.37226L0.908488 1.55408C0.652748 1.28284 0.665313 0.855635 0.936553 0.599895Z" fill="black" />
                                        </svg>
                                    </button>
                                    <input type="hidden" class="manual" value="<?= round($propertyCreation['manual_effort']['single']) ?>">
                                    <input type="hidden" class="content" value="<?= round($propertyCreation['content_ai']['single']) ?>">
                                    <canvas id="contentAi-graphs-1" class="graphs" width="450" height="350"></canvas>
                                </div>
                                <div class="__header __footer">
                                    <span class="popover-toggle" type="button" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="right" data-bs-content="92% of travelers are more likely to book accommodations with detailed property descriptions and photos. It is essential to be detailed with your Content, so include clear images and descriptions of your property’s amenities and features.">
                                        <img src="assets/images/svg/icons/info-icon.svg">
                                    </span>
                                    <span>Improve your efficiency by <span class='__text-highlight'><?= $propertyCreation['percentage'] ?>% </span>. save up to <span class='__text-highlight'> <?= $propertyCreation['hours_saved']['single'] ?> hrs or <?= round($propertyCreation['days']['single']) ?> Working days</span> to create a new property with an AI-powered content optimization solution. </span>
                                </div>
                            </div>
                            <div class="col-6 p-0 chart-container" style="position: relative; width: 400px">
                                <div>
                                    <p>Time taken for regular property updates</p>
                                    <button class="__toggle-HM" timeat="hours">
                                        <span>Hours</span>
                                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.936553 0.599895C1.20779 0.344154 1.63499 0.356719 1.89073 0.627959L4.99961 3.92525L8.10849 0.627959C8.36423 0.356719 8.79143 0.344154 9.06267 0.599895C9.33391 0.855635 9.34647 1.28284 9.09073 1.55408L5.49073 5.37226C5.3632 5.50752 5.18552 5.5842 4.99961 5.5842C4.8137 5.5842 4.63602 5.50752 4.50849 5.37226L0.908488 1.55408C0.652748 1.28284 0.665313 0.855635 0.936553 0.599895Z" fill="black" />
                                        </svg>
                                    </button>
                                    <input type="hidden" class="manual" value="<?= round($propertyUpdate['manual_effort']['single']) ?>">
                                    <input type="hidden" class="content" value="<?= round($propertyUpdate['content_ai']['single']) ?>">
                                    <canvas id="contentAi-graphs-2" class="graphs" width="450" height="350"></canvas>
                                </div>
                                <div class="__header __footer">
                                    <span class="popover-toggle" type="button" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="right" data-bs-content="Leading OTA has made 12 major content updates since 2019. Covering 100+ content attributes from health and safety to sustainability to policies. It is recommended to audit your property, including traveler photos, to identify the gaps and missing fields.">
                                        <img src="assets/images/svg/icons/info-icon.svg">
                                    </span>
                                    <span>Improve your efficiency by <span class='__text-highlight'><?= $propertyUpdate['percentage'] ?>% </span>. save up to <span class='__text-highlight'> <?= $propertyUpdate['hours_saved']['single'] ?> hrs or <?= round($propertyUpdate['days']['single']) ?> Working days</span> in creating in creating new property with AI-powered content optimization solution. </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="__content">
                        <div class="row p-0 m-0 __graphVis">
                            <div class="col-12 p-0 chart-container" style="position: relative;width: 75% ;height: 350px ;">
                                <p>Efficiency & Scalability of Content updates</p>
                                <button class="__toggle-HM" timeat="hours">
                                    <span>Hours</span>
                                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.936553 0.599895C1.20779 0.344154 1.63499 0.356719 1.89073 0.627959L4.99961 3.92525L8.10849 0.627959C8.36423 0.356719 8.79143 0.344154 9.06267 0.599895C9.33391 0.855635 9.34647 1.28284 9.09073 1.55408L5.49073 5.37226C5.3632 5.50752 5.18552 5.5842 4.99961 5.5842C4.8137 5.5842 4.63602 5.50752 4.50849 5.37226L0.908488 1.55408C0.652748 1.28284 0.665313 0.855635 0.936553 0.599895Z" fill="black" />
                                    </svg>
                                </button>
                                <input type="hidden" class="manual" value="<?= round($efficiencyScalability['manual_update']) ?>">
                                <input type="hidden" class="content" value="<?= round($efficiencyScalability['content_ai']) ?>">
                                <canvas style="width: 75% ;height: 250px;" class="graphs" id="contentAi-graphs-3"></canvas>
                            </div>
                        </div>
                        <div class="__header __footer" style="width: 70%">
                            <img src="assets/images/svg/icons/info-icon.svg">
                            <span>Improve your efficiency by <span class='__text-highlight'><?= $efficiencyScalability['team_effort'] ?>% </span>. save up to <span class='__text-highlight'> <?= $efficiencyScalability['hours_saved'] ?> hrs or <?= round($efficiencyScalability['days']) ?> Working days</span> in creating in creating new property with AI powered content optimization solution. </span>
                        </div>
                    </div>
                    <div class="__info">
                        <h1>Manage & Distribute Your Hotel's Content faster</h1>
                        <p>Avoid the constant manual back and forth, email threads, cumbersome spreadsheets and copy/paste tasks. Free up so much of your team’s average work week!</p>
                        <button class="__action">Learn more about Content AI</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <script src="assets/js/ranger.js"></script>
    <script src="assets/js/index.js"></script>

    <script>
        $(document).ready(function() {

            var myData = {
                labels: ['Manual Effort', 'Content A.I'],
                datasets: [{
                    fill: false,
                    backgroundColor: ['#F19A00',
                        '#00A4A7',
                    ],
                    data: [<?= round($propertyCreation['manual_effort']['single']) ?>,
                        <?= round($propertyCreation['content_ai']['single']) ?>
                    ],
                }]
            };
            var myData2 = {
                labels: ['Manual Effort', 'Content A.I'],
                datasets: [{
                    fill: false,
                    backgroundColor: ['#F19A00',
                        '#00A4A7',
                    ],
                    data: [<?= round($propertyUpdate['manual_effort']['single']) ?>,
                        <?= round($propertyUpdate['content_ai']['single']) ?>
                    ],
                }]
            };
            var myData3 = {
                labels: ['Manual Update', 'Content A.I'],
                datasets: [{
                    fill: false,
                    backgroundColor: ['#F19A00',
                        '#00A4A7',
                    ],
                    data: [<?= round($efficiencyScalability['manual_update']) ?>,
                        <?= round($efficiencyScalability['content_ai']) ?>
                    ],
                }]
            };
            var myoption = {
                title: {
                    display: true
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                hover: {
                    animationDuration: 2
                },
                animation: {
                    onProgress: function(animation) {
                        progress.value = animation.currentStep / animation.numSteps;
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.05)",
                        },
                        barPercentage: .6,
                        categoryPercentage: .7,
                        ticks: {
                            autoSkip: true,
                            maxRotation: 0,
                            minRotation: 0,
                            fontSize: 12,
                            fontColor: "Black",
                            defaultFontFamily: "Arial, Helvetica, sans-serif"
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.05)",
                        },
                        ticks: {
                            beginAtZero: true,
                            fontSize: 12,
                            fontColor: "Black",
                            defaultFontFamily: "Arial, Helvetica, sans-serif",
                        }

                    }]
                },
                animation: {
                    duration: 1,
                    onComplete: function() {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = "rgba(0, 0, 0, .5)";
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function(dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                            });
                        });
                    }
                }
            };

            var ctx = document.getElementById('contentAi-graphs-1').getContext('2d');
            var ctx2 = document.getElementById('contentAi-graphs-2').getContext('2d');
            var ctx3 = document.getElementById('contentAi-graphs-3').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: myData,
                options: myoption
            });
            var myChart2 = new Chart(ctx2, {
                type: 'bar',
                data: myData2,
                options: myoption
            });
            var myChart3 = new Chart(ctx3, {
                type: 'bar',
                data: myData3,
                options: myoption
            });
            $('.__toggle-HM').click(function() {
                var canvasId = $(this).parent().children('canvas.graphs').attr('id');
                var canvasStyle = $('#' + canvasId).attr('style');
                $('#' + canvasId).remove(); // this is my <canvas> element
                $(this).parent().append('<canvas id="' + canvasId + '" class="graphs" style="' + canvasStyle + '" ><canvas>');
                var contentElement = document.getElementById(canvasId).getContext('2d');
                var manual = parseInt($(this).siblings('.manual').val());
                var content = parseInt($(this).siblings('.content').val());
                if ($(this).attr('timeat') == 'hours') {
                    manual = parseInt(manual / 8);
                    content = parseInt(content / 8);
                    $(this).attr('timeat', 'days');
                    $(this).children('span').text('Days');
                } else {
                    manual = parseInt(manual);
                    content = parseInt(content);
                    $(this).attr('timeat', 'hours');
                    $(this).children('span').text('Hours');
                }
                console.log(typeof(manual));
                var data = {
                    labels: ['Manual Effort', 'Content A.I'],
                    datasets: [{
                        fill: false,
                        backgroundColor: ['#F19A00',
                            '#00A4A7',
                        ],
                        data: [manual, content],
                    }]
                };
                makeGraph(contentElement, data, myoption, canvasId);
                $('.chartjs-hidden-iframe').remove();
            });

            function makeGraph(graphElement, myData3, myoption, canvasId) {
                new Chart(graphElement, {
                    type: 'bar',
                    data: myData3,
                    options: myoption
                });
            }
        });
    </script>
</body>

</html>