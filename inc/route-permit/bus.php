<?php require('../../header.php');?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$bus_cc = $_POST['bus_cc'];
	$seat_no = $_POST['seat_no'];
	$car_type = $_POST['car_type'];
	$car_situation = $_POST['car_situation'];
}
else{
	$bus_cc = "";
	$seat_no = "";
	$car_type = "hire";
	$car_situation = "ac";
}
?>
<div class="bus_input_area">
	<div class="container bus_input">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="first">Fee Calculation for BUS</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<form id="bus_form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Bus</div>
							<input type="number" min="500" max="4000" name="bus_cc" <?php if($bus_cc == ""){}else{echo "value=".$bus_cc;}?> placeholder="Enter Your Bus CC" class="form-control" id="" />
							<div class="input-group-addon">CC</div>
						</div><br />
						<div class="input-group">
							<div class="input-group-addon">BUS</div>
							<input type="number" min="40" max="80" name="seat_no" <?php if($seat_no == ""){}else{echo "value=".$seat_no;}?> class="form-control" id="" placeholder="Enter your BUS seat">
							<div class="input-group-addon">seat</div>
						</div>
						<div class="input-group">
							<input id="hire" type="radio" name="car_type" value="hire" <?php if($car_type =="hire"){echo "checked";}?> /> 
							<label for="hire">Hire</label>
							<input id="non_hire" type="radio" name="car_type" value="non_hire" <?php if($car_type =="non_hire"){echo "checked";}?> /> 
							<label for="non_hire">Non-Hire</label>
						</div>
						<div class="input-group">
							<input id="ac" type="radio" name="car_situation" value="ac" <?php if($car_situation =="ac"){echo "checked";}?> /> 
							<label for="ac">AC</label>
							<input id="non_ac" type="radio" name="car_situation" value="non_ac" <?php if($car_situation =="non_ac"){echo "checked";}?> /> 
							<label for="non_ac">Non-AC</label>
						</div>
						<input type="submit" class="btn btn-primary" value="Calculate" />
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
function reg_non_hire_cal($bus_cc){
	if($bus_cc <=600){ $reg_non_hire_fee = 7000;}
	else if($bus_cc <=1000){ $reg_non_hire_fee = 14000;}
	else if($bus_cc <=1400){ $reg_non_hire_fee = 21000;}
	else if($bus_cc <=2000){ $reg_non_hire_fee = 49000;}
	else if($bus_cc > 2000){ $reg_non_hire_fee = 70000;}
	else { $reg_non_hire_fee = "";}
	
	return $reg_non_hire_fee;
}

//Function for Registration Fee for Non-Hire Calculation
function reg_hire_cal($seat_no){
	if($seat_no <= 31){ $reg_hire_fee = 4600;}
	else if($seat_no <= 52){ $reg_hire_fee = 13800;}
	else if($seat_no > 52){ $reg_hire_fee = 17250;}
	else { $reg_hire_fee = "";}
	
	return $reg_hire_fee;
}

//Function For Road Tax Non-Hire  Fee Calculation
function tax_token_non_hire_cal($seat_no){
	if($seat_no <= 2){$tax_token_non_hire_fee = 2500;}
	else if($seat_no <= 3){$tax_token_non_hire_fee = 3500;}
	else if($seat_no <= 4){$tax_token_non_hire_fee = 5000;}
	else if($seat_no > 4){ $xtra = $seat_no - 4;
							$xtra_fee = $xtra * 500;
							$tax_token_non_hire_fee = 5000 + $xtra_fee;}
	else{$tax_token_non_hire_fee = "";}
	return $tax_token_non_hire_fee;
}

//Function For Road Tax Hire  Fee Calculation
function tax_token_hire_cal($seat_no){
	if($seat_no <= 4){$tax_token_hire_fee = 3000;}
	else if($seat_no <= 15){$tax_token_hire_fee = 6000;}
	else if($seat_no <= 30){$tax_token_hire_fee = 7200;}
	else if($seat_no > 30){$tax_token_hire_fee = 9000;}
	else{$tax_token_hire_fee = "";}
	
	return $tax_token_hire_fee;
}

// Advance Income Tax Fee Calculation for Ac bus
$ait_ac_fee = 30000;
// Advance Income Tax Fee Calculation for Non-Ac bus
function ait_non_ac_cal($seat_no){
	if($seat_no <= 52){$ait_fee = 9000;}
	else if($seat_no > 52){$ait_fee = 12500;}
	else{$ait_fee = "";}
	
	return $ait_fee;
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

// Fitness fee
$fitness_fee = 900;

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
if($_SERVER["REQUEST_METHOD"] == "POST"){
//Registration Hire Fee Calculation	
$reg_hire_fee = reg_hire_cal($seat_no);
$reg_hire_vat = vat_cal($reg_hire_fee);
$reg_hire_total = $reg_hire_fee + $reg_hire_vat;

//Registration Non-Hire Fee Calculation	
$reg_non_hire_fee = reg_non_hire_cal($bus_cc);
$reg_non_hire_vat = vat_cal($reg_non_hire_fee);
$reg_non_hire_total = $reg_non_hire_fee + $reg_non_hire_vat;

//Inspection Fee Calculation
$inspection_fee = $inspection_fee;
$inspection_vat = vat_cal($inspection_fee);
$inspection_total = $inspection_fee + $inspection_vat;

//Road Tax Hire Fee Calculation
$tax_token_hire_fee= tax_token_hire_cal($seat_no);
$tax_token_hire_vat= vat_cal($tax_token_hire_fee);
$tax_token_hire_total= $tax_token_hire_fee + $tax_token_hire_vat;

//Road Tax Non-Hire Fee Calculation
$tax_token_non_hire_fee= tax_token_non_hire_cal($seat_no);
$tax_token_non_hire_vat= vat_cal($tax_token_non_hire_fee);
$tax_token_non_hire_total= $tax_token_non_hire_fee + $tax_token_non_hire_vat;

//Fitness Fee Calculation
$fitness_fee = $fitness_fee;
$fitness_vat = vat_cal($fitness_fee);
$fitness_total = $fitness_fee + $fitness_vat;

//Advance Income Tax Fee Calculation for Ac
$ait_ac_fee = $ait_ac_fee;
$ait_ac_total = $ait_ac_fee;

//Advance Income Tax Fee Calculation for Non-Ac
$ait_non_ac_fee = ait_non_ac_cal($seat_no);
$ait_non_ac_total = $ait_non_ac_fee;

//Retro-Reflective Number Plate Fee Calculation
$np_fee = $np_price_BRTA ;
$np_vat = vat_cal($np_tarrif);
$np_total = $np_fee + $np_vat;

//Digital Registration Cirtificate Fee Calculation
$DRC_fee = $DRC_Price_BRTA;
$DRC_vat = vat_cal($DRC_tarrif);
$DRC_total = $DRC_fee + $DRC_vat;

//Label Fee Calculation
$label_fee = $label_fee;
$label_vat = vat_cal($label_fee);
$label_total = $label_fee + $label_vat;



if($car_type == "hire") {
	
		if($car_situation == "ac"){
		//total without VAT
		$total_without_vat = $reg_hire_fee
							+$tax_token_hire_fee
							+$ait_ac_fee
							+$DRC_fee
							+$np_fee
							+$inspection_fee
							+$fitness_fee
							+$label_fee
							+$label_fee;

			// Total Vat 
			$total_vat = $reg_hire_vat 
						+$tax_token_hire_vat
						+$DRC_vat
						+$np_vat
						+$inspection_vat
						+$fitness_vat
						+$label_vat
						+$label_vat	;
		}else{
			//total without VAT
			$total_without_vat = $reg_hire_fee 
								+$tax_token_hire_fee
								+$ait_non_ac_fee
								+$DRC_fee
								+$np_fee
								+$inspection_fee
								+$fitness_fee
								+$label_fee
								+$label_fee;

			// Total Vat 
			$total_vat = $reg_hire_vat 
						+$tax_token_hire_vat
						+$DRC_vat
						+$np_vat
						+$inspection_vat
						+$fitness_vat
						+$label_vat
						+$label_vat;
		}

	}
else{
		if($car_situation == "ac"){
		//total without VAT
		$total_without_vat = $reg_non_hire_fee
							+$tax_token_non_hire_fee
							+$ait_ac_fee
							+$DRC_fee
							+$np_fee
							+$inspection_fee
							+$fitness_fee
							+$label_fee
							+$label_fee;

			// Total Vat 
			$total_vat = $reg_non_hire_vat 
						+$tax_token_non_hire_vat
						+$DRC_vat
						+$np_vat
						+$inspection_vat
						+$fitness_vat
						+$label_vat
						+$label_vat	;
		}else{
			//total without VAT
			$total_without_vat = $reg_non_hire_fee 
								+$tax_token_non_hire_fee
								+$ait_non_ac_fee
								+$DRC_fee
								+$np_fee
								+$inspection_fee
								+$fitness_fee
								+$label_fee
								+$label_fee;

			// Total Vat 
			$total_vat = $reg_non_hire_vat 
						+$tax_token_non_hire_vat
						+$DRC_vat
						+$np_vat
						+$inspection_vat
						+$fitness_vat
						+$label_vat
						+$label_vat;
		}
	}

// Grand Total including VAT
$grand_total = $total_without_vat + $total_vat;


?>

<div class="bus_output_area">
	<div class="container bus_output">
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
					<?php if ($car_type == "hire"){?>
					<tr class="success">
						<td class="left_td">Registration Fee</td>
						<td><?php echo $reg_hire_fee;?></td>
						<td><?php echo $reg_hire_vat;?></td>
						<td><?php echo $reg_hire_total;?></td>
					</tr>
					<?php } else if($car_type =="non_hire"){?>
					<tr class="success">
						<td class="left_td">Registration Fee</td>
						<td><?php echo $reg_non_hire_fee;?></td>
						<td><?php echo $reg_non_hire_vat;?></td>
						<td><?php echo $reg_non_hire_total;?></td>
					</tr>
					<?php } else{?>
					<?php } ?>
					<tr class="danger">
						<td class="left_td">Inspection Fee</td>
						<td><?php echo $inspection_fee;?></td>
						<td><?php echo $inspection_vat;?></td>
						<td><?php echo $inspection_total;?></td>
					</tr>
					<?php if ($car_type == "hire"){?>
					<tr class="success">
						<td class="left_td">Road Tax Fee</td>
						<td><?php echo $tax_token_hire_fee;?></td>
						<td><?php echo $tax_token_hire_vat;?></td>
						<td><?php echo $tax_token_hire_total;?></td>
					</tr>
					<?php } else if($car_type =="non_hire"){?>
					<tr class="success">
						<td class="left_td">Road Tax Fee</td>
						<td><?php echo $tax_token_non_hire_fee;?></td>
						<td><?php echo $tax_token_non_hire_vat;?></td>
						<td><?php echo $tax_token_non_hire_total;?></td>
					</tr>
					<?php } else{?>
					<?php } ?>
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
					<?php if($car_situation == "ac") {?>
					<tr class="success">
						<td class="left_td">Advance Income Tax Fee</td>
						<td><?php echo $ait_ac_fee ;?></td>
						<td>N/A</td>
						<td><?php echo $ait_ac_total ;?></td>
					</tr>
					<?php } else if($car_situation == "non_ac"){?>
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
else{
	echo "Please fill the field!";
}
?>

<?php require('../../footer.php');?>