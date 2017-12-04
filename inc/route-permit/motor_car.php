<?php require('../../header.php');?>


<?php	
if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			$car_ccv = $_POST["three_cc"];
			$car_seat = $_POST["seat"];
			$vstatus = $_POST["vstatus"];
			$mfg_year = $_POST["mfg_year"];
		}
	else {
			$car_ccv = "";
			$car_seat = "";
			$vstatus = "new";
			$mfg_year = "";
		}

?>
<div class="motor_car_area">
	<div class="container motor_car">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="first">Fee Calculation for Motor Car</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
				  <div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Engine Capacity</div>
						<input type="number" name="three_cc" min = "500" max= "5000"  <?php if($car_ccv =="") { echo "placeholder='Enter CC'";} else echo "value = ". $car_ccv; ?> required class="form-control" id="" placeholder="Enter Your Motor car CC"/>
						<div class="input-group-addon">CC</div>
					</div><br />
					<div class="input-group">
						<div class="input-group-addon">Motor car</div>
						<input type="number" name="seat"min = "4" max= "20" <?php if($car_seat == "") { echo "placeholder='No. of Seat'";} else echo "value = ". $car_seat; ?> required class="form-control" id="" placeholder="Enter Your Motor Car Seat Number"/>
						<div class="input-group-addon">seat</div>
					</div><br />
					<div class="input-group">
						<div class="input-group-addon">Manufacturing Year</div>
						<input type="number" name="mfg_year" max="<?php $max_year; ?>" min= "<?php $min_year; ?>" <?php if($mfg_year == ""){} else echo "value = ". $mfg_year; ?> required class="form-control" id="" placeholder="Enter Your Motor Car Manufacturing Year"/>
						<div class="input-group-addon">Christian Era</div>
					</div>
					<div class="input-group">
						  <input id="new" type="radio" name="vstatus" value="new" <?php if($vstatus == 'new') { echo 'checked';} ?>/> 
						  <label for="new">New</label>
						  <input id="recondition" type="radio" name="vstatus" value="recondition" <?php if($vstatus == 'recondition') { echo 'checked';}?>/> 
						  <label for="recondition">Re-Condition</label>
					</div>
					<input type="submit" name="submit" class="btn btn-success" value="Calculate"/>
				  </div>
				</form>
			</div>
			<div class="col-lg-3"></div>
		</div>
	</div>
</div>

<?php
$max_year = date("Y"); // will get current year.
$min_year = $max_year - 10; // minimum year for reconditions.

//VAT Rate
$vat_rate = 0.15;

// Registration Fee 
$reg_fee_up_to_600cc = 7000;
$reg_fee_601_to_1000= 14000;
$reg_fee_1001_to_1400= 21000;
$reg_fee_1401_to_2000= 49000;
$reg_fee_above_2000= 98000;

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

// Advance Income Tax 
$ait_upto_1500cc = 15000;
$ait_1501_to_2000cc = 30000;
$ait_2001_to_2500cc = 50000;
$ait_2501_to_3000cc = 75000;
$ait_3001_to_3500cc = 100000;
$ait_above_3500cc = 125000;
 
// Fitness fee
$fitness_fee = 450;

// label Fee 
$label_fee = 45; // Leble fee for Tax token, Route Peirmit and Advance Income tax

//for Road tax Calculation
$seat_up_to_3 = 2500;
$seat_up_to_4 = 3500;
$seat_up_to_5 = 5000;
$seat_above_5per = 500; // road tax for each seat after 5 seat including driving seat 

// function for Registration fee calculation 
		function regcal($value01)
			{ 
			global $reg_fee_up_to_600cc, $reg_fee_601_to_1000, $reg_fee_1001_to_1400, $reg_fee_1401_to_2000, $reg_fee_above_2000;
			
			if ($value01 <= 600) { $reg_fee = $reg_fee_up_to_600cc;}
			elseif($value01 > 600 && $value01 <= 1000) { $reg_fee = $reg_fee_601_to_1000; }
			elseif($value01 > 1000 && $value01 <= 1400) { $reg_fee = $reg_fee_1001_to_1400; }
			elseif($value01 > 1400 && $value01 <= 2000) { $reg_fee = $reg_fee_1401_to_2000;}
			elseif(	$value01 > 2000) { $reg_fee = $reg_fee_above_2000; }
			else{$reg_fee = "";}
			return $reg_fee;
			}
// function for recondition registration 
		function recon_regcal($value02)
			{
				global $reg_fee;	
				$recon_reg_fee = ceil($reg_fee/3);
				return $recon_reg_fee;
			}
		
		
	// Function for road tax calculation 
		function road_tax($seat_no)
			{
				global $seat_up_to_3, $seat_up_to_4, $seat_up_to_5, $seat_above_5per, $road_tax_car;
				
				if ($seat_no <= 3) { $road_tax_car = $seat_up_to_3;}
			 	elseif($seat_no > 3 && $seat_no <=4) { $road_tax_car = $seat_up_to_4; }
				elseif($seat_no > 4 && $seat_no <=5) { $road_tax_car = $seat_up_to_5; }
				elseif($seat_no > 5) {
					
						$extra_seat = $seat_no - 5; 
						$road_tax_car =  $seat_up_to_5 + ($extra_seat * $seat_above_5per); 
					}
				return $road_tax_car;
			}
		
		// Function for vat calculation except DRC & Number Plate
		function vat_cal($vat_val)
			{
				global $vat_rate;
				$vat_cal = 	$vat_val * $vat_rate;
				$vat = ceil($vat_cal);
				return $vat;
			}
	//Advance Income tax Calculation 
	function ait_cal($vcc)
		{
				global $ait_upto_1500cc, $ait_1501_to_2000cc, $ait_2001_to_2500cc, $ait_2501_to_3000cc, $ait_3001_to_3500cc, $ait_above_3500cc;
				if($vcc <= 1500)
					{ $ait = $ait_upto_1500cc;}
				elseif($vcc > 1500 && $vcc <= 2000)
				 	{ $ait = $ait_1501_to_2000cc;}
				elseif($vcc > 2000 && $vcc <= 2500)
				 	{ $ait = $ait_2001_to_2500cc;}
				elseif($vcc > 2500 && $vcc <= 3000)
				 	{ $ait = $ait_2501_to_3000cc;}
				elseif($vcc > 3000 && $vcc <= 3500)
				 	{ $ait = $ait_3001_to_3500cc;}
				else{ $ait = $ait_above_3500cc; }
				return $ait;
		}

		function fitness_cal($fun_mfg_year)
		{
				global $max_year, $min_year, $fitness_fee; 
				$difference = $max_year - $fun_mfg_year;
				if($difference <= 4)
					{
						$fit_fee=0;
					}
				else $fit_fee= $fitness_fee;
				return $fit_fee;
		}
?>


 
    
<?php	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
		
	// registration Fee only 
	$reg_fee = 	regcal($car_ccv, $vstatus);
	$reg_fee_vat = vat_cal($reg_fee);
	$reg_fee_total = $reg_fee + $reg_fee_vat;
	
	// Recondition registration Fee only 
	$recon_reg_fee = 	recon_regcal($reg_fee);
	$recon_reg_fee_vat = vat_cal($recon_reg_fee);
	$recon_reg_fee_total = $recon_reg_fee + $recon_reg_fee_vat;
	
	// Digital Registration Certificate 
	$DRC_fee = $DRC_Price_BRTA;
	$DRC_fee_vat = vat_cal($DRC_tarrif);
	$DRC_fee_total = $DRC_fee + $DRC_fee_vat;
	
	// Number Plate Fee Calculation 
	$NP_fee = $np_price_BRTA;
	$NP_fee_vat = vat_cal($np_tarrif);
	$NP_fee_total = $NP_fee + $NP_fee_vat;
	
	//Tax Token Fee calculation 
	$road_tax = road_tax($car_seat);
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
	
	// Advance Income Tax is not changing.
	$ait = ait_cal($car_ccv);
	
	//Label Fee Calculation 
	$label_fee = $label_fee;
	$label_fee_vat = vat_cal($label_fee);
	$label_fee_total = $label_fee + $label_fee_vat;
	
	//total without VAT
	$total_without_vat = 	$reg_fee 
							+ $DRC_fee 
							+ $NP_fee 
							+ $road_tax 
							+ $insp_fee 
							+ $ft_fee 
							+ $ait 
							+ $label_fee 
							+ $label_fee; 
	// Total Vat 
	$total_vat = 	$reg_fee_vat 
					+ $DRC_fee_vat 
					+ $NP_fee_vat 
					+ $road_tax_vat 
					+ $insp_fee_vat 
					+ $ft_fee_vat 
					+ $label_fee_vat 
					+ $label_fee_vat;
					
	if($vstatus == "recondition")
		{	
			$total_without_vat = $total_without_vat + $recon_reg_fee;
			$total_vat =  $total_vat + $recon_reg_fee_vat;
		}
	
	// Grand Total including VAT
	$total_including_vat = $total_without_vat + $total_vat;
?>
<div class="motor_car_output_area">
	<div class="container motor_car_output">
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<table class="table table-condensed">
					<tr class="active">
						<th>Name of Fee Item</th>
						<th>Main Fee(TK.)</th>
						<th>Vat(TK.)</th>
						<th>Total(TK.)</th>
					</tr>
					</tr>
					<tr class="success">
						<td class="left_td">Registration Fee</td>
						<td><?php echo $reg_fee;?></td>
						<td><?php echo $reg_fee_vat;?></td>
						<td><?php echo $reg_fee_total;?></td>
					</tr>
					<?php if($vstatus == "recondition"){ echo "
					<tr class='success'>
						<td class='left_td'>Registration Fee</td>
						<td>" . $recon_reg_fee . " </td>
						<td>" . $recon_reg_fee_vat . " </td>
						<td>" . $recon_reg_fee_total . "</td>
					</tr> ";
					} ?>
					<tr class="success">
						<td class="left_td">Digital Registration Certificate</td>
						<td><?php echo $DRC_fee;?></td>
						<td><?php echo $DRC_fee_vat;?></td>
						<td><?php echo $DRC_fee_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Retro-Reflective Number Plate with RFID Tag</td>
						<td><?php echo $NP_fee;?></td>
						<td><?php echo $NP_fee_vat;?></td>
						<td><?php echo $NP_fee_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Inspection Fee</td>
						<td><?php echo $insp_fee;?></td>
						<td><?php echo $insp_fee_vat;?></td>
						<td><?php echo $insp_fee_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Fitness Fee</td>
						<td><?php if($ft_fee <= 0){echo "N/A";}else echo $ft_fee;?></td>
						<td><?php if($ft_fee_vat<= 0){echo "N/A";} else echo $ft_fee_vat;?></td>
						<td><?php if($ft_fee_total <= 0){ echo "N/A";} else echo $ft_fee_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Label for Fitness</td>
						<td><?php echo $label_fee;?></td>
						<td><?php echo $label_fee_vat;?></td>
						<td><?php echo $label_fee_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Road Tax</td>
						<td><?php echo $road_tax;?></td>
						<td><?php echo $road_tax_vat;?></td>
						<td><?php echo $road_tax_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Label for Road Tax</td>
						<td><?php echo $label_fee;?></td>
						<td><?php echo $label_fee_vat;?></td>
						<td><?php echo $label_fee_total;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Advance Income Tax</td>
						<td><?php echo $ait;?></td>
						<td>N/A</td>
						<td><?php echo $ait;?></td>
					<tr class="last_tr">
						<td class="left_td">Grand Total</td>
						<td><?php echo $total_without_vat;?></td>
						<td><?php echo $total_vat;?></td>
						<td><?php echo $total_including_vat;?></td>
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
			echo "Please input your field!";
		}
?>

<?php require('../../footer.php');?>


