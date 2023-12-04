<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <h3 class="info-box-number" id="count-users"></h3>
                <span class="info-box-text">Total Users</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <h3 class="info-box-number" id="count-profile-completed"></h3>
                <span class="info-box-text">Valid Profile</span>
            </div>
        </div>
    </div>
    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
            <div class="info-box-content">
                <h3 class="info-box-number" id="count-profile-uncompleted"></h3>
                <span class="info-box-text">Invalid Profile</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-friends"></i></span>
            <div class="info-box-content">
                <h3 class="info-box-number" id="count-iduka"></h3>
                <span class="info-box-text">DU/DI</span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>