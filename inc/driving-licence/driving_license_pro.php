<?php require('driving_button.php');?>

<?php
$vat_rate=0.15;
//License Issue Fee.........
$license_issue_fee =250  ;
$license_issue_vat = $license_issue_fee * $vat_rate;
$license_issue_total = $license_issue_fee + $license_issue_vat;

//Professional Renewal Fee............
$pro_renewal_fee=750 ;
$pro_renewal_vat = $pro_renewal_fee * $vat_rate;
$pro_renewal_total = $pro_renewal_fee + $pro_renewal_vat;

//Smart Card Fee.............
$smart_card_fee =400 ;
$smart_card_vat = $smart_card_fee * $vat_rate;
$smart_card_total = $smart_card_fee + $smart_card_vat;

//Main Fee total............
$main_fee_total = $license_issue_fee + $pro_renewal_fee + $smart_card_fee;

//Vat total.............
$vat_total = $license_issue_vat + $pro_renewal_vat + $smart_card_vat;

//Grand Total............
$grand_total = $main_fee_total + $vat_total;

?>

<div class="driving_license_area">
	<div class="container driving_license">
		<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<h2><marquee behavior="alternate">Professional driving license  fee</marquee></h2>
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
						<td><?php echo $pro_renewal_fee; ?></td>
						<td><?php echo $pro_renewal_vat; ?></td>
						<td><?php echo $pro_renewal_total; ?></td>
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



