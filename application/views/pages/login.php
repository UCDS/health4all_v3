  <div class="container" style="width:330px;">
  <?php if(validation_errors())
        {
    ?>
    <div class="alert alert-danger">
    <?php echo validation_errors();?>
    </div><?php 
    } 
  ?>
      <?php echo form_open('home/login',array('class'=>'form-signin','role'=>'form')); ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" placeholder="Username" name="username" required autofocus><br />
        <input type="password" class="form-control" placeholder="Password" name="password" required><br />
        <div class="row">
          <div class="col-md-6 col-xs-6">
            <label class="control-label"><h5>Captcha:</h5><br></label>
            <?php echo $image; ?>
          </div>
          <div class="col-md-6 col-xs-6">
            <label class="control-label"><h5>Enter Text From Left Box Below:</h5></label>
            <input type="text" name="captcha_text" class="form-control" placeholder="Captcha Text" required>
          </div>
        </div>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div>