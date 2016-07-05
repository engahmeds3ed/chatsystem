<?php $this->load->view($this->foldername.'/template/header'); ?>

<div class="panel-group" id="accordion">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h1 class="panel-title">
                Redirecting!
            </h1>
        </div>
        <div class="panel-collapse in collapse">
            <div class="panel-body">
                <?php echo $msg; ?>
                <meta http-equiv="Refresh" content="4; URL='<?php echo $url; ?>'" />
            </div>
        </div>
    </div>
</div>

<?php $this->load->view($this->foldername.'/template/footer'); ?>