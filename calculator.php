<?php
include 'database.php';



if(isset($_POST['carrier1']) && $_POST['carrier1'] != 'Carrier'){
	?>
		<div class='col-md-12' style='display: inline-block'>
			<div class='table-responsive'>
			<table class="table w-auto table-hover" data-toggle="table" data-page-size="10">
				<thead class='thead-dark'>
				    <tr>
				    	<th data-field='departure'>Depature</th>
				    	<th data-field='arrival'>Arrival</th>
				    	<th data-field='carrier'>Carrier</th>
				    	<th data-field='fareclass'>Fareclass</th>
				    	<th data-field='percentage'>Percentage</th>
				    	<th data-field='distance'>Distance</th>
				    	<th data-field='pqp'>PQP</th>
				    </tr>
				</thead>
				<tbody>
	<?php
	for ($i=1; $i <= 10; $i++) {
		
			if(isset($_POST['departure' . $i]) && isset($_POST['arrival' . $i]) && isset($_POST['carrier' . $i]) && isset($_POST['fareclass' . $i]) && $_POST['carrier' . $i] != 'Carrier' &&$_POST['fareclass' . $i] != 'Fareclass'){

				$dep = htmlspecialchars($_POST['departure' . $i]);
				$arr = htmlspecialchars($_POST['arrival' . $i]);
				$car = htmlspecialchars($_POST['carrier' . $i]);
				$fcl = htmlspecialchars($_POST['fareclass' . $i]);

				$qper = $con->prepare("SELECT percent FROM fareclasses WHERE carrier = ? AND fareclass = ?");
				$qper->bind_param("ss", $car, $fcl);
				$qper->execute();
				$qper->bind_result($row);
				while ($qper->fetch()) {
					$per = $row;
				}
				$qper->close();


				$qdiv = $con->prepare("SELECT dividend FROM dividend where carrier = ?");
				$qdiv->bind_param("s", $car);
				$qdiv->execute();
				$qdiv->bind_result($row);
				while ($qdiv->fetch()) {
			        	$div = $row;
			    	}
				$qdiv->close();

				$curl = curl_init("http://www.gcmap.com/dist?P=" . $dep . "-" . $arr);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

				$page = curl_exec($curl);

				if(curl_errno($curl))
				{
					echo 'Scraper error: ' . curl_error($curl);
					exit;
				}

				curl_close($curl);

				$regex = '/<td class="d">(.*?) mi<\/td>/s';
				if(preg_match($regex, $page, $list) ){
				    $dist = $list[0];
				    $dist = str_replace('<td class="d">', '', $dist);
				    $dist = str_replace(' mi</td>', '', $dist);
				    $dist =str_replace(',', '', $dist);
				}else{
				  	$dist = "Not found";
				}

				${"pqp$i"} = $dist * $per / $div;
				${"pqp$i"} = round(${"pqp$i"});
				echo "<tr>";
			    echo '<td>' . $dep . '</td>';
			    echo '<td>' . $arr . '</td>';
			    echo '<td>' . $car . '</td>';
			    echo '<td>' . $fcl . '</td>';
			    echo '<td>' . $per . '</td>';
			    echo '<td>' . $dist . '</td>';
			    echo '<td>' . ${"pqp$i"} . '</td>';
			    echo '</tr>';
			}else{
				${"pqp$i"} = 0;
			}
		$pqptotal = $pqptotal + ${"pqp$i"};

	}
	

echo "<tr>";
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td>Total PQP</td>';
echo '<td>' . $pqptotal . '</td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';


}else{
	$result = mysqli_query($con,"SELECT carrier, fareclass, percent FROM fareclasses");
?>
<div class='col-md-12' style='display: inline-block'>
	<div class='table-responsive'>
	<form method="POST" action="http://pqp-calc.com/index.php?page=calculator">
	<table id="table" data-toggle="table" data-page-size="10">
		<thead class='thead-dark'>
		    <tr>
		    	<th data-field='departure'>Depature(IATA/ICAO)</th>
		    	<th data-field='arrival'>Arrival(IATA/ICAO)</th>
		    	<th data-field='carrier'>Carrier</th>
		    	<th data-field='fareclass'>Fareclass</th>
		    </tr>
		</thead>
		<tbody>
<?php
	for ($i=1; $i <= 10; $i++) { 

	echo "<tr>";
	echo '<td><input type="text" name="departure' . $i . '" value="" placeholder="eg. FRA or EDDF" maxlength="4" minlength="3" size="15"></td>';
	echo '<td><input type="text" name="arrival' . $i . '" value="" placeholder="eg. EWR or KEWR" maxlength="4" minlength="3" size="15"></td>';

	echo '<td><select name="carrier' . $i . '">';
	echo '<option value="Carrier">Carrier</option>';
	$result = mysqli_query($con,"SELECT carrier FROM dividend");
	while($row = mysqli_fetch_array($result))
	{
	  echo '<option value="' . $row['carrier'] . '">' . $row['carrier'] . '</option>';
	}
	echo '</select></td>';

	echo '<td><select name="fareclass' . $i . '">';
	echo '<option value="Fareclass">Fareclass</option>';
	$result = mysqli_query($con,"SELECT distinct fareclass FROM fareclasses ORDER BY fareclass");
	while($row = mysqli_fetch_array($result))
	{
	  echo '<option value="' . $row['fareclass'] . '">' . $row['fareclass'] . '</option>';
	}
	echo '</select></td>';

	echo "</tr>";
	}

echo "</tbody>
</table>
<button type='submit' class='btn btn-primary mt-1'>Submit</button>
</form>
</div>
</div>";
}


mysqli_close($con);
?>

