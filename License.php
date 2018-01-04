<?php
class License {
	public $settings = array(
		'description' => 'An admin interface to show your Billic license details and allows you to request an updated license.',
	);
	
	function settings($array) {
		global $billic, $db;
		if (isset($_POST['license_reset'])) {
			set_config('billic_license', '');	
			$billic->status = 'updated';
		} else {
			$licdata = $billic->get_license_data();
			$usage = $db->q('SELECT (SELECT COUNT(*) FROM `users`) as usersCount, (SELECT COUNT(*) FROM `services`) as servicesCount, (SELECT COUNT(*) FROM `plans`) as plansCount, (SELECT COUNT(*) FROM `orderforms`) as orderformsCount');
			$usage = $usage[0];
			echo '<table class="table table-striped">';
			echo '<tr><th colspan="2">Billic License Details</tr>';
			echo '<tr><td>Expiry</td><td>'.safe($licdata['end']).'</td></tr>';
			echo '<tr><td>Domain</td><td>'.safe($licdata['domain']).'</td></tr>';
			echo '<tr><td>Users</td><td>'.$usage['usersCount'].' of '.($licdata['desc']=='Unlimited'?'Unlimited':$licdata['users']).'</td></tr>';
			echo '<tr><td>Services</td><td>'.$usage['servicesCount'].' of '.($licdata['desc']=='Unlimited'?'Unlimited':$licdata['services']).'</td></tr>';
			echo '<tr><td>Plans</td><td>'.$usage['plansCount'].' of '.($licdata['desc']=='Unlimited'?'Unlimited':$licdata['plans']).'</td></tr>';
			echo '<tr><td>Order Forms</td><td>'.$usage['orderformsCount'].' of '.($licdata['desc']=='Unlimited'?'Unlimited':$licdata['orderforms']).'</td></tr>';
			echo '</table>';
			echo '<div align="center"><form method="POST"><input type="hidden" name="billic_ajax_module" value="License"><input type="submit" name="license_reset" value="Update License &raquo;" class="btn btn-xs btn-warning"></form></div>';
		}
	}
}
