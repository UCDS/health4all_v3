
<script src="./vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>

<div class="row col-md-offset-2">
        <?php if(isset($msg)){ ?>
                <div class="alert alert-info"><?php echo $msg;?>
                </div>
        <?php
                 }
        ?>
    <?php echo form_open('register/add_secondary_route',array('role'=>'form','class'=>'form-horizontal','id'=>'create_user')); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                    <h4>Add Secondary Route</h4>
            </div>

            <div class="panel-body">
                <div class="row">
                    <label>Primary Route</label><br />
                    <select name="country" id="country-list" class="demoInputBox" onChange="getState(this.value);">
                        <option value="">Select Route</option>
                        <?php
                        foreach ($route_primary_id as $country) {
                        ?>
                        <option value="<?php echo $country["route_primary_id"]; ?>"><?php echo $country["route_primary"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>    
                 <div class="row">
                    <label>Secondary Route</label><br />
                     <select name="state"
                        id="state-list" class="demoInputBox">
                        <option value="">Select State</option>
                    </select> <img id="loader" src="./images/loader.gif" />
                </div>
            </div>
        </div>
        <div class="panel-footer">
                <button name="submit" class="btn btn-sm btn-primary" type="submit" value="submit">Submit</button>
        </div>	
    </form>
</div>