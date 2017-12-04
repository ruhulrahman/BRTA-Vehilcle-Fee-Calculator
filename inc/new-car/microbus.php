<?php require('../../header.php');?>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$microbus_cc = $_POST['cc'];
	$seat_no = $_POST['seat'];
	$car_type = $_POST['car_type'];
}
else 
{
	$microbus_cc = "";
	$seat_no = "";
	$car_type = "hire";
}
?>

<div class="microbus_area">
	<div class="container microbus">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="first">Fee Calculation for Microbus</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
				  <div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Microbus</div>
						<input type="number" min="500" max="3000" name="cc" class="form-control" <?php if($microbus_cc == ""){}else{ echo "value =".$microbus_cc;}?> id="" placeholder="Enter Your Microbus CC">
						<div class="input-group-addon">CC</div>
					</div><br />
					<div class="input-group">
						<div class="input-group-addon">Microbus</div>
						<input type="number" min="2" max="12" name="seat" <?php if($seat_no == ""){}else {echo "value =".$seat_no;}?> class="form-control" id="" placeholder="Enter Your Microbus Seat Number">
						<div class="input-group-addon">seat</div>
					</div>
					<div class="input-group">
						  <input id="hire" type="radio" name="car_type" value="hire" <?php if($car_type == "hire"){echo "checked";}?>/> 
						  <label for="hire">Hire</label>
						  <input id="non_hire" type="radio" name="car_type" value="non_hire" <?php if($car_type == "non_hire"){echo "checked";}?>/> 
						  <label for="non_hire">Non-Hire</label>
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
//VAT Rate
$vat_rate = 0.15;

//Function for Registration Fee for Non-Hire Calculation
function reg_non_hire_cal($microbus_cc){
	if($microbus_cc <=600){ $reg_non_hire_fee = 7000;}
	else if($microbus_cc <=1000){ $reg_non_hire_fee = 14000;}
	else if($microbus_cc <=1400){ $reg_non_hire_fee = 21000;}
	else if($microbus_cc <=2000){ $reg_non_hire_fee = 49000;}
	else if($microbus_cc > 2000){ $reg_non_hire_fee = 56000;}
	else { $reg_non_hire_fee = "";}
	
	return $reg_non_hire_fee;
}

//Function for Registration Fee for Hire Calculation
function reg_hire_cal($seat_no){
	if($seat_no <= 31){ $reg_hire_fee = 4600;}
	else if($seat_no <= 52){ $reg_hire_fee = 13800;}
	else if($seat_no > 52){ $reg_hire_fee = 17250;}
	else { $reg_hire_fee = "";}
	
	return $reg_hire_fee;
}

//Function for Tax Token Fee for Non-hire Calculation
function tax_token_non_hire_cal($seat_no){
	
	if($seat_no <= 2 ){ $tax_token_non_hire_fee = 2500;}
	else if($seat_no <= 3 ){ $tax_token_non_hire_fee = 3500;}
	else if($seat_no <= 4 ){ $tax_token_non_hire_fee = 5000;}
	else if($seat_no > 4 ){ $xtra_seat = $seat_no - 4;
							$xtra_fee = $xtra_seat * 500;
							$tax_token_non_hire_fee = 5000 + $xtra_fee;}
	else {$tax_token_non_hire_fee = "";}
	
	return $tax_token_non_hire_fee;
}


//Function for Tax Token Fee for Hire Calculation
function tax_token_hire_cal($seat_no){
	
	if($seat_no <= 4 ){ $tax_token_hire_fee = 3000;}
	else if($seat_no <= 6 ){ $tax_token_hire_fee = 3600;}
	else if($seat_no <= 15 ){ $tax_token_hire_fee = 6000;}
	else if($seat_no <= 30 ){ $tax_token_hire_fee = 7200;}
	else if($seat_no > 30 ){ $tax_token_hire_fee = 9000;}
	else{ $tax_token_hire_fee = "";}
	
	return $tax_token_hire_fee;
}

//Advance Income Tax Fee Calculation
$ait_fee = 20000;

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
if($_SERVER['REQUEST_METHOD'] == "POST"){

//Registration Fee for Hire Calculation
$reg_hire_fee = reg_hire_cal($seat_no);
$reg_hire_vat = vat_cal($reg_hire_fee);
$reg_hire_total = $reg_hire_fee + $reg_hire_vat;

//Registration Fee for Non-Hire Calculation
$reg_non_hire_fee = reg_non_hire_cal($microbus_cc);
$reg_non_hire_vat = vat_cal($reg_non_hire_fee);
$reg_non_hire_total = $reg_non_hire_fee + $reg_non_hire_vat;

//Tax Token Fee for Hire Calculation
$tax_token_hire_fee = tax_token_hire_cal($seat_no);
$tax_token_hire_vat = vat_cal($tax_token_hire_fee);
$tax_token_hire_total = $tax_token_hire_fee + $tax_token_hire_vat;

//Tax Token Fee for Non-hire Calculation
$tax_token_non_hire_fee = tax_token_non_hire_cal($seat_no);
$tax_token_non_hire_vat = vat_cal($tax_token_non_hire_fee);
$tax_token_non_hire_total = $tax_token_non_hire_fee + $tax_token_non_hire_vat;

//Inspection Fee Calculate
$inspection_fee = $inspection_fee;
$inspection_vat = vat_cal($inspection_fee);
$inspection_total = $inspection_fee + $inspection_vat;

//Fitness Fee Calculate
$fitness_fee = $fitness_fee;
$fitness_vat = vat_cal($fitness_fee);
$fitness_total = $fitness_fee + $fitness_vat;

//Digital Registration Cirtificate Fee Calculation
$DRC_fee = $DRC_Price_BRTA;
$DRC_vat = $DRC_tarrif * $vat_rate;
$DRC_total = $DRC_fee + $DRC_vat;

//Advance Income Tax Fee Calculation
$ait_fee = $ait_fee;
$ait_total = $ait_fee;

//Retro Reflective number plate Fee Calculate 
$np_fee = $np_price_BRTA;
$np_vat = vat_cal($np_fee);
$np_total = $np_fee + $np_vat;

//Label Fee Calculation
$label_fee = $label_fee;
$label_vat = vat_cal($label_fee);
$label_total = $label_fee + $label_vat;



if($car_type == "hire"){
//Total without Vat
$total_without_vat = $reg_hire_fee 
					+$tax_token_hire_fee
					+$ait_fee
					+$DRC_fee
					+$np_fee
					+$inspection_fee
					+$fitness_fee
					+$label_fee
					+$label_fee;
		//Total  Vat
		$total_vat = $reg_hire_vat 
					+$tax_token_hire_fee
					+$DRC_vat
					+$np_vat
					+$inspection_vat
					+$fitness_vat
					+$label_vat
					+$label_vat;
	}
else{
//Total without Vat
$total_without_vat = $reg_non_hire_fee 
					+$tax_token_non_hire_fee
					+$ait_fee
					+$DRC_fee
					+$np_fee
					+$inspection_fee
					+$fitness_fee
					+$label_fee
					+$label_fee;
		//Total  Vat
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


<div class="microbus_output_area">
	<div class="container microbus_output">
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
					<?php if($car_type == "hire") { ?>
						<tr class="success">
							<td class="left_td">Registration Fee</td>
							<td><?php echo $reg_hire_fee;?></td>
							<td><?php echo $reg_hire_vat;?></td>
							<td><?php echo $reg_hire_total;?></td>
						</tr>
					<?php } else if($car_type == "non_hire"){ ?>
						<tr class="success">
							<td class="left_td">Registration Fee</td>
							<td><?php echo $reg_non_hire_fee;?></td>
							<td><?php echo $reg_non_hire_vat;?></td>
							<td><?php echo $reg_non_hire_total;?></td>
						</tr>
					<?php } else{?>
					<?php }?>
					<tr class="danger">
						<td class="left_td">Inspection Fee</td>
						<td><?php echo $inspection_fee;?></td>
						<td><?php echo $inspection_vat;?></td>
						<td><?php echo $inspection_total;?></td>
					</tr>
					<?php if($car_type == "hire") { ?>
					<tr class="success">
						<td class="left_td">Road Tax Fee</td>
						<td><?php echo $tax_token_hire_fee ;?></td>
						<td><?php echo $tax_token_hire_vat ;?></td>
						<td><?php echo $tax_token_hire_total ;?></td>
					</tr>
					<?php } else if($car_type == "non_hire"){ ?>
					<tr class="success">
						<td class="left_td">Road Tax Fee</td>
						<td><?php echo $tax_token_non_hire_fee ;?></td>
						<td><?php echo $tax_token_non_hire_vat ;?></td>
						<td><?php echo $tax_token_non_hire_total ;?></td>
					</tr>
					<?php } else{?>
					<?php }?>
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
					<tr class="success">
						<td class="left_td">Advance Income Tax Fee</td>
						<td><?php echo $ait_fee ;?></td>
						<td>N/A</td>
						<td><?php echo $ait_total ;?></td>
					</tr>
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