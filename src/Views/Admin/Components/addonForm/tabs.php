<ul class="nav nav-tabs nav-justified" id="addonForm" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="period-tab" data-bs-toggle="tab" data-bs-target="#period-tab-pane" type="button" role="tab" aria-controls="period-tab-pane" aria-selected="true">Periodo <i x-show="formValidationPeriod()" class="fa-solid fa-circle-check text-success"></i> </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" :class="(formValidationPeriod() || 'disabled')" id="header-tab" data-bs-toggle="tab" data-bs-target="#header-tab-pane" type="button" role="tab" aria-controls="header-tab-pane" aria-selected="false">Cabecera <i x-show="formValidationHeader()" class="fa-solid fa-circle-check text-success"></i> </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" :class="formValidationHeader() || 'disabled'" id="left-tab" data-bs-toggle="tab" data-bs-target="#left-tab-pane" type="button" role="tab" aria-controls="left-tab-pane" aria-selected="false">Lateral izquierdo <i x-show="formValidationLeft()" class="fa-solid fa-circle-check text-success"></i> </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" :class="formValidationLeft() || 'disabled'" id="right-tab" data-bs-toggle="tab" data-bs-target="#right-tab-pane" type="button" role="tab" aria-controls="right-tab-pane" aria-selected="false" right>Lateral derecho <i x-show="formValidationRight()" class="fa-solid fa-circle-check text-success"></i> </button>
    </li>
</ul>
<div class="tab-content" id="addonFormContent">
    <div class="tab-pane fade show active" id="period-tab-pane" role="tabpanel" aria-labelledby="period-tab" tabindex="0">
        <?php include('addonPeriodForm.php') ?>
    </div>
    <div class="tab-pane fade" id="header-tab-pane" role="tabpanel" aria-labelledby="header-tab" tabindex="0">
        <?php include('addonHeaderForm.php') ?>
    </div>
    <div class="tab-pane fade" id="left-tab-pane" role="tabpanel" aria-labelledby="left-tab" tabindex="0">
        <?php include('addonLeftForm.php') ?>
    </div>
    <div class="tab-pane fade" id="right-tab-pane" role="tabpanel" aria-labelledby="right-tab" tabindex="0">
        <?php include('addonRightForm.php') ?>
    </div>
</div>