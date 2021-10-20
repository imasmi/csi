<div class="admin paddingY-30">
	<h3>Поставяне на баркод</h3>
	<table class="listTable napReorder">
		<tr>
			<td>НАП 191</td>
			<td><input type="text" id="NAP_191" value="C:/Users/1/Downloads/NAP_191"/></td>
			<td><button class="button" onclick="S.post('<?php echo $Core->query_path();?>/NAP', {dir: S('#NAP_191').value, type: '191'}, '#naps')">Зареждане</button></td>
		</tr>

		<tr>
			<td>НАП 74</td>
			<td><input type="text" id="NAP_74" value="C:/Users/1/Downloads/NAP_74"/></td>
			<td><button class="button" onclick="S.post('<?php echo $Core->query_path();?>/NAP', {dir: S('#NAP_74').value, type: '74'}, '#naps')">Зареждане</button></td>
		</tr>

		<tr>
			<td>ГРАО</td>
			<td><input type="text" id="GRAO" value="C:/Users/1/Downloads/GRAO"/></td>
			<td><button class="button" onclick="S.post('<?php echo $Core->query_path();?>/GRAO', {dir: S('#GRAO').value}, '#naps')">Зареждане</button></td>
		</tr>

		<tr>
			<td>Реджикс</td>
			<td><input type="text" id="REGIX" value="C:/Users/1/Downloads/REGIX"/></td>
			<td><button class="button" onclick="window.open('<?php echo $Core->query_path();?>/REGIX?dir=' + S('#REGIX').value)">Зареждане</button></td>
		</tr>

		<tr>
			<td>БНБ</td>
			<td><input type="text" id="BNB" value="C:/Users/1/Downloads/BNB"/></td>
			<td><button class="button" onclick="S.post('<?php echo $Core->query_path();?>/BNB', {dir: S('#BNB').value}, '#naps')">Зареждане</button></td>
		</tr>
	</table>
</div>

<div id="naps">
</div>
