<?php require('../../header.php');?>

<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		$jeep_cc= $_POST["cc"];
		$seat_no = $_POST["seat"];
	}
else
	{
		$jeep_cc= "";
		$seat_no = "";
	}
?>

<div class="jeep_input_area">
	<div class="container jeep_input">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="first">Fee Calculation for Jeep</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
				  <div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Jeep</div>
						<input type="number" min="300" max="4000" name="cc" <?php if($jeep_cc==""){ echo "please";}else{echo "value=".$jeep_cc;};?> class="form-control" id="" placeholder="Enter your Jeep CC">
						<div class="input-group-addon">CC</div>
					</div><br />
					<div class="input-group">
						<div class="input-group-addon">Jeep</div>
						<input type="number" min="2" max="12" name="seat" <?php if($seat_no==""){}else{echo "value=".$seat_no;}?> class="form-control" id="" placeholder="Enter your Jeep Seat Number">
						<div class="input-group-addon">seat</div>
					</div>
					<input type="submit" name="submite" class="btn btn-success" value="Calculate"/>
				  </div>
				</form>
			</div>
			<div class="col-lg-3"></div>
		</div>
	</div>
</div>

<?php
//Vat rate 15%.........
$vat_rate = 0.15;	

//Registraion Fee Calculation
function reg_non_hire_cal($jeep_cc){
	if($jeep_cc <=600){ $reg_fee = 7000;}
	else if($jeep_cc <=1000){ $reg_fee = 14000;}
	else if($jeep_cc <=1400){ $reg_fee = 21000;}
	else if($jeep_cc <=2000){ $reg_fee = 49000;}
	else if($jeep_cc > 2000){ $reg_fee = 98000;}
	else { $reg_fee = "";}
	
	return $reg_fee;
}

//Function For Tax Token  Fee Calculation
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
//Function For Advance Income Tax Calculation
function ait_cal($jeep_cc){
	if($jeep_cc <= 1500){$ait_fee = 15000;}
	else if($jeep_cc <= 2000){$ait_fee = 30000;}
	else if($jeep_cc <= 2500){$ait_fee = 50000;}
	else if($jeep_cc <= 3000){$ait_fee = 75000;}
	else if($jeep_cc <= 3500){$ait_fee = 100000;}
	else if($jeep_cc > 3500){$ait_fee = 125000;}
	else{$ait_fee = "";}
	
	return $ait_fee;
}

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

// Fitness 
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
if($_SERVER["REQUEST_METHOD"]=="POST")
	{
//Registration Fee Calculation
$reg_fee = reg_non_hire_cal($jeep_cc);
$reg_vat = vat_cal($reg_fee);
$reg_total = $reg_fee + $reg_vat;

//Tax Token Fee Calculation
$tax_token_fee = tax_token_cal($seat_no);
$tax_token_vat = vat_cal($tax_token_fee);
$tax_token_total = $tax_token_fee + $tax_token_vat;

//Advance Income Tax Fee Calculation
$ait_fee = ait_cal($jeep_cc);
$ait_total = $ait_fee;

//Digital Registration Fee Calculation
$DRC_fee = $DRC_Price_BRTA;
$DRC_vat = $DRC_tarrif * $vat_rate;
$DRC_total = $DRC_fee + $DRC_vat;

//Retro Reflective Number Plate Fee Calculation
$np_fee = $np_price_BRTA;
$np_vat = vat_cal($np_fee);
$np_total = $np_fee + $np_vat;

//Inspection Fee Calculation
$inspection_fee = $inspection_fee;
$inspection_vat = vat_cal($inspection_fee);
$inspection_total = $inspection_fee + $inspection_vat;

//Fitness Fee Calculation
$fitness_fee = $fitness_fee;
$fitness_vat = vat_cal($fitness_fee);
$fitness_total = $fitness_fee + $fitness_vat;

//Label Fee Calculation
$label_fee = $label_fee;
$label_vat = vat_cal($label_fee);
$label_total = $label_fee + $label_vat;



//Total without Vat
$total_without_vat = $reg_fee 
					+$tax_token_fee
					+$ait_fee
					+$DRC_fee
					+$np_fee
					+$inspection_fee
					+$fitness_fee
					+$label_fee
					+$label_fee;
//Total  Vat
$total_vat = $reg_vat 
			+$tax_token_vat
			+$DRC_vat
			+$np_vat
			+$inspection_vat
			+$fitness_vat
			+$label_vat
			+$label_vat;
					
//Grand Total 
$grand_total = $total_without_vat + $total_vat;
?>
<div class="jeep_output_area">
	<div class="container jeep_output">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<table  class="jeep_table">
				<tr>
					<th>Name of Fee Item</th>
					<th>Main Fee (Taka)</th>
					<th>VAT (Taka)</th>
					<th>Total (Taka)</th>
				</tr>
				<tr>
					<td class="left_td">Registration Fee</td>
					<td><?php echo $reg_fee ;?></td>
					<td><?php echo $reg_vat ;?></td>
					<td><?php echo $reg_total ;?></td>
				</tr>
				<tr>
					<td class="left_td">Inspection Fee</td>
					<td><?php echo $inspection_fee ;?></td>
					<td><?php echo $inspection_vat ;?></td>
					<td><?php echo $inspection_total ;?></td>
				</tr>
				<tr>
					<td class="left_td">Road Tax Fee</td>
					<td><?php echo $tax_token_fee ;?></td>
					<td><?php echo $tax_token_vat ;?></td>
					<td><?php echo $tax_token_total ;?></td>
				</tr>
				<tr>
					<td class="left_td">Label for Road Tax</td>
					<td><?php echo $label_fee ;?></td>
					<td><?php echo $label_vat ;?></td>
					<td><?php echo $label_total ;?></td>
				</tr>
				<tr>
					<td class="left_td">Fitness Fee</td>
					<td><?php echo $fitness_fee ;?></td>
					<td><?php echo $fitness_vat ;?></td>
					<td><?php echo $fitness_total ;?></td>
				</tr>
				<tr>
					<td class="left_td">Label for Fitness</td>
					<td><?php echo $label_fee ;?></td>
					<td><?php echo $label_vat ;?></td>
					<td><?php echo $label_total ;?></td>
				</tr>
				<tr>
					<td class="left_td">Advance Income Tax</td>
					<td><?php echo $ait_fee ;?></td>
					<td>N/A</td>
					<td><?php echo $ait_total ;?></td>
				</tr>
				<tr>
					<td class="left_td">Retro Reflective Number Plate</td>
					<td><?php echo $np_fee ;?></td>
					<td><?php echo $np_vat ;?></td>
					<td><?php echo $np_total ;?></td>
				</tr>
				<tr>
					<td class="left_td">Digital Registration Cirtificate</td>
					<td><?php echo $DRC_fee ;?></td>
					<td><?php echo $DRC_vat ;?></td>
					<td><?php echo $DRC_total ;?></td>
				</tr>
				<tr class="total">
					<td>Grand Total</td>
					<td><?php echo $total_without_vat ;?></td>
					<td><?php echo $total_vat ;?></td>
					<td><?php echo $grand_total ;?></td>
				</tr>
			</table>
		</div>
		<div class="col-lg-3"></div>
	</div>
</div>
<?php
	}
else{
	echo "";
}
?>

<?php require('../../footer.php');?>