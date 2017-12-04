<?php
$button = $_POST["btn"];

if($button == 1)
{
	require('learner.php');
}
else if($button == 2)
{
	require('light_learner.php');
}
else if($button == 3)
{
	require('driving_license_pro.php');
}
else
{
	require('driving_license_non_pro.php');
}


?>

