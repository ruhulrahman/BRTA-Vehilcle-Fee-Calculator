<?php require('header.php');?>

<?php
$reg_fee_up_to_100cc = 4200;
$reg_fee_above_100cc = 5600;
$DRC = 555;		//Digital Registration Cirtificate
$inspection_fee = 450;
$road_tax_up_to_90kg = 500;
$road_tax_above_90kg = 1000;
$vat_rate = 0.15;

//Retro Reflective number plate price 
$np_tarrif = 395;
$np_vat = $np_tarrif * 0.15;
$np_price_BMTF = 1805;
$np_price_BRTA = $np_price_BMTF + $np_tarrif;

//Digital Certificate Price 
$DRC_tarrif = 100;
$DRC_vat = $DRC_tarrif * 0.15;
$DRC_Price_BMTF = 440;
$DRC_Price_BRTA = $DRC_tarrif + $DRC_Price_BMTF;
?>


<div class="motorcycle_area">
	<div class="container motorcycle">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="first">Fee Calculation for Motorcycle</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
				  <div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Engine Capacity</div>
						<input type="number" name="mcc" max= "150" min = "30" class="form-control" id="" placeholder="Enter Your Motorcycle CC">
						<div class="input-group-addon">CC</div>
					</div><br />
					<div class="input-group">
						<div class="input-group-addon">Motorcycle Weight</div>
						<input type="number" name="mw" max="999" min ="30" class="form-control" id="" placeholder="Enter Your Motorcycle Weight">
						<div class="input-group-addon">Kg.</div>
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
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			$ccv = $_POST["mcc"];
			$mwv = $_POST["mw"];
			
		if	($ccv != "" && $mwv != "")
		 {
			if( $ccv <= 100 && $mwv <=90)
				{
					$reg_fee = $reg_fee_up_to_100cc;
					$road_tax = $road_tax_up_to_90kg;
				}
			
			if( $ccv > 100 && $mwv > 90)
				{
					$reg_fee = $reg_fee_above_100cc;
					$road_tax = $road_tax_above_90kg;
				}
				
			if( $ccv > 100 && $mwv <= 90)
				{
					$reg_fee = $reg_fee_above_100cc;
					$road_tax = $road_tax_up_to_90kg;
				}
			
			if( $ccv <= 100 && $mwv > 90)
				{
					$reg_fee = $reg_fee_up_to_100cc;
					$road_tax = $road_tax_above_90kg;
				}
				
?>

<?php 
		
//Total Withou Vat..........
$Total = $reg_fee 
		+ $DRC_Price_BRTA 
		+ $np_price_BRTA 
		+ $inspection_fee 
		+ ($road_tax * 10);

// Total Vat
	$VAT = ($reg_fee * $vat_rate) 
		+ ceil($DRC_vat) 
		+ ceil($np_vat) 
		+ ceil($inspection_fee * $vat_rate) 
		+ (($road_tax * 10) * $vat_rate ); 


//Grand Total.......
$grand_total = $Total + $VAT;
?>

<div class="motorcycle_output_area">
	<div class="container motorcycle_output">
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
						<td><?php echo $reg_fee * $vat_rate;?></td>
						<td><?php echo $reg_fee + ($reg_fee * $vat_rate);?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Digital Registration Certificate</td>
						<td><?php echo $DRC_Price_BRTA;?></td>
						<td><?php echo $DRC_vat;?></td>
						<td><?php echo $DRC_Price_BRTA + $DRC_vat;?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Retro-Reflective Number Plate with RFID Tag</td>
						<td><?php echo $np_price_BRTA;?></td>
						<td><?php echo ceil($np_vat);?></td>
						<td><?php echo $np_price_BRTA + ceil($np_vat);?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Inspection Fee</td>
						<td><?php echo $inspection_fee;?></td>
						<td><?php echo ceil($inspection_fee * $vat_rate);?></td>
						<td><?php echo $inspection_fee + ceil($inspection_fee * $vat_rate);?></td>
					</tr>
					<tr class="success">
						<td class="left_td">Road Tax</td>
						<td><?php echo $road_tax * 10 ;?></td>
						<td><?php echo ($road_tax * 10) * $vat_rate ;?></td>
						<td><?php echo ($road_tax * 10) + (($road_tax * 10) * $vat_rate) ;?></td>
					</tr>
					<tr class="last_tr">
						<td class="left_td">Grand Total</td>
						<td><?php echo $Total;?></td>
						<td><?php echo $VAT;?></td>
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
				echo "<font color=red><h3 class='text-center validation'>please fill the field!</h3></font>";
		}
		else{}
?>
   
 </html>


<?php require('footer.php');?>