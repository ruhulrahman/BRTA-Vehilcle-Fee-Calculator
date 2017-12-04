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
//License Issue Fee.........
$license_issue_fee = 250 ;
$license_issue_vat = vat_cal($license_issue_fee);
$license_issue_total = $license_issue_fee + $license_issue_vat;

//Non-Professional Renewal Fee............
$non_pro_renewal_fee=1500 ;
$non_pro_renewal_vat = vat_cal($non_pro_renewal_fee);
$non_pro_renewal_total = $non_pro_renewal_fee + $non_pro_renewal_vat;

//Smart Card Fee.............
$smart_card_fee =400 ;
$smart_card_vat = vat_cal($smart_card_fee);
$smart_card_total = $smart_card_fee + $smart_card_vat;

//Main Fee total............
$main_fee_total = $license_issue_fee + $non_pro_renewal_fee + $smart_card_fee;

//Vat total.............
$vat_total = $license_issue_vat + $non_pro_renewal_vat + $smart_card_vat;

//Grand Total............
$grand_total = $main_fee_total + $vat_total;

?>

<div class="driving_license_area">
	<div class="container driving_license">
		<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<h2><marquee behavior="alternate">Non-Professional driving license  fee</marquee></h2>
				<table>
					<tr>
						<th>Name of Fee Item</th>
						<th>Main Fee (Tk.)</th>
						<th>Vat (Tk.)</th>
						<th>Total (Tk.)</th>
					</tr>
					<tr>
						<td class="left">License Issue Fee</td>
						<td><?php echo $license_issue_fee; ?></td>
						<td><?php echo $license_issue_vat; ?></td>
						<td><?php echo $license_issue_total; ?></td>
					</tr>
					<tr>
						<td class="left">Renewal Fee</td>
						<td><?php echo $non_pro_renewal_fee; ?></td>
						<td><?php echo $non_pro_renewal_vat; ?></td>
						<td><?php echo $non_pro_renewal_total; ?></td>
					</tr>
					<tr>
						<td class="left">Smart Card Fee</td>
						<td><?php echo $smart_card_fee; ?></td>
						<td><?php echo $smart_card_vat; ?></td>
						<td><?php echo $smart_card_total; ?></td>
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
