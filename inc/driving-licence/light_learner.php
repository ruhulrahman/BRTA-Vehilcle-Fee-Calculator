<?php require('driving_button.php');?>

<?php
//Vat Rate
$vat_rate=0.15;
function vat_cal($vat_value){
	global $vat_rate;
	$vat_cal= $vat_value * $vat_rate;
	$vat= ceil($vat_cal);
	
	return $vat;
}
//Learner Fee.........
$light_learner_fee = 300;
$learner_vat = vat_cal($light_learner_fee);
$learner_total = $light_learner_fee + $learner_vat;

//Test Fee............
$test_fee=150;
$test_vat = vat_cal($test_fee);
$test_total = $test_fee + $test_vat;

//Main Fee total............
$main_fee_total = $light_learner_fee + $test_fee;

//Vat total.............
$vat_total = $learner_vat + $test_vat;


//Grand Total............
$grand_total = $main_fee_total + $vat_total;

?>

<div class="driving_license_area">
	<div class="container driving_license">
		<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<h2><marquee behavior="alternate">driving license light learner fee</marquee></h2>
				<table>
					<tr>
						<th>Name of Fee Item</th>
						<th>Main Fee (Tk.)</th>
						<th>Vat (Tk.)</th>
						<th>Total (Tk.)</th>
					</tr>
					<tr>
						<td class="left">Light Learner Fee</td>
						<td><?php echo $light_learner_fee; ?></td>
						<td><?php echo $learner_vat; ?></td>
						<td><?php echo $learner_total; ?></td>
					</tr>
					<tr>
						<td class="left">Test Fee</td>
						<td><?php echo $test_fee; ?></td>
						<td><?php echo $test_vat; ?></td>
						<td><?php echo $test_total; ?></td>
					</tr>
					<tr class="total">
						<td class="left">Grand Total</td>
						<td><?php echo $main_fee_total; ?></td>
						<td><?php echo $vat_total; ?></td>
						<td><?php echo $grand_total; ?></td>
					</tr>
				</table>
			</div>
			<div class="col-lg-3"></div>
		</div>
	</div>
</div>



