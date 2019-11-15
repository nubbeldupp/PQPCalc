<?php
include 'database.php';

$result = mysqli_query($con,"SELECT carrier, carrierFull, dividend FROM dividend");

?>
<div class='col-md-12' style='display: inline-block'>
	<table id="table" data-toggle="table" data-sortable="true" data-filter-control="true">
		<thead class='thead-dark'>
		    <tr>
		    	<th data-field='carrier' data-filter-control='select' data-sortable='true'>Carrier</th>
		    	<th data-field='carrierFull' data-filter-control='select' data-sortable='true'>CarrierFullName</th>
		    	<th data-field='divisor' data-filter-control='select' data-sortable='true'>Divisor</th>
		    </tr>
		</thead>
		<tbody>
<?php
while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['carrier'] . "</td>";
echo "<td>" . $row['carrierFull'] . "</td>";
echo "<td>" . $row['dividend'] . "</td>";
echo "</tr>";
}
echo "</tbody>
</table>
</div>";

mysqli_close($con);
?>
