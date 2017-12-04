<html>
	<head> 
		<meta charset="ISO-8859-1">
		<title>Fitness Fee Calculator</title>
	</head> 
	<body>
		<?php

			//$selfUrl = $_SERVER['PHP_SELF'];
			$Arry_CircleCode = array("B.BARIA", "BAGERHAT", "BANDARBAN", "BARGUNA", "BARISAL", "BHOLA", "BOGRA", "CHANDPUR", "CHATTA METRO", "CHITTAGONG", "CHUADANGA", "COMILLA", "COXSBAZAR", "DHAKA", "DHAKA METRO", "DINAJPUR", "FARIDPUR", "FENI", "GAIBANDA", "GAIBANDHA", "GAZIPUR", "GOPALGANJ", "HABIGONG", "JAIPURHAT", "JESSORE", "JHALAKATI", "JHENIDAH", "JHENIDHA", "KHAGRACHARI", "KHULNA", "KHULNA METRO", "KISHOREGANJ", "KURIGRAM", "KUSHTIA", "LAKSHMIPUR", "LAXMIPUR", "LALMONIRHAT", "MADARIPUR", "MAGURA", "MANIKGANJ", "MEHERPUR", "MOULAVIBAZAR", "MOULVIBAZAR", "MUNSHIGANJ", "MYMENSINGH", "NAOGAON", "NARAIL", "NARAYANGANJ", "NARSINGDI", "NATOR", "NATORE", "NAWABGANJ", "NETRAKONA", "NILPHAMARI", "NOAKHALI", "PABNA", "PANCHAGAR", "PATUAKHALI", "POTUAKHALI", "PIROJPUR", "RAJBARI", "RAJ METRO", "RAJSHAHI", "RANGAMATI", "RANGPUR", "SATKHIRA", "SHARIATPUR", "SHERPUR", "SIRAJGONG", "SIRAJGONJ", "SUNAMGONJ", "SYLHET", "SYLHET METRO", "TANGAIL", "THAKURGAON");
			//$VClass = array("A(?)", "AU(?)"BA(?)", "BHA(?)", "CAA(?)", "CHA(?)", "DA(?)", "DAW(?)", "DHA(?)", "E(?)", "FA(?)", "GA(?)", "GHA(?)", "HA(?)", "JA(?)", "JHA(?)", "KA(?)", "KHA(?)", "LA(?)", "MA(?)", "NA(?)", "PA(?)", "RA(?)", "SA(?)", "SHA(?)", "TA(?)", "TAW(?)", "THA(?)", "U(?)", "WUA(?)", "ZA(?)");
			$VClass= array("A","AU","BA","BHA","CAA","CHA","DA","DAW","DHA","E","FA","GA","GHA","HA","JA","JHA","KA","KHA","LA","MA","NA","PA","RA","SA","SHA","TA","TAW","THA","U","WUA","ZA");
			$VClassCode= array("A","AU","BA","BHA","CAA","CHA","DA","DAW","DHA","E","FA","GA","GHA","HA","JA","JHA","KA","KHA","LA","MA","NA","PA","RA","SA","SHA","TA","TAW","THA","U","WUA","ZA");
		?>
		<form name="form1" id="mainForm" method="post" enctype="multipart/form-data" action="<?php echo $selfUrl; ?>">
		
		<table>
			<tr>
			<td> Select District Code of your vehicle (i.e Dhaka) </td><td>:</td> <td>		
			<select name="Circle_code">
				<option value="">Select</option>
				<?php  
					foreach($Arry_CircleCode as $value) 
						{
							print "<option value='" . $value ."'>" . $value . "</option>";
						}
				?>
			</select>
			</td>
			</tr>
			<tr>
			<td> Select Vehicle Class (i.e GA) </td> <td> : </td> <td> <select name="VClass">
				<option value="">Select</option>
				<?php 
					foreach (array_combine($VClassCode, $VClass) as $vccode => $vcname) 
						{
							echo '<option value="'.$vccode.'">'.$vcname .'</option>';
						}
				?>
			</select>
			</td>
			</tr>
			<tr>
			<td> Insert Vehicle Series (02 digits i.e 11 ) </td> <td>: </td> <td> <input type = "NUMBER" Name="vseries" min="1" max="99"/> </td>
			</tr> 
			<tr>
				<td> Insert Vehicle Reg. No. (04 digits ie 1234) </td> <td> : </td> <td> <input type = "NUMBER" Name="regno" min="1" max="9999" />  </td>
			</tr>
			<tr>
			<td> Click the Submit Button and wait for few second with patience. </td> <td>: </td> <td> <INPUT TYPE="SUBMIT" name="submit" VALUE="SUBMIT" /> </td>
			</tr>
			</table>
		</form>
	
		<?php 
			if(isset($_POST["submit"])) {
				
				$CircleCode = $_POST["Circle_code"];
				$VClass = $_POST["VClass"];
				$vseries = $_POST["vseries"];
				$Vnumber = $_POST["regno"];
				
				$CircleCode = str_replace(' ', '%20', $CircleCode);
				
				$vehicleNo = $CircleCode . "-" . $VClass . "-" . $vseries . "-". $Vnumber;
				
				//echo $vehicleNo;
				
				$ruleID1 = "R-10803"; // Fitness
				$ruleID2 = "N-10004"; // AIT
				$ruleID3 = "R-10603";  // Road Tax 
				$userID = "BRTA";
				$password= "BRTACNS";

				$apiurl1 = "http://info.cnsbd.com/fee_calc_api/api.php?r_id=". $ruleID1 . "&r_no=". $vehicleNo . "&use=" . $userID . "&pas=" . $password;
				$xml1 = new SimpleXMLElement(file_get_contents($apiurl1));

					$TIMESTAMP1 = $xml1->TIMESTAMP;
					$REGISTRATION_NO1 = $xml1->REGISTRATION_NO;
					$RULE_ID1 = $xml1->RULE_ID;
					// $RULE_NAME1 = $xml1->RULE_NAME;
					$RULE_NAME1 = "Renewal of Fitness Certificate";
					$MAIN_FEE1 = $xml1->MAIN_FEE;
					$EXTRA_CHARGE1 = $xml1->EXTRA_CHARGE;
					$INSPECTION_FEE1 = $xml1->INSPECTION_FEE;
					$LABEL_FEE1 = $xml1->LABEL_FEE;
					$APPLICATION_FEE1 = $xml1->APPLICATION_FEE;
					$LATE_FEE1 = $xml1->LATE_FEE;
					$OTHER_FEE1 = $xml1->OTHER_FEE;
					$VAT_FEE1 = $xml1->VAT_FEE;
					$TOTAL_FEE1 = $xml1->TOTAL_FEE;
					$TOTAL_WO_VAT1 = $xml1->TOTAL_WO_VAT;
					$RESPONSE1 = $xml1->RESPONSE;


				$apiurl2 = "http://info.cnsbd.com/fee_calc_api/api.php?r_id=". $ruleID2 . "&r_no=". $vehicleNo . "&use=" . $userID . "&pas=" . $password;

				$xml2 = new SimpleXMLElement(file_get_contents($apiurl2));
					$TIMESTAMP2= $xml2->TIMESTAMP;
					$REGISTRATION_NO2= $xml2->REGISTRATION_NO;
					$RULE_ID2= $xml2->RULE_ID;
					//$RULE_NAME2= $xml2->RULE_NAME;
					$RULE_NAME2= "Advance Income Tax (AIT)";
					$MAIN_FEE2= $xml2->MAIN_FEE;
					$EXTRA_CHARGE2= $xml2->EXTRA_CHARGE;
					$INSPECTION_FEE2= $xml2->INSPECTION_FEE;
					$LABEL_FEE2 = $xml2->LABEL_FEE;
					$APPLICATION_FEE2 = $xml2->APPLICATION_FEE;
					$LATE_FEE2= $xml2->LATE_FEE;
					$OTHER_FEE2= $xml2->OTHER_FEE;
					$VAT_FEE2= $xml2->VAT_FEE;
					$TOTAL_FEE2= $xml2->TOTAL_FEE;
					$TOTAL_WO_VAT2= $xml2->TOTAL_WO_VAT;
					$RESPONSE2= $xml2->RESPONSE;

				$apiurl3 = "http://info.cnsbd.com/fee_calc_api/api.php?r_id=". $ruleID3 . "&r_no=". $vehicleNo . "&use=" . $userID . "&pas=" . $password;
				$xml3 = new SimpleXMLElement(file_get_contents($apiurl3));
					$TIMESTAMP3= $xml3->TIMESTAMP;
					$REGISTRATION_NO3= $xml3->REGISTRATION_NO;
					$RULE_ID3= $xml3->RULE_ID;
					//$RULE_NAME3= $xml3->RULE_NAME;
					$RULE_NAME3 = "Renewal of Tax Token";
					$MAIN_FEE3= $xml3->MAIN_FEE;
					$EXTRA_CHARGE3= $xml3->EXTRA_CHARGE;
					$INSPECTION_FEE3= $xml3->INSPECTION_FEE;
					$LABEL_FEE3 = $xml3->LABEL_FEE;
					$APPLICATION_FEE3 = $xml3->APPLICATION_FEE;
					$LATE_FEE3= $xml3->LATE_FEE;
					$OTHER_FEE3= $xml3->OTHER_FEE;
					$VAT_FEE3= $xml3->VAT_FEE;
					$TOTAL_FEE3= $xml3->TOTAL_FEE;
					$TOTAL_WO_VAT3= $xml3->TOTAL_WO_VAT;
					$RESPONSE3= $xml3->RESPONSE;
?>

<!-- 

<select name="rule" id="rule" style="width:300px; height:25px">
                <option value="N">Payment Criterion </option>
                                <option id="D-10001" value="D-10001"> DIGITAL NUMBER PLATE</option>
                                <option id="R-10125" value="R-10125"> DIGITAL REGISTRATION CERTIFIC  ATE</option>
                                <option id="R-11122" value="R-11122"> RENEWAL OF FITNESS CERTIFICATE (SPECIAL REGISTRATION)</option>
                                <option id="R-10703" value="R-10703"> RENEWAL OF ROUTE PERMIT</option>
                                <option id="R-10705" value="R-10705"> TRANSFER OF ROUTE PERMIT</option>
                                <option id="R-11010" value="R-11010"> HIRE PURCHASE ENDORSEMENT FEES</option>
                                <option id="R-10802" value="R-10802"> ISSUE DUPLICATE OF FITNESS CERTIFICATE</option>
                                <option id="R-10803" value="R-10803"> RENEWAL OF FITNESS CERTIFICATE</option>
                                <option id="R-10605" value="R-10605"> DUPLICATE OF LOST TAX TOKEN (ISSUED BY POST OFFICE)</option>
                                <option id="R-10708" value="R-10708"> ISSUE OF DUPLICATE ROUTE PERMIT</option>
                                <option id="R-10602" value="R-10602"> ISSUE DUPLICATE OF TAX TOKEN</option>
                                <option id="R-10603" value="R-10603"> RENEWAL OF TAX TOKEN</option>
                                <option id="R-10112" value="R-10112"> ENDORSEMENT (RECORD CHANGE)</option>
                                <option id="R-10114" value="R-10114"> HIRE PURCHASE</option>
                                <option id="R-10115" value="R-10115"> WITHDRAWN OF HIRE PURCHASE</option>
                                <option id="R-10116" value="R-10116"> ADDRESS CHANGE OF REGISTERED VEHICLE</option>
                                <option id="R-10604" value="R-10604"> FREE TAX TOKEN</option>
                                <option id="R-10102" value="R-10102"> TRANSFER OF OWNERSHIP</option>
                                <option id="R-10103" value="R-10103"> ISSUE OF DUPLICATE REGISTRATION CERTIFICATE</option>
                                <option id="R-10109" value="R-10109"> MODIFICATION OF REGISTERED VEHICLE</option>
                                <option id="R-10606" value="R-10606"> SIX MONTHS TAX TOKEN RENEWAL</option>
                                <option id="N-10005" value="N-10005"> PREVIOUS YEAR AIT (PERSONAL)</option>
                                <option id="N-10006" value="N-10006"> PREVIOUS YEAR AIT (COMPANIES)</option>
                                <option id="V-10001" value="V-10001"> VAT AT SOURCE FOR FY-2010-2011</option>
                                <option id="N-10001" value="N-10001"> ADVANCE INCOME TAX (COMPANIES)</option>
                                <option id="N-10004" value="N-10004"> ADVANCE INCOME TAX (PERSONAL)</option>
                                <option id="R-11116" value="R-11116"> MISCELLANEOUS</option>
                                <option id="R-11117" value="R-11117"> NEW ROUTE PERMIT FOR EXISTING VEHICLE</option>
                                <option id="D-10004" value="D-10004"> REPLACEMENT OF DIGITAL NUMBER PLATE</option>
                                <option id="D-10003" value="D-10003"> PENDING DNP FEES</option>
                                <option id="M-10102" value="M-10102"> ROAD TAX (2ND INSTALLMENT)</option>
                                <option id="M-10103" value="M-10103"> ROAD TAX (3RD INSTALLMENT)</option>
                                <option id="M-10104" value="M-10104"> ROAD TAX (4TH INSTALLMENT)</option>
                                <option id="M-10105" value="M-10105"> ROAD TAX (5TH INSTALLMENT)</option>
                              </select> -->
	<?php echo "Vehicle Registration No. : ".$REGISTRATION_NO1 . ", Calculation date : " . $TIMESTAMP1. "<br/>"; ?> 
		<table border = "1">
			<tr> 
				<td>Serial</td>
				<td> Name of Item </td>
				<td> Main Fee </td>
				<td> Inspection fee </td>
				<td> Label fee </td>
				<td> Late fee </td>
				<td> Total </td>
				<td> VAT </td>
				<td> Grand Total </td>
			</tr>
			<tr> 
				<td> 1. </td>
				<td> <?php echo $RULE_NAME1; ?> </td>
				<td> <?php echo $MAIN_FEE1 ?> </td>
				<td> <?php echo $INSPECTION_FEE1 ?> </td>
				<td> <?php echo $LABEL_FEE1 ?> </td>
				<td> <?php echo $LATE_FEE1 ?> </td>
				<td> <?php echo $TOTAL_WO_VAT1 ?> </td>
				<td> <?php echo $VAT_FEE1 ?> </td>
				<td> <?php echo $TOTAL_FEE1 ?> </td>
			</tr>

			<tr> 
				<td> 2. </td>
				<td> <?php echo $RULE_NAME2; ?> </td>
				<td> <?php echo $MAIN_FEE2 ?> </td>
				<td> <?php echo $INSPECTION_FEE2 ?> </td>
				<td> <?php echo $LABEL_FEE2 ?> </td>
				<td> <?php echo $LATE_FEE2 ?> </td>
				<td> <?php echo $TOTAL_WO_VAT2 ?> </td>
				<td> <?php echo $VAT_FEE2 ?> </td>
				<td> <?php echo $TOTAL_FEE2 ?> </td>
			</tr>

			<tr> 
				<td> 3. </td>
				<td> <?php echo $RULE_NAME3; ?> </td>
				<td> <?php echo $MAIN_FEE3 ?> </td>
				<td> <?php echo $INSPECTION_FEE3 ?> </td>
				<td> <?php echo $LABEL_FEE3 ?> </td>
				<td> <?php echo $LATE_FEE3 ?> </td>
				<td> <?php echo $TOTAL_WO_VAT3 ?> </td>
				<td> <?php echo $VAT_FEE3 ?> </td>
				<td> <?php echo $TOTAL_FEE3 ?> </td>
			</tr>
			<tr> 
				<td colspan="8">Grand Total on <?php echo $TIMESTAMP1; ?></td>
				<td> 
					<?php 
						$grandTotal = $TOTAL_FEE2 + $TOTAL_FEE1+ $TOTAL_FEE3;	
					echo $grandTotal; ?> 
				</td>
			</tr>
		</table>

<?php 
		}else{  
    		//echo "N0, mail is not set";
		}
	?>
	<p> This software is under development process. If any inconsistency is found, please contact with us at sco@brta.gov.bd . <br/>
Moreover, your suggestion / comment / feedback is highly appreciable. </p>
</body>
</html>