<?php require('../../header.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$taxicab_cc = $_POST["taxicab_cc"];
		$seat_no = $_POST["seat_no"];
		$car_type = $_POST["car_type"];
	}
else{
		$taxicab_cc = "";
		$seat_no = "";
		$car_type = "ac";
	}

?>
<div class="taxicab_input_area">
	<div class="container taxicab_input">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="first">Fee Calculation for Taxi Cab</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<form id="taxicab_form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
				  <div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Taxi Cab</div>
						<input type="number" min="500" max="3000" name="taxicab_cc" <?php if($taxicab_cc ==""){}else{echo "value=".$taxicab_cc;}?> class="form-control" id="" placeholder="Enter your taxi cab CC">
						<div class="input-group-addon">CC</div>
					</div><br />
					<div class="input-group">
						<div class="input-group-addon">Taxi Cab</div>
						<input type="number" min="2" max="4" name="seat_no" <?php if($seat_no ==""){}else{echo "value=".$seat_no;}?> class="form-control" id="" placeholder="Enter your taxi cab seat">
						<div class="input-group-addon">seat</div>
					</div>
					<div class="input-group">
						  <input id="ac" type="radio" name="car_type" value="ac" <?php if($car_type =="ac"){echo "checked";}?> /> 
						  <label for="ac">AC</label>
						  <input id="non_ac" type="radio" name="car_type" value="non_ac" <?php if($car_type =="non_ac"){echo "checked";}?> /> 
						  <label for="non_ac">Non-AC</label>
					</div>
					<input type="submit" name="submit" class="btn btn-primary" value="Calculate"/>
				  </div>
				 </form>
			</div>
			<div class="col-lg-3"></div>
		</div>
	</div>
</div>
<?php
//VAT Rate
$vat_rate = 0.15;

//Function for Registraion Fee Calculation
function reg_cal($taxicab_cc){
	if($taxicab_cc <=600){ $reg_fee = 7000;}
	else if($taxicab_cc <=1000){ $reg_fee = 14000;}
	else if($taxicab_cc <=1400){ $reg_fee = 21000;}
	else if($taxicab_cc <=2000){ $reg_fee = 49000;}
	else if($taxicab_cc > 2000){ $reg_fee = 98000;}
	else { $reg_fee = "";}
	
	return $reg_fee;
}

//Funciton for Road Tax Fee Calculation
function tax_token_cal($seat_no){
	if($seat_no <= 2){$tax_token_fee = 2500;}
	else if($seat_no <= 3){$tax_token_fee = 3500;}
	else if($seat_no <= 4){$tax_token_fee = 5000;}
	else if($seat_no > 4){ $xtra = $seat_no - 4;
							$xtra_fee = $xtra * 500;
							$tax_token_fee = 5000 + $xtra_fee;}
	else{$tax_token_fee = "";}
	return $tax_token_fee;
}

//Digital Registration Certificate
$DRC_tarrif = 100;
$DRC_Price_BMTF = 440;
$DRC_Price_BRTA = $DRC_tarrif + $DRC_Price_BMTF;

//Retro Reflective number plate price 
$np_tarrif = 848;
$np_price_BMTF = 3652;
$np_price_BRTA = $np_price_BMTF + $np_tarrif;

// Inspection Fee 
$inspectionection_fee = 450;

// Advance Income Tax 
$ait_fee_ac = 9000;
$ait_fee_non_ac = 3000;
 
// Fitness fee
$fitness_fee = 450;

// label Fee 
$label_fee = 45; // Leble fee for Tax token, Route Peirmit and Advance Income tax

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
	$reg_fee = 	reg_cal($taxicab_cc);
	$reg_vat = vat_cal($reg_fee);
	$reg_total = $reg_fee + $reg_vat;
	
	//Road Tax Fee Calculation
	$tax_token_fee = tax_token_cal($seat_no);
	$tax_token_vat = vat_cal($tax_token_fee);
	$tax_token_total = $tax_token_fee + $tax_token_vat;
	
	//Advance Income Tax Fee Calculatin for Ac
	$ait_ac_fee = $ait_fee_ac;
	$ait_ac_total = $ait_ac_fee;
	
	//Advance Income Tax Fee Calculatin for Non-Ac
	$ait_non_ac_fee = $ait_fee_non_ac;
	$ait_non_ac_total = $ait_non_ac_fee;
	
	
	// Digital Registration Certificate 
	$DRC_fee = $DRC_Price_BRTA;
	$DRC_vat = vat_cal($DRC_tarrif);
	$DRC_total = $DRC_fee + $DRC_vat;
	
	// Number Plate Fee Calculation 
	$np_fee = $np_price_BRTA;
	$np_vat = vat_cal($np_tarrif);
	$np_total = $np_fee + $np_vat;
	
	
	// Inspection Fee Calculation 
	$inspection_fee = $inspectionection_fee;
	$inspection_vat = vat_cal($inspection_fee);
	$inspection_total = $inspection_fee + $inspection_vat;
	
	// Fitness Fee Calculation 
	$fitness_fee = $fitness_fee;
	$fitness_vat =  vat_cal($fitness_fee);
	$fitness_total = $fitness_fee + $fitness_vat;
	
	
	//Leber Fee Calculation 
	$label_fee = $label_fee;
	$label_vat = vat_cal($label_fee);
	$label_total = $label_fee + $label_vat;
	
	

	if($car_type == "ac") {
		//total without VAT
		$total_without_vat = $reg_fee 
							+$tax_token_fee
							+$ait_ac_fee
							+$DRC_fee
							+$np_fee
							+$inspection_fee
							+$fitness_fee
							+$label_fee
							+$label_fee;
	
	// Total Vat 
		$total_vat = $reg_vat 
					+$tax_token_vat
					+$DRC_vat
					+$np_vat
					+$inspection_vat
					+$fitness_vat
					+$label_vat
					+$label_vat	;
		}
		else {
		//total without VAT
			$total_without_vat = $reg_fee 
								+$tax_token_fee
								+$ait_non_ac_fee
								+$DRC_fee
								+$np_fee
								+$inspection_fee
								+$fitness_fee
								+$label_fee
								+$label_fee;

	// Total Vat 
		$total_vat = $reg_vat 
					+$tax_token_vat
					+$DRC_vat
					+$np_vat
					+$inspection_vat
					+$fitness_vat
					+$label_vat
					+$label_vat;
		}
	// Grand Total including VAT
	$grand_total = $total_without_vat + $total_vat;
?>
<div class="taxicab_output_area">
	<div class="container taxicab_output">
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
						<td><?php echo $inspection_fee;?></td>
						<td><?php echo $inspection_vat;?></td>
						<td><?php echo $inspection_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Road Tax Fee</td>
						<td><?php echo $tax_token_fee ;?></td>
						<td><?php echo $tax_token_vat ;?></td>
						<td><?php echo $tax_token_total ;?></td>
					</tr>
					<tr class="danger">
						<td class="left_td">Label for Road Tax</td>
						<td><?php echo $label_fee;?></td>
						<td><?php echo $label_vat;?></td>
						<td><?php echo $label_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Fitness Fee</td>
						<td><?php echo $fitness_fee ;?></td>
						<td><?php echo $fitness_vat ;?></td>
						<td><?php echo $fitness_total ;?></td>
					</tr>
					<tr class="danger">
						<td class="left_td">Label for Fitness</td>
						<td><?php echo $label_fee;?></td>
						<td><?php echo $label_vat;?></td>
						<td><?php echo $label_total;?></td>
					</tr>
					<?php if($car_type == "ac") {?>
					<tr class="success">
						<td class="left_td">Advance Income Tax Fee</td>
						<td><?php echo $ait_ac_fee ;?></td>
						<td>N/A</td>
						<td><?php echo $ait_ac_total ;?></td>
					</tr>
					<?php } else if($car_type == "non_ac"){?>
					<tr class="success">
						<td class="left_td">Advance Income Tax Fee</td>
						<td><?php echo $ait_non_ac_fee ;?></td>
						<td>N/A</td>
						<td><?php echo $ait_non_ac_total ;?></td>
					</tr>
					<?php } else{?>
					<?php }?>
					<tr class="danger">
						<td class="left_td">Retro Reflective number plate</td>
						<td><?php echo $np_fee;?></td>
						<td><?php echo $np_vat;?></td>
						<td><?php echo $np_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Digital Registration Cirtificate</td>
						<td><?php echo $DRC_fee;?></td>
						<td><?php echo $DRC_vat;?></td>
						<td><?php echo $DRC_total;?></td>
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
else
{
	echo "Please fill the field!";
}
?>


<?php require('../../footer.php');?>