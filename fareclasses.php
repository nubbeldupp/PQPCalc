<?php
include 'database.php';

$result = mysqli_query($con,"SELECT carrier, fareclass, percent FROM fareclasses");

?>
<div class='col-md-12' style='display: inline-block'>
	<div class='table-responsive'>
	<table id="table" data-toggle="table" data-sortable="true" data-filter-control="true" data-pagination="true" data-side-pagination="client" data-page-size="10" data-page-list="[10, 25, 50, 100, ALL]" >
		<thead class='thead-dark'>
		    <tr>
		    	<th data-field='carrier' data-filter-control='select' data-sortable='true' filterStrictSearch="true">Carrier</th>
		    	<th data-field='fareclass' data-filter-control='select' data-sortable='true'>Fareclass</th>
		    	<th data-field='percent' data-filter-control='select' data-sortable='true'>Percentage</th>
		    </tr>
		</thead>
		<tbody>
<?php
while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['carrier'] . "</td>";
echo "<td>" . $row['fareclass'] . "</td>";
echo "<td>" . $row['percent'] . "</td>";
echo "</tr>";
}
echo "</tbody>
</table>
</div>
</div>";
mysqli_close($con);
?>

