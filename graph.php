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
    $propertyCreation['hours_saved']['multiple'] = round($propertyCreation['manual_effort']['multiple']) - round($propertyCreation['content_ai']['multiple']);

    // print_r(json_encode($propertyCreation));


    $propertyUpdate['manual_effort']['single'] = (($churn + $_POST['properties']) * 0.75 * $_POST['ota'] * 4);
    $propertyUpdate['manual_effort']['multiple'] = $propertyUpdate['manual_effort']['single'] * 60;

    $propertyUpdate['content_ai']['single'] = (($churn + $_POST['properties']) * 0.75 * $_POST['ota'] * 4) / (0.05 * $_POST['ota'] + $_POST['ota']);
    $propertyUpdate['content_ai']['multiple'] = $propertyUpdate['content_ai']['single'] * 60;

    $propertyUpdate['hours_saved']['single'] = round($propertyUpdate['manual_effort']['single']) - round($propertyUpdate['content_ai']['single']);
    $propertyUpdate['hours_saved']['multiple'] = round($propertyUpdate['manual_effort']['multiple']) - round($propertyUpdate['content_ai']['multiple']);

    // print_r(json_encode($propertyUpdate));


    $efficiencyScalability['hours_available'] = $_POST['team'] * 160;
    $efficiencyScalability['manual_update'] = (($churn + $_POST['properties']) * 2.5 * $_POST['ota']) + (($churn + $_POST['properties']) * $_POST['ota'] * 4 * 0.75);
    $efficiencyScalability['content_ai'] = (((($churn + $_POST['properties']) * 2.5 * $_POST['ota']) + (($churn + $_POST['properties']) * 4 * 0.75 * $_POST['ota']))) / (0.05 * $_POST['ota'] + $_POST['ota']);
    $efficiencyScalability['team_effort'] = 1 - $efficiencyScalability['content_ai'] / $efficiencyScalability['manual_update'];
    $efficiencyScalability['hours_saved'] = $efficiencyScalability['manual_update'] - $efficiencyScalability['content_ai'];

    // print_r(json_encode($efficiencyScalability));


    // $messages['active'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ? true : false;
    $messages['active'] = true;
    $messages['heading'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ? "Your team does not have enough bandwidth for regular updates." : "Content AI's Reporting Tool";
    $messages['content'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ?
        "Ideally there is a requirement of <span class='__text-highlight'>" . round($efficiencyScalability['manual_update'] / 160) .
        " team member(s)</span>, but can be managed by <span class='__text-highlight'>" . round($efficiencyScalability['content_ai'] / 160) .
        " member(s)</span> using Content AI." : "Personalized Hotel Content Score Report";

    // print_r(json_encode($messages));
    // mail("rahiovaiz@gmail.com", "Success", "Send mail from localhost using PHP");
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
                            <?php if ($messages['active']) : ?>
                                <h1><?= $messages['heading'] ?></h1>
                                <span><?= $messages['content'] ?></span>

                            <?php endif; ?>
                        </div>
                        <div class="row p-0 m-0 __graphVis">
                            <div class="col-6 p-0 chart-container" style="position: relative; width:340px;">
                                <canvas id="contentAi-graphs-1" width="340" height="245"></canvas>
                            </div>
                            <div class="col-6 p-0 chart-container" style="position: relative; width:340px;">
                                <canvas id="contentAi-graphs-2" width="340" height="245"></canvas>
                            </div>
                        </div>
                        <div>
                            <span>Improve your property creation efficiency by 92%. Save almost upto 420 hrs or 601 minutes with in creating a new property with AI powered content optimization solution. </span>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="assets/js/ranger.js"></script>
    <script src="assets/js/index.js"></script>

    <?php if (isset($_POST['submit'])) : ?>


        <script>
            var myData = {
                labels: ['Manual Effort', 'Content A.I'],
                datasets: [{
                    fill: false,
                    backgroundColor: ['#0f72ee',
                        '#000',
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
                    backgroundColor: ['red',
                        '#f4ced4',
                    ],
                    data: [<?= round($propertyUpdate['manual_effort']['single']) ?>,
                        <?= round($propertyUpdate['content_ai']['single']) ?>
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
                    enabled: true
                },
                hover: {
                    animationDuration: 2
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
        </script>
    <?php endif; ?>
    <script>
        $(document).ready(function() {
            $('.range.properties .calculation').val($('.range.properties .ui-state-default').html());
            $('.range.team .calculation').val($('.range.team .ui-state-default').html());
            $('.range.partners .calculation').val($('.range.partners .ui-state-default').html());
            $('.range.average .calculation').val($('.range.average .ui-state-default').html());
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    var attributeValue = $(mutation.target).html();
                    $(mutation.target).siblings('.calculation').val(attributeValue);
                });
            });
            observer.observe($('.range.properties .ui-state-default')[0], {
                attributes: true,
                attributeFilter: ['class'],
            });
            observer.observe($('.range.team .ui-state-default')[0], {
                attributes: true,
                attributeFilter: ['class'],
            });
            observer.observe($('.range.partners .ui-state-default')[0], {
                attributes: true,
                attributeFilter: ['class'],
            });
            observer.observe($('.range.average .ui-state-default')[0], {
                attributes: true,
                attributeFilter: ['class'],
            });
        });
    </script>
</body>

</html>