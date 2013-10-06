<div class="clear_left shun"></div>
<style>
	.ok {color:green;}
	.warning {color:orange;}
	.failed {color:red;}
</style>
<div style="padding: 10px;">
	<p><a class="submit" href="<?=BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=mission_tracker'.AMP.'method=new_mission'?>">New Mission</a></p>
	<h3 id="missions"><?= lang("Missions") ?></h3>
	<?php
		$this->table->set_template($cp_table_template);
		$this->table->set_heading(
			lang('Client'),
			lang('City'),
			lang('Status'),
			lang('')
		);
	
		foreach($missions as $key => $mission) {			
			$this->table->add_row(
	            $mission->client,
	            $mission->city,
				$mission->status,
				'<a href='.BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=mission_tracker'.AMP.'method=edit'.AMP.'mission_id='.$mission->id.'>'.lang('Edit').'</a>'.
				'&nbsp;&nbsp;'.'<a href='.BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=mission_tracker'.AMP.'method=delete'.AMP.'mission_id='.$mission->id.'>'.lang('Delete').'</a>'
	        );
		}
		echo $this->table->generate();
	?>
</div>