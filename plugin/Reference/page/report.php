 <div class="admin">
<div class="title">Отчети към кчси</div>
<table class="listing">
	<tr>
		<th>#</th>
		<th>Year</td>
		<th>Period</th>
		<th>Type</th>
		<th></th>
	</tr>
	
	<?php 
	$cnt = 1;
	foreach($PDO->query("SELECT * FROM report GROUP by year, period, type ORDER by year DESC, period DESC") as $report){?>
	<tr>
		<td><?php echo $cnt;?></td>
		<td><?php echo $report["year"];?></td>
		<td><?php echo $report["period"];?></td>
		<td><?php echo $report["type"];?></td>
		<td><button class="button" onclick="window.open('<?php echo $Core->this_path(0, -1);?>/report/<?php echo $report["type"];?>?year=<?php echo $report["year"];?>&period=<?php echo $report["period"];?>', '_self')">Open</button></td>
		<td><button class="button" onclick="window.open('<?php echo $Core->this_path(0, -1);?>/report/<?php echo $report["type"];?>_calculations?year=<?php echo $report["year"];?>&period=<?php echo $report["period"];?>', '_self')">Calculations</button></td>
	</tr>
	<?php 
	$cnt++;
	} ?>
</table>
</div>