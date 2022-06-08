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
    <div class="container __hero <?= isset($_POST['submit']) ? 'd-none' : '' ?>">
      <img class="svgBg" src="assets/images/svg/hero-background.svg">
      <div class="row home-hero slides">
        <div class="col-sm-12 col-1336-5 col-lg-6 __heroContent">
          <div class="__content">
            <h1>Content AI's Personalized Hotel Content Score Report.</h1>
            <p>Based on your unique inputs, Content AI could help your team achieve the desired revenue results.</p>
            <span class="__take">Take This Assignment</a>
          </div>
        </div>
        <!-- slideItems -->
        <form action="graph.php" method="post" class="rate-calculator col-sm-12 col-1336-7 col-lg-6" id="q-cards">
          <div class="swiper __rate-slider">
            <div class="swiper-wrapper">
              <!-- Slide 1-->
              <div class="swiper-slide">
                <div class="__slideContent">
                  <h1><span>Questions:</span></h1>
                  <div class="__slideHead d-flex justify-content-between align-items-start">
                    <p><span>We need some details to generate a valid report</span></p>
                  </div>
                  <ol class="__questions">
                    <li class="q-1">
                      <p>How many properties does your chain have?</p>
                      <div class="range-wrap">
                        <span>0</span>
                        <div class="range properties">
                          <input type="hidden" name="properties" class="calculation">
                        </div>
                        <span>150</span>
                      </div>
                    </li>
                    <li class="q-2">
                      <p>What is the size of your team that manages the content?</p>
                      <div class="range-wrap">
                        <span>0</span>
                        <div class="range team">
                          <input type="hidden" name="team" class="calculation">
                        </div>
                        <span>10</span>
                      </div>
                    </li>
                    <li class="q-3">
                      <p>How many unique demand partners is your property connected to?</p>
                      <div class="range-wrap">
                        <span>0</span>
                        <div class="range partners">
                          <input type="hidden" name="ota" class="calculation">
                        </div>
                        <span>15</span>
                      </div>
                    </li>
                  </ol>
                  <div class="__actions">
                    <button class="__action __next">Next</button>
                  </div>
                </div>
              </div>
              <!-- slide 2 -->
              <div class="swiper-slide">
                <div class="__slideContent">
                  <h1><span>Questions:</span></h1>
                  <p><span>We need some details to generate a valid report</span></p>
                  <ol start="4" class="__questions radio-qs">
                    <li class="q-4">
                      <div class="__slideHead d-flex justify-content-between align-items-start">
                        <p>What is your team's current content stack? (Select all that apply)</p>
                      </div>
                      <p><span>Content Management</span></p>
                      <fieldset class="radio-qset">
                        <input type="checkbox" name="cm-action[]" value="Shared Drives" id="cm-sharedDrives">
                        <label class="w-50" for="cm-sharedDrives">
                          <p>Shared Drives</p>
                        </label>
                        <input type="checkbox" name="cm-action[]" value="Excel Sheets" id="cm-xlSheets">
                        <label class="w-50" for="cm-xlSheets">
                          <p>Excel Sheets</p>
                        </label>
                        <input type="checkbox" name="cm-action[]" value="Gmail" id="cm-gmail">
                        <label class="w-50" for="cm-gmail">
                          <p>Gmail</p>
                        </label>
                        <input type="checkbox" name="cm-action[]" value="In-house custom solution" id="cm-inhouseSolution">
                        <label class="w-50" for="cm-inhouseSolution">
                          <p>In-house custom solution</p>
                        </label>
                      </fieldset>
                      <p class="mt-4"><span>Content Optimization</span></p>
                      <fieldset class="radio-qset">
                        <input type="checkbox" name="cm-action2[]" value="Photo Editing Tools" id="cm-photoEditingtools">
                        <label class="w-50" for="cm-photoEditingtools">
                          <p>Photo Editing Tools</p>
                        </label>
                        <input type="checkbox" name="cm-action2[]" value="Image filters" id="cm-imageFilters">
                        <label class="w-50" for="cm-imageFilters">
                          <p>Image filters</p>
                        </label>
                        <input type="checkbox" name="cm-action2[]" value="SEO" id="cm-seo">
                        <label class="w-50" for="cm-seo">
                          <p>SEO</p>
                        </label>
                        <input type="checkbox" name="cm-action2[]" value="In-house custom solution" id="cm-inhouseSolution2">
                        <label class="w-50" for="cm-inhouseSolution2">
                          <p>In-house custom solution</p>
                        </label>
                      </fieldset>
                      <p class="mt-4"><span>Content Distribution</span></p>
                      <fieldset class="radio-qset">
                        <input type="checkbox" name="cm-action3[]" value="Manual" id="cm-manual">
                        <label class="w-50" for="cm-manual">
                          <p>Manual</p>
                        </label>
                        <input type="checkbox" name="cm-action3[]" value="Bulk" id="cm-bulk">
                        <label class="w-50" for="cm-bulk">
                          <p>Bulk</p>
                        </label>
                        <input type="checkbox" name="cm-action3[]" value="In-house custom solution" id="cm-inhouseSolution3">
                        <label class="w-50" for="cm-inhouseSolution3">
                          <p>In-house custom solution</p>
                        </label>
                      </fieldset>
                    </li>
                  </ol>
                  <div class="__actions">
                    <a href="javascript:void(0)" class="__previous">Back</a>
                    <button class="__action __next">Next</button>
                  </div>
                </div>
              </div>
              <!-- slide 3 -->
              <div class="swiper-slide">
                <div class="__slideContent">
                  <h1><span>Questions:</span></h1>
                  <p><span>We need some details to generate a valid report</span></p>
                  <ol start="5" class="__questions radio-qs">
                    <li class="q-5">
                      <div class="__slideHead d-flex justify-content-between align-items-start">
                        <p>How frequently do you update the descriptive content for your properties?</p>
                        <span class="popover-toggle" type="button" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="left" data-bs-content="Demand partners keep updating their list of amenities based on customer requirements. E.g. with the pandemic there has been a new focus on health and safety requirements.">
                          <img src="assets/images/svg/icons/info-icon.svg"></span>
                      </div>

                      <fieldset class="radio-qset">
                        <input type="radio" name="cm-action4" value="At least once a month" id="cm-atleastAmonth">
                        <label class="w-100" for="cm-atleastAmonth">
                          <p>At least once a month</p>
                        </label>
                        <input type="radio" name="cm-action4" value="At least once a quarter" id="cm-atleastAquater">
                        <label class="w-100" for="cm-atleastAquater">
                          <p>At least once a quarter</p>
                        </label>
                        <input type="radio" name="cm-action4" value="Annually" id="cm-annual">
                        <label class="w-100" for="cm-annual">
                          <p>Annually</p>
                        </label>
                        <input type="radio" name="cm-action4" value="Only when property state changes" id="cm-onlypropertystateChange">
                        <label class="w-100" for="cm-onlypropertystateChange">
                          <p>Only when property state changes</p>
                        </label>
                      </fieldset>
                    </li>
                    <li class="q-6">
                      <div class="__slideHead d-flex justify-content-between align-items-start">
                        <p>How frequently do you update the images for your properties?</p>
                        <span class="popover-toggle" type="button" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="left" data-bs-content="Expedia research shows that hotel listings with
                    high-quality photos have a 63% higher click-through rate than those without.">
                          <img src="assets/images/svg/icons/info-icon.svg"></span>
                      </div>
                      <fieldset class="radio-qset">
                        <input type="radio" name="cm-action5" value="At least once in 6 months" id="cm-atleast6months">
                        <label class="w-100" for="cm-atleast6months">
                          <p>At least once in 6 months</p>
                        </label>
                        <input type="radio" name="cm-action5" value="At least once a year" id="cm-atleastAyear">
                        <label class="w-100" for="cm-atleastAyear">
                          <p>At least once a year</p>
                        </label>
                        <input type="radio" name="cm-action5" value="Only when property state changes" id="cm-onlypropertystateChange2">
                        <label class="w-100" for="cm-onlypropertystateChange2">
                          <p>Only when property state changes</p>
                        </label>
                        <input type="radio" name="cm-action5" value="cm-other" id="cm-other">
                        <label class="w-100" for="cm-other">
                          <p>Other:</p>
                          <input class="form-control w-50" placeholder="Please type here..." type="text" name="other" id="cm-other">
                        </label>
                      </fieldset>
                    </li>
                  </ol>
                  <div class="__actions">
                    <a href="javascript:void(0)" class="__previous">Back</a>
                    <button class="__action __next">Next</button>
                  </div>
                </div>
              </div>
              <!-- slide 4 -->
              <div class="swiper-slide">
                <div class="__slideContent">
                  <h1><span>Questions:</span></h1>
                  <p><span>We need some details to generate a valid report</span></p>
                  <ol start="7" class="__questions radio-qs">
                    <li class="q-7">
                      <div class="__slideHead d-flex justify-content-between align-items-start">
                        <p>What's your biggest pain point with respect to content across demand partners?</p>
                      </div>

                      <fieldset class="radio-qset">
                        <input type="radio" name="cm-action6" value="Resource limitations" id="cm-resLimit">
                        <label class="w-100" for="cm-resLimit">
                          <p>Resource limitations</p>
                        </label>
                        <input type="radio" name="cm-action6" value="Tracking content performance across demand partners" id="cm-trackPerf">
                        <label class="w-100" for="cm-trackPerf">
                          <p>Tracking content performance across demand partners</p>
                        </label>
                        <input type="radio" name="cm-action6" value="Automated tools for management and distribution of content" id="cm-autoMnD">
                        <label class="w-100" for="cm-autoMnD">
                          <p>Automated tools for management and distribution of content</p>
                        </label>
                        <input type="radio" name="cm-action6" value="All of the above" id="cm-aota">
                        <label class="w-100" for="cm-aota">
                          <p>All of the above</p>
                        </label>
                      </fieldset>
                    </li>
                    <li class="q-8">
                      <div class="__slideHead d-flex justify-content-between align-items-start">
                        <p>Do you track the content quality scores across demand partners?</p>
                        <span class="popover-toggle" type="button" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="left" data-bs-content="Your content score decides where you show up on the user search results for the demand partner">
                          <img src="assets/images/svg/icons/info-icon.svg"></span>
                      </div>
                      <fieldset class="radio-qset">
                        <input type="radio" name="cm-action7" value="Yes" id="cm-yes">
                        <label class="w-25" for="cm-yes">
                          <p>Yes</p>
                        </label>
                        <input type="radio" name="cm-action7" value="No" id="cm-no">
                        <label class="w-25" for="cm-no">
                          <p>No</p>
                        </label>
                      </fieldset>
                    </li>
                    <li class="q-9">
                      <p>What would be your average content score across properties and demand partners (out of 10)?</p>
                      <div class="range-wrap">
                        <span>0</span>
                        <div class="range average">
                          <input type="hidden" name="average" class="calculation">
                        </div>
                        <span>10</span>
                      </div>
                    </li>
                  </ol>
                  <div class="__actions">
                    <a href="javascript:void(0)" class="__previous">Back</a>
                    <button class="__action __next">Next</button>
                  </div>
                </div>
              </div>
              <!-- slide 5 -->
              <div class="swiper-slide">
                <div class="__slideContent">
                  <fieldset class="detailsForm w-100">
                    <div class="field">
                      <input required id="fname" type="text" class="w-100 input-text form-input">
                      <label for="fname">First Name</label>
                    </div>
                    <div class="field">
                      <input required id="lname" type="text" class="w-100 input-text form-input">
                      <label for="lname">Last Name</label>
                    </div>
                    <div class="field">
                      <input required id="jobtitle" type="text" class="w-100 input-text form-input">
                      <label for="jobtitle">Job Title</label>
                    </div>
                    <div class="field">
                      <input required id="email" type="email" class="w-100 input-text form-input">
                      <label for="email">Email</label>
                    </div>
                    <div class="field">
                      <input required id="hotel" type="text" class="w-100 input-text form-input">
                      <label for="hotel">Hotel Name</label>
                    </div>
                    <div class="field">
                      <input required id="howdy" type="text" class="w-100 input-text form-input">
                      <label for="howdy">How did you hear about us?</label>
                    </div>
                  </fieldset>
                  <div class="__actions">
                    <a href="javascript:void(0)" class="__previous">Back</a>
                    <button type="submit" onsubmit="$('.container.__hero').hide();" name="submit" class="__action __submit">Generate Report</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
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
                <p class="__title">Effort saving in property creation</p>
                <canvas id="contentAi-graphs-1" width="340" height="245"></canvas>
              </div>
              <div class="col-6 p-0 chart-container" style="position: relative; width:340px;">
                <p class="__title">Effort saving in property creation</p>
                <canvas id="contentAi-graphs-2" width="340" height="245"></canvas>
              </div>
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
        "layout": {
          "padding": 0
        },
        "responsive": true,
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
            "scaleLabel": {
              "display": true,
              "labelString": "Hours"
            },
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