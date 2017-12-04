<?php require('driving_button.php');?>

<?php
$vat_rate=0.15;
//Learner Fee.........
$learner_fee = 150;
$learner_vat = $learner_fee * $vat_rate;
$learner_total = $learner_fee + $learner_vat;

//Test Fee............
$test_fee=150;
$test_vat = $test_fee * $vat_rate;
$test_total = $test_fee + $test_vat;

//Main Fee total............
$main_fee_total = $learner_fee + $test_fee;

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
			<h2><marquee behavior="alternate">driving license learner fee</marquee></h2>
				<table>
					<tr>
						<th>Name of Fee Item</th>
						<th>Main Fee (Tk.)</th>
						<th>Vat (Tk.)</th>
						<th>Total (Tk.)</th>
					</tr>
					<tr>
						<td class="left">Learner Fee</td>
						<td><?php echo $learner_fee; ?></td>
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



