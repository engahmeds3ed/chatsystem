<?php $this->load->view($this->foldername.'/template/header'); ?>

<div class="row" id="home">
	<div class="col-md-6 col-sm-12" id="home-register">
		<div class="panel panel-info">
			<div class="panel-heading">
				Register Now
			</div>
			<div class="panel-body">
				<?php echo form_open( base_url("register") ); ?>
				<div class="form-group">
					<?php echo form_input("user_fullname","","placeholder='Full Name' class='form-control'"); ?>
				</div>
				<div class="form-group">
					<?php echo form_input("user_email","","placeholder='Email' class='form-control'"); ?>
				</div>
				<div class="form-group">
					<?php echo form_input("user_username","","placeholder='Username' class='form-control'"); ?>
				</div>
				<div class="form-group">
					<?php echo form_password("user_password","","class='form-control'"); ?>
				</div>
				<hr>
				<?php echo form_submit("register_submit","Register Now","class='btn btn-success pull-right'"); ?>
				<div class="clearfix"></div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div><!-- #home-register -->

	<div class="col-md-6 col-sm-12" id="home-login">
		<div class="panel panel-info">
			<div class="panel-heading">
				Login Now
			</div>
			<div class="panel-body">
				<?php if(!empty($errors)){ ?>
					<div class="alert alert-danger">
					<ul>
					<?php foreach ($errors as $error) {
						?><li><?php echo $error; ?></li><?php
					} ?>
					</ul>
					</div>
				<?php } ?>
				<?php echo form_open( base_url("login") ); ?>
				<div class="form-group">
					<?php echo form_input("user_username","","placeholder='Username' class='form-control'"); ?>
				</div>
				<div class="form-group">
					<?php echo form_password("user_password","","class='form-control'"); ?>
				</div>
				<hr>
				<?php echo form_submit("login_submit","Login Now","class='btn btn-success pull-right'"); ?>
				<div class="clearfix"></div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div><!-- #home-login -->
</div><!-- #home.row -->

<?php $this->load->view($this->foldername.'/template/footer'); ?>