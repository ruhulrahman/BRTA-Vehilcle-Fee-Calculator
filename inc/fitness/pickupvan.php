<?php require('../../header.php');?>


<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$car_weight = $_POST["weight"];
		$car_type = $_POST["car_type"];
	}
else
	{
		$car_weight = "";
		$car_type = "hire";
	}
?>

<div class="pickupvan_area">
	<div class="container pickupvan">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="first">Pickup Van Total Fee</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<form id="pickup_form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
				  <div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Pickup Van Weight</div>
						<input type="number" min="1000" max="15000" name="weight" <?php if($car_weight =="") {} else echo "value = ". $car_weight; ?> class="form-control" id="" placeholder="Enter your Pickup van weight">
						<div class="input-group-addon">Kg.</div>
					</div>
					<div class="input-group">
						  <input id="hire" type="radio" name="car_type" value="hire" <?php if($car_type == "hire"){echo "checked";}?>/> 
						  <label for="hire">Hire</label>
						  <input id="non_hire" type="radio" name="car_type" value="non_hire" <?php if($car_type == "non_hire"){echo "checked";}?>/> 
						  <label for="non_hire">Non-Hire</label>
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

//Function for Registration Fee for Non-Hire Calculation
function reg_non_hire_cal($car_weight){
	if($car_weight <= 3500){$reg_fee = 28000;}
	else if($car_weight <= 7500){$reg_fee = 56000;}
	else if($car_weight <= 12500){$reg_fee = 70000;}
	else if($car_weight > 12500){$reg_fee = 77000;}
	else{$reg_fee = "";}
	
	return $reg_fee;
}

//Function for Registration Fee for Hire Calculation
function reg_hire_cal($car_weight){
	if($car_weight <= 3500){$reg_hire_fee = 4600;}
	else if($car_weight <= 7500){$reg_hire_fee = 13800;}
	else if($car_weight <= 12500){$reg_hire_fee = 17250;}
	else if($car_weight > 12500){$reg_hire_fee = 23000;}
	else{$reg_hire_fee = "";}
	
	return $reg_hire_fee;
}


//Function for Advance Income Tax Calculation
function ait_cal($car_weight){
	if($car_weight < 1500){$ait_fee = 3000;}
	else if($car_weight > 1500){$ait_fee = 7500;}
	else{$ait_fee = "";}
	
	return $ait_fee;
}

//Function for Tax Token Hire Calculation(With Goods)
function tax_token_hire_cal($car_weight){
	if($car_weight <= 3500){$tax_token_hire_fee = 2000;}
	else if($car_weight <= 7500){
								$xtra_weight = $car_weight - 3500;
								$xtra_per_500_kg = $xtra_weight / 500;
								$extra_fee_per_500_kg = $xtra_per_500_kg * 200;
								$tax_token_hire_fee = 2000 + $extra_fee_per_500_kg;
								return $tax_token_hire_fee;
	}
	else if($car_weight <= 12500){
								$xtra_weight = $car_weight - 7500;
								$xtra_per_500_kg = $xtra_weight / 500;
								$extra_fee_per_500_kg = $xtra_per_500_kg * 500;
								$tax_token_hire_fee = 3800 + $extra_fee_per_500_kg;
								return $tax_token_hire_fee;
	}
	else if($car_weight > 12500){
								$xtra_weight = $car_weight - 12500;
								$xtra_per_500_kg = $xtra_weight / 500;
								$extra_fee_per_500_kg = $xtra_per_500_kg * 500;
								$tax_token_hire_fee = 8500 + $extra_fee_per_500_kg;
								return $tax_token_hire_fee;
	}
	else{$tax_token_fee = "";}
	
	return $tax_token_hire_fee;
}

//Function for Tax Token Non-Hire Calculation(With Goods)
function tax_token_non_hire_cal($car_weight){
	if($car_weight <= 3500){$tax_token_fee = 3500;}
	else if($car_weight <= 7500){								
								$xtra_weight = $car_weight - 3500;
								$xtra_per_500_kg = $xtra_weight / 500;
								$extra_fee_per_500_kg = $xtra_per_500_kg * 500;
								$tax_token_hire_fee = 3500 + $extra_fee_per_500_kg;
								return $tax_token_hire_fee;
	}
	else if($car_weight <= 12500){
								$xtra_weight = $car_weight - 7500;
								$xtra_per_500_kg = $xtra_weight / 500;
								$extra_fee_per_500_kg = $xtra_per_500_kg * 1100;
								$tax_token_hire_fee = 7000 + $extra_fee_per_500_kg;
								return $tax_token_hire_fee;
	}
	else if($car_weight > 12500){
								$xtra_weight = $car_weight - 12500;
								$xtra_per_500_kg = $xtra_weight / 500;
								$extra_fee_per_500_kg = $xtra_per_500_kg * 1200;
								$tax_token_hire_fee = 17500 + $extra_fee_per_500_kg;
								return $tax_token_hire_fee;}
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
$inspection_fee = 450;

// Fitness  Calculation
$fitness_fee=450;		//Fitness fee for ten years

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
if($_SERVER["REQUEST_METHOD"] == "POST")
	{

//Fee Calculation.............................................................................
//Registration Fee for Hire Calculation
$reg_hire_fee = reg_hire_cal($car_weight, $car_type);
$reg_hire_vat = vat_cal($reg_hire_fee);
$reg_hire_total = $reg_hire_fee + $reg_hire_vat;

//Registration Fee for Non-Hire Calculation
$reg_fee = reg_non_hire_cal($car_weight, $car_type);
$reg_non_hire_vat = vat_cal($reg_fee);
$reg_non_hire_total = $reg_fee + $reg_non_hire_vat;

//Tax Token Fee for Hire Calculation
$tax_token_hire_fee = tax_token_hire_cal($car_weight, $car_type);
$tax_token_hire_vat = vat_cal($tax_token_hire_fee);
$tax_token_hire_total = $tax_token_hire_fee + $tax_token_hire_vat;

//Tax Token Fee for Non-Hire Calculation
$tax_token_fee = tax_token_non_hire_cal($car_weight, $car_type);
$tax_token_non_hire_vat = vat_cal($tax_token_fee);
$tax_token_non_hire_total = $tax_token_fee + $tax_token_non_hire_vat;

//Route Permit Fee Calculation
$route_permit_fee=5205;
$route_permit_vat= vat_cal($route_permit_fee);
$route_permit_total = $route_permit_fee + $route_permit_vat;

//Advance Income Tax Calculation
$ait_fee = ait_cal($car_weight);
$ait_total = $ait_fee;

//Digital Registration Certificate Calculation
$DRC_fee = $DRC_Price_BRTA;
$DRC_vat = $DRC_tarrif * $vat_rate;
$DRC_total = $DRC_fee + $DRC_vat;

//Retro Reflective number plate fee Calculation 
$np_fee = $np_price_BRTA;
$np_vat = $np_fee * $vat_rate;
$np_total = $np_fee + $np_vat;

// Inspection Fee Calculation
$inspection_fee;
$inspection_vat = vat_cal($inspection_fee);
$inspection_total = $inspection_fee + $inspection_vat;

// Fitness fee Calculation
$fitness_fee;
$fitness_vat = vat_cal($fitness_fee);
$fitness_total = $fitness_fee + $fitness_vat;

// label Fee Calculation
$label_fee;
$label_vat = vat_cal($label_fee);
$label_total = $label_fee + $label_vat;

	
	if($car_type == "hire"){
	//Total without VAT
	$total_without_vat = $reg_hire_fee 
						+$tax_token_hire_fee
						+$DRC_fee
						+$np_fee
						+$inspection_fee
						+$fitness_fee
						+$ait_fee
						+$label_fee
						+$label_fee;
						
	//Total Vat
	$total_vat = $reg_hire_vat
				+$tax_token_hire_vat
				+$DRC_vat
				+$np_vat
				+$inspection_vat
				+$fitness_vat
				+$label_vat
				+$label_vat;
				
	}
	else{
			//Total without VAT
	$total_without_vat = $reg_fee 
						+$tax_token_fee
						+$DRC_fee
						+$np_fee
						+$inspection_fee
						+$fitness_fee
						+$ait_fee
						+$label_fee
						+$label_fee;
						
	//Total Vat
	$total_vat = $reg_non_hire_vat
				+$tax_token_non_hire_vat
				+$DRC_vat
				+$np_vat
				+$inspection_vat
				+$fitness_vat
				+$label_vat
				+$label_vat;
	}
	//Grand Total
	$grand_total = $total_without_vat + $total_vat;


?>

<div class="pickupvan_output_area">
	<div class="container pickupvan_output">
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<table class="pickup_table">
					<tr class="active">
						<th>Name of Fee Item</th>
						<th>Main Fee(TK.)</th>
						<th>Vat(TK.)</th>
						<th>Total(TK.)</th>
					</tr>
					<?php if($car_type == "hire") { ?>
						<tr>
							<td class="left_td">Registration Fee</td>
							<td><?php echo $reg_hire_fee;?></td>
							<td><?php echo $reg_hire_vat;?></td>
							<td><?php echo $reg_hire_total;?></td>
						</tr>
					<?php } else if($car_type == "non_hire"){ ?>
						<tr>
							<td class="left_td">Registration Fee</td>
							<td><?php echo $reg_fee;?></td>
							<td><?php echo $reg_non_hire_vat;?></td>
							<td><?php echo $reg_non_hire_total;?></td>
						</tr>
					<?php } else{?>
					<?php }?>
					<tr>
						<td class="left_td">Inspection Fee</td>
						<td><?php echo $inspection_fee;?></td>
						<td><?php echo $inspection_vat;?></td>
						<td><?php echo $inspection_total;?></td>
					</tr>
					<?php if($car_type == "hire") { ?>
					<tr>
						<td class="left_td">Road Tax Fee</td>
						<td><?php echo $tax_token_hire_fee ;?></td>
						<td><?php echo $tax_token_hire_vat ;?></td>
						<td><?php echo $tax_token_hire_total ;?></td>
					</tr>
					<?php } else if($car_type == "non_hire"){ ?>
					<tr>
						<td class="left_td">Road Tax Fee</td>
						<td><?php echo $tax_token_fee ;?></td>
						<td><?php echo $tax_token_non_hire_vat ;?></td>
						<td><?php echo $tax_token_non_hire_total ;?></td>
					</tr>
					<?php } else{?>
					<?php }?>
					<tr>
						<td class="left_td">Label for Road Tax</td>
						<td><?php echo $label_fee;?></td>
						<td><?php echo $label_vat;?></td>
						<td><?php echo $label_total;?></td>
					</tr>
					<tr>
						<td class="left_td">Fitness Fee</td>
						<td><?php echo $fitness_fee ;?></td>
						<td><?php echo $fitness_vat ;?></td>
						<td><?php echo $fitness_total ;?></td>
					</tr>
					<tr>
						<td class="left_td">Label for Fitness</td>
						<td><?php echo $label_fee;?></td>
						<td><?php echo $label_vat;?></td>
						<td><?php echo $label_total;?></td>
					</tr>
					<tr>
						<td class="left_td">Advance Income Tax Fee</td>
						<td><?php echo $ait_fee ;?></td>
						<td>N/A</td>
						<td><?php echo $ait_total ;?></td>
					</tr>
					<tr>
						<td class="left_td">Retro Reflective number plate</td>
						<td><?php echo $np_fee;?></td>
						<td><?php echo $np_vat;?></td>
						<td><?php echo $np_total;?></td>
					</tr>
					<tr>
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
else{
	echo "";
}
?>

<?php require('../../footer.php');?>