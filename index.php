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

  print_r(json_encode($propertyCreation));


  $propertyUpdate['manual_effort']['single'] = (($churn + $_POST['properties']) * 0.75 * $_POST['ota'] * 4);
  $propertyUpdate['manual_effort']['multiple'] = $propertyUpdate['manual_effort']['single'] * 60;

  $propertyUpdate['content_ai']['single'] = (($churn + $_POST['properties']) * 0.75 * $_POST['ota'] * 4) / (0.05 * $_POST['ota'] + $_POST['ota']);
  $propertyUpdate['content_ai']['multiple'] = $propertyUpdate['content_ai']['single'] * 60;

  $propertyUpdate['hours_saved']['single'] = round($propertyUpdate['manual_effort']['single']) - round($propertyUpdate['content_ai']['single']);
  $propertyUpdate['hours_saved']['multiple'] = round($propertyUpdate['manual_effort']['multiple']) - round($propertyUpdate['content_ai']['multiple']);

  print_r(json_encode($propertyUpdate));


  $efficiencyScalability['hours_available'] = $_POST['team'] * 160;
  $efficiencyScalability['manual_update'] = (($churn + $_POST['properties']) * 2.5 * $_POST['ota']) + (($churn + $_POST['properties']) * $_POST['ota'] * 4 * 0.75);
  $efficiencyScalability['content_ai'] = (((($churn + $_POST['properties']) * 2.5 * $_POST['ota']) + (($churn + $_POST['properties']) * 4 * 0.75 * $_POST['ota']))) / (0.05 * $_POST['ota'] + $_POST['ota']);
  $efficiencyScalability['team_effort'] = 1 - $efficiencyScalability['content_ai'] / $efficiencyScalability['manual_update'];
  $efficiencyScalability['hours_saved'] = $efficiencyScalability['manual_update'] - $efficiencyScalability['content_ai'];

  print_r(json_encode($efficiencyScalability));


  $messages['active'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ? true : false;
  $messages['heading'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ? "Your team does not have enough bandwidth for regular updates" : "";
  $messages['content'] = $efficiencyScalability['hours_available'] < $efficiencyScalability['manual_update'] ?
    "Ideally there is a requirement of " . round($efficiencyScalability['manual_update'] / 160) .
    " team member(s), but can be managed by" . round($efficiencyScalability['content_ai'] / 160) .
    " member(s) using Content AI" : "";

  print_r(json_encode($messages));
  mail("rahiovaiz@gmail.com", "Success", "Send mail from localhost using PHP");
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
  <title>Rate Gain | Calulator</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body oncontextmenu="return false" class="rateGaincalc">
  <div class="rate-gain __page-wrapper container-md">
    <div class="__header container">
      <div class="__brand">
        <img src="assets/images/logo.png" alt="RateGain">
      </div>
    </div>
    <div class="container __hero">
      <img class="svgBg" src="assets/images/svg/hero-background.svg">
      <div class="row home-hero slides">
        <div class="col-sm-12 col-1336-5 col-lg-6 __heroContent">
          <div class="__content">
            <h1>Content AI's Personalized Hotel Content Score Report.</h1>
            <p>Based on your unique inputs, Content AI could help your team achieve the desired revenue results.</p>
            <span class="__action">Take This Assignment</a>
          </div>
        </div>
        <!-- hero-image -->
        <!-- <div class="col-sm-12 col-1336-7 col-lg-6 d-block" id="q-hero">
          <img src="assets/images/svg/hero-illustration.svg" alt="RateGain Calculator">
        </div> -->
        <!-- slideItems -->
        <form action="" method="post" class="col-sm-12 col-1336-7 col-lg-6" id="q-cards">
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
                    <button class="__action">Next</button>
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
                        <input type="radio" name="cm-action" id="cm-sharedDrives">
                        <label class="w-50" for="cm-sharedDrives">
                          <p>Shared Drives</p>
                        </label>
                        <input type="radio" name="cm-action" id="cm-xlSheets">
                        <label class="w-50" for="cm-xlSheets">
                          <p>Excel Sheets</p>
                        </label>
                        <input type="radio" name="cm-action" id="cm-gmail">
                        <label class="w-50" for="cm-gmail">
                          <p>Gmail</p>
                        </label>
                        <input type="radio" name="cm-action" id="cm-inhouseSolution">
                        <label class="w-50" for="cm-inhouseSolution">
                          <p>In-house custom solution</p>
                        </label>
                      </fieldset>
                      <p class="mt-4"><span>Content Optimization</span></p>
                      <fieldset class="radio-qset">
                        <input type="radio" name="cm-action2" id="cm-photoEditingtools">
                        <label class="w-50" for="cm-photoEditingtools">
                          <p>Photo Editing Tools</p>
                        </label>
                        <input type="radio" name="cm-action2" id="cm-imageFilters">
                        <label class="w-50" for="cm-imageFilters">
                          <p>Image filters</p>
                        </label>
                        <input type="radio" name="cm-action2" id="cm-seo">
                        <label class="w-50" for="cm-seo">
                          <p>SEO</p>
                        </label>
                        <input type="radio" name="cm-action2" id="cm-inhouseSolution2">
                        <label class="w-50" for="cm-inhouseSolution2">
                          <p>In-house custom solution</p>
                        </label>
                      </fieldset>
                      <p class="mt-4"><span>Content Distribution</span></p>
                      <fieldset class="radio-qset">
                        <input type="radio" name="cm-action3" id="cm-manual">
                        <label class="w-50" for="cm-manual">
                          <p>Manual</p>
                        </label>
                        <input type="radio" name="cm-action3" id="cm-bulk">
                        <label class="w-50" for="cm-bulk">
                          <p>Bulk</p>
                        </label>
                        <input type="radio" name="cm-action3" id="cm-inhouseSolution3">
                        <label class="w-50" for="cm-inhouseSolution3">
                          <p>In-house custom solution</p>
                        </label>
                      </fieldset>
                    </li>
                    <li class="q-5">
                      <div class="__slideHead d-flex justify-content-between align-items-start">
                        <p>How frequently do you update the descriptive content for your properties?</p>
                        <span class="popover-toggle" type="button" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="left" data-bs-content="Demand partners keep updating their list of amenities based on customer requirements. E.g. with the pandemic there has been a new focus on health and safety requirements.">
                          <img src="assets/images/svg/icons/info-icon.svg"></span>
                      </div>

                      <fieldset class="radio-qset">
                        <input type="radio" name="cm-action4" id="cm-atleastAmonth">
                        <label class="w-100" for="cm-atleastAmonth">
                          <p>At least once a month</p>
                        </label>
                        <input type="radio" name="cm-action4" id="cm-atleastAquater">
                        <label class="w-100" for="cm-atleastAquater">
                          <p>At least once a quarter</p>
                        </label>
                        <input type="radio" name="cm-action4" id="cm-annual">
                        <label class="w-100" for="cm-annual">
                          <p>Annually</p>
                        </label>
                        <input type="radio" name="cm-action4" id="cm-onlypropertystateChange">
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
                        <input type="radio" name="cm-action5" id="cm-atleast6months">
                        <label class="w-100" for="cm-atleast6months">
                          <p>At least once in 6 months</p>
                        </label>
                        <input type="radio" name="cm-action5" id="cm-atleastAyear">
                        <label class="w-100" for="cm-atleastAyear">
                          <p>At least once a year</p>
                        </label>
                        <input type="radio" name="cm-action5" id="cm-onlypropertystateChange2">
                        <label class="w-100" for="cm-onlypropertystateChange2">
                          <p>Only when property state changes</p>
                        </label>
                        <input type="radio" name="cm-action5" id="cm-other">
                        <label class="w-100" for="cm-other">
                          <p>Other:</p>
                          <input class="form-control w-50" placeholder="Please type here..." type="text" name="other" id="cm-other">
                        </label>
                      </fieldset>
                    </li>
                    <li class="q-7">
                      <div class="__slideHead d-flex justify-content-between align-items-start">
                        <p>What's your biggest pain point with respect to content across demand partners?</p>
                      </div>

                      <fieldset class="radio-qset">
                        <input type="radio" name="cm-action6" id="cm-resLimit">
                        <label class="w-100" for="cm-resLimit">
                          <p>Resource limitations</p>
                        </label>
                        <input type="radio" name="cm-action6" id="cm-trackPerf">
                        <label class="w-100" for="cm-trackPerf">
                          <p>Tracking content performance across demand partners</p>
                        </label>
                        <input type="radio" name="cm-action6" id="cm-autoMnD">
                        <label class="w-100" for="cm-autoMnD">
                          <p>Automated tools for management and distribution of content</p>
                        </label>
                        <input type="radio" name="cm-action6" id="cm-aota">
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
                        <input type="radio" name="cm-action7" id="cm-yes">
                        <label class="w-25" for="cm-yes">
                          <p>Yes</p>
                        </label>
                        <input type="radio" name="cm-action7" id="cm-no">
                        <label class="w-25" for="cm-no">
                          <p>No</p>
                        </label>
                      </fieldset>
                    </li>
                    <li class="q-9">
                      <p>What would be your average content score across properties and demand partners (out of 10)?</p>
                      <div class="range-wrap">
                        <span>0</span>
                        <div class="range"></div>
                        <span>10</span>
                      </div>
                    </li>
                  </ol>
                  <div class="__actions">
                    <a href="javascript:void(0)" class="__previous">Back</a>
                    <button class="__action">Next</button>
                  </div>
                </div>
              </div>
              <!-- slide 3 -->
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
                    <button type="submit" name="submit" class="__action __submit">Generate Report</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
  <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
  <script src="assets/js/ranger.js"></script>
  <script src="assets/js/index.js"></script>

  <script>
    $(document).ready(function() {
      $('.range.properties .calculation').val($('.range.properties .ui-state-default').html());
      $('.range.team .calculation').val($('.range.team .ui-state-default').html());
      $('.range.partners .calculation').val($('.range.partners .ui-state-default').html());
      var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          var attributeValue = $(mutation.target).html();
          $(mutation.target).siblings('.calculation').val(attributeValue);
        });
      });
      observer.observe($('.range.properties .ui-state-default')[0], {
        attributes: true,
        attributeFilter: ['class']
      });
      observer.observe($('.range.team .ui-state-default')[0], {
        attributes: true,
        attributeFilter: ['class']
      });
      observer.observe($('.range.partners .ui-state-default')[0], {
        attributes: true,
        attributeFilter: ['class']
      });

    });
  </script>
</body>

</html>