
	<div class="col-md-10 col-sm-9" style="text-align:center;">
		<h4>Staff Login - Blood Bank</h4>
		<?php echo validation_errors(); ?>

		<?php echo form_open('bloodbank/staff/login') ?>
		<br />
		<label for="username">Username: </label>
		<input type="text" placeholder="Username" name="username" id="username" required />
		<br /><br />
		<label for="password">Password: </label>
		<input type="password" placeholder="Password" name="password" id="password" required />
		<br />
		<br />
		<input type="submit" value="Login" />
		</form>
	</div>
