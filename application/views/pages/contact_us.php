
	<div class="row">
		<?php foreach($defaultsConfigs as $default){
			if ($default->default_id == "uc_url"){
			    $uc_url = $default->value;
			}
			if ($default->default_id == "app_helpline"){
				$app_helpline=$default->value;
			}
        }
        ?>                          
		<h1>Contact Us</h1>
		<p>For any queries, contact us at <?php echo $app_helpline ?></p>
		<p>Health4all - a Free and Open Source application supported by <a href=<?php echo $uc_url ?> target="_blank">YouSee</a></p>
	</div>
