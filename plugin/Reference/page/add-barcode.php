<div class="admin paddingY-30">
	<table class="listTable napReorder">
		<tr>
			<td>НАП 191</td>
			<td><input type="text" id="NAP_191" value="C:/Users/1/Downloads/NAP_191"/></td>
			<td><button class="button" onclick="S.post('<?php echo $Core->query_path();?>/NAP-191', {dir: S('#NAP_191').value, type: 'NAP_191'}, '#naps')">Зареждане</button></td>
		</tr>

		<tr>
			<td>НАП 74</td>
			<td><input type="text" id="NAP_74" value="C:/Users/1/Downloads/NAP_74"/></td>
			<td><button class="button" onclick="S.post('<?php echo $Core->query_path();?>/NAP-74', {dir: S('#NAP_191').value, type: 'NAP_74'}, '#naps')">Зареждане</button></td>
		</tr>

		<tr>
			<td>ГРАО</td>
			<td><input type="text" id="GRAO" value="C:/Users/1/Downloads/GRAO"/></td>
			<td><button class="button" onclick="window.open('<?php echo $Core->query_path();?>/GRAO?dir=' + S('#GRAO').value)">Зареждане</button></td>
		</tr>

		<tr>
			<td>Реджикс</td>
			<td><input type="text" id="REGIX" value="C:/Users/1/Downloads/REGIX"/></td>
			<td><button class="button" onclick="window.open('<?php echo $Core->query_path();?>/REGIX?dir=' + S('#REGIX').value)">Зареждане</button></td>
		</tr>

	</table>
</div>

<div id="naps">
</div>
