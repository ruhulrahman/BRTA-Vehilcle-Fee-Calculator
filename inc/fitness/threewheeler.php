<?php require('../../header.php');?>

<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
	$threewheeler_cc = $_POST['engine_cc'];
	$seat_no = $_POST['seat_no'];
}
else{
	$threewheeler_cc = "";
	$seat_no = "";
}
?>


<div class="threewheeler_input_area">
	<div class="container threewheeler_input">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="first">Fee Calculation for Three wheeler</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Three wheeler</div>
							<input class="form-control" type="number" min="30" max="500" name="engine_cc" <?php if($threewheeler_cc ==""){}else{ echo "value = ".$threewheeler_cc;}?> id="" placeholder="Enter your three wheeler cc" />
							<div class="input-group-addon">CC</div>
						</div><br />
						<div class="input-group">
							<div class="input-group-addon">Three wheeler</div>
							<input type="number"  min="2" max="10" name="seat_no" <?php if($seat_no == ""){}else{echo "value = ".$seat_no;}?> class="form-control" id="" placeholder="Enter your three wheeler seat number" />
							<div class="input-group-addon">Seat</div>
						</div>
						<input type="submit" class="btn btn-success" id="button" value="Calculate" />
					</div>
				</form>
			</div>
			<div class="col-lg-3"></div>
		</div>
	</div>
</div>

<?php
//Vat Rate
$vat_rate = 0.15;
//Function Registration Fee Calculation
function reg_cal($threewheeler_cc){
	if($threewheeler_cc <= 100){$reg_fee = 635;}
	else if($threewheeler_cc > 100){$reg_fee = 1150;}
	else{$reg_fee = "";}
	
	return $reg_fee ;
}

//Function for Tax Token
function tax_token_cal($seat_no){
	if($seat_no <= 2){$tax_token_fee = 1800;}
	else if($seat_no > 2){ $xtra_seat = $seat_no - 2;
							$xtra_fee = $xtra_seat * 500;
							$tax_token_fee = 1800 + $xtra_fee;}
	else{$tax_token_fee = "";}
	
	return $tax_token_fee;
}

//Inspection Fee
$inspection_fee = 450;

//Advance Income Tax Fee Calculation
$ait_fee = 3000;

//Digital Registration Certificate(it's called Blue book)
$DRC_tarrif = 100;
$DRC_Price_BMTF = 440;
$DRC_Price_BRTA = $DRC_tarrif + $DRC_Price_BMTF;

//Retro Reflective number plate price 
$np_tarrif = 848;
$np_price_BMTF = 3652;
$np_price_BRTA = $np_price_BMTF + $np_tarrif;

// Inspection Fee 
$inspection_fee = 450;

//Fitness fee for ten years 
$fitness_fee=450;		

// label Fee 
$label_fee = 45; 

//Function for Vat Calculation
function vat_cal($vat_value){
	global $vat_rate;
	$vat_cal= $vat_value * $vat_rate;
	$vat= ceil($vat_cal);
	
	return $vat;
}


?>



    
<?php	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
				
	// registration Fee only 
	$reg_fee = 	reg_cal($threewheeler_cc);
	$reg_vat = vat_cal($reg_fee);
	$reg_total = $reg_fee + $reg_vat;
	
	// Digital Registration Certificate 
	$DRC_fee = $DRC_Price_BRTA;
	$DRC_vat = vat_cal($DRC_tarrif);
	$DRC_total = $DRC_fee + $DRC_vat;
	
	// Number Plate Fee Calculation 
	$NP_fee = $np_price_BRTA;
	$NP_fee_vat = vat_cal($np_tarrif);
	$NP_fee_total = $NP_fee + $NP_fee_vat;
	
	//Tax Token Fee calculation 
	$road_tax = tax_token_cal($seat_no);
	$road_tax_vat = vat_cal($road_tax);
	$road_tax_total = $road_tax + $road_tax_vat;
	
	// Inspection Fee Calculation 
	$insp_fee = $inspection_fee;
	$insp_fee_vat = vat_cal($insp_fee);
	$insp_fee_total = $insp_fee + $insp_fee_vat;
	
	// Fitness Fee Calculation 
	$ft_fee = $fitness_fee;
	$ft_fee_vat =  vat_cal($ft_fee);
	$ft_fee_total = $ft_fee + $ft_fee_vat;
	
	// Advance Income Tax is not changeing.
	
	
	//Leber Fee Calculation 
	$label_fee = $label_fee;
	$label_fee_vat = vat_cal($label_fee);
	$label_fee_total = $label_fee + $label_fee_vat;
	
	//total without VAT
		$total_without_vat =	$reg_fee 
								+ $DRC_fee 
								+ $NP_fee 
								+ $road_tax 
								+ $insp_fee 
								+ $ft_fee 
								+ $ait_fee 
								+ $label_fee 
								+ $label_fee;
	
	// Total Vat 
		$total_vat = 	$reg_vat 
						+ $DRC_vat 
						+ $NP_fee_vat 
						+ $road_tax_vat 
						+ $insp_fee_vat 
						+ $ft_fee_vat 
						+ $label_fee_vat 
						+ $label_fee_vat;

	// Grand Total including VAT
	$grand_total = $total_without_vat + $total_vat;
	
	
?>
<div class="threewheeler_output_area">
	<div class="container threewheeler_output">
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<table class="table table-condensed">
					<tr class="active">
						<th>Name of Fee Item</th>
						<th class="text-right">Main Fee(TK.)</th>
						<th class="text-right">Vat(TK.)</th>
						<th class="text-right">Total(TK.)</th>
					</tr>
					<tr class="success">
						<td class="left_td">Registration Fee</td>
						<td><?php echo $reg_fee;?></td>
						<td><?php echo $reg_vat;?></td>
						<td><?php echo $reg_total;?></td>
					</tr>
					<tr class="danger">
						<td class="left_td">Inspection Fee</td>
						<td><?php echo $insp_fee;?></td>
						<td><?php echo $insp_fee_vat;?></td>
						<td><?php echo $insp_fee_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Road Tax Fee</td>
						<td><?php echo $road_tax ;?></td>
						<td><?php echo $road_tax_vat ;?></td>
						<td><?php echo $road_tax_total ;?></td>
					</tr>
					<tr class="danger">
						<td class="left_td"> Label for Road Tax </td>
						<td> <?php echo $label_fee; ?> </td>
						<td> <?php echo $label_fee_vat; ?> </td>
						<td> <?php echo $label_fee_total; ?> </td>
					</tr>
					<tr class="success">
						<td class="left_td">Fitness Fee</td>
						<td><?php echo $ft_fee ;?></td>
						<td><?php echo $ft_fee_vat ;?></td>
						<td><?php echo $ft_fee_total ;?></td>
					</tr>
					<tr class="danger">
						<td class="left_td">Label for Fitness</td>
						<td><?php echo $label_fee ;?></td>
						<td><?php echo $label_fee_vat ;?></td>
						<td><?php echo $label_fee_total ;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Advance Income Tax</td>
						<td><?php echo $ait_fee ;?></td>
						<td><?php echo "N/A" ;?></td>
						<td><?php echo $ait_fee ;?></td>
					</tr>
					<tr class="danger">
						<td class="left_td">Retro-Reflective Number Plate with RFID Tag</td>
						<td><?php echo $NP_fee ;?></td>
						<td><?php echo $NP_fee_vat ;?></td>
						<td><?php echo $NP_fee_total ;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Digital Registration Certificate</td>
						<td><?php echo $DRC_fee ;?></td>
						<td><?php echo $DRC_vat ;?></td>
						<td><?php echo $DRC_total ;?></td>
					</tr>
					<tr class="last_tr">
						<td class="left_td">Grand Total</td>
						<td><?php echo $total_without_vat;?></td>
						<td><?php echo $total_vat;?></td>
						<td><?php echo $grand_total;?></td>
					</tr>
				</table>
			</div>
			<div class="col-lg-3"></div>
		</div>
	</div>
</div>					

<?php				
			}
		else{}
?>



<?php require('../../footer.php');?>

