var csi = function(){};

csi.changeDate = function(val){
	var dat = val.value.split(".");
	if(dat[1]){
 		newDat = dat[2] + "-" + dat[1] + "-" + dat[0];
		val.value = newDat;
	}
}

csi.click74 = function(checkBox){
    if(checkBox.checked){
		document.getElementById('d3').disabled = false;
		document.getElementById('d4').disabled = false;
		document.getElementById('d5').disabled = false;
		document.getElementById('d6').disabled = false;
		document.getElementById('d7').disabled = false;
		document.getElementById('d8').disabled = false;
		document.getElementById('d9').disabled = false;
		document.getElementById('c1').disabled = false;
	}else{
		document.getElementById('d3').disabled = true;
		document.getElementById('d3').checked = false;
		document.getElementById('d4').disabled = true;
		document.getElementById('d4').checked = false;
		document.getElementById('d5').disabled = true;
		document.getElementById('d5').checked = false;
		document.getElementById('d6').disabled = true;
		document.getElementById('d6').checked = false;
		document.getElementById('d7').disabled = true;
		document.getElementById('d7').checked = false;
		document.getElementById('d8').disabled = true;
		document.getElementById('d8').checked = false;
		document.getElementById('d9').disabled = true;
		document.getElementById('d9').checked = false;
		document.getElementById('c1').disabled = true;
		document.getElementById('c1').checked = false;
	}
}

csi.trim = function(val){
	var trimed = val.value.trim();
	val.value = trimed;
}

csi.requestChange = function(id){
	$(".requestChange td").css("backgroundColor", "unset");
	document.getElementById(id + "_button").style.backgroundColor = "#90ee90";
	$(".spravki").css("display", "none");
	document.getElementById(id).style.display = "block";
}

/*payment*/

csi.checkPayments = function(check){
	for(a = 1; a < Number(document.getElementById("totalPayments").value); a++){
		document.getElementById("payment" + a).checked = check;
	}
}

csi.checkLenght = function(){
	for(a = 1; a < Number(document.getElementById("totalPayments").value); a++){
		if(document.getElementById("description" + a).value.length > 70){
			document.getElementById("description" + a).style.backgroundColor = 'red';
			return false;
		}

		if(document.getElementById("name" + a).value.length > 35){
			document.getElementById("name" + a).style.backgroundColor = 'red';
			return false;
		}
	}
}

csi.usePay = function(n, a, elem, total){
	console.log("2_budget_amount" + a);
	if(elem.checked == true){
		S.all('.budgetRow' + n + '_' + a, function(e){e.disabled = false;});
	} else {
		S.all('.budgetRow' + n + '_' + a, function(e){e.disabled = true;});
	}

	csi.calculateSums(a, total);
}

csi.calculateSums = function(a, b){
	var bsum = Number(document.getElementById("amount" + a).value);

	var totalPaid = 0;

	for (n = 1; n < b; n++){
		if(document.getElementById(n + "_budget_check" + a).checked == true){
			totalPaid += Number(document.getElementById(n + "_budget_amount" + a).value);
		}
	}

	var restSum = bsum - totalPaid;

	for (n = 1; n < b; n++){
		if(document.getElementById(n + "_budget_check" + a).checked == false){
			document.getElementById(n + "_budget_amount" + a).value = restSum.toFixed(2);
		}
	}
}

csi.markChecked = function(val){
	for(a = 1; a < Number(document.getElementById("totalPayments").value); a++){
		if(val == "budgetPay"){
			$(".directROW").css("display", "none");
			$('.emptyROW').css('display', 'none');
			$('.budgetROW').css('display', 'table-row');
			if(document.getElementById("type" + a).value == "budget" && document.getElementById("amount" + a).value > 0){
				document.getElementById("payment" + a).checked = true;
			} else {
				document.getElementById("payment" + a).checked = false;
			}
		}

		if(val == "directPay"){
			$('.directROW').css('display', 'table-row');
			$('.emptyROW').css('display', 'table-row');
			$('.budgetROW').css('display', 'none');
			if(document.getElementById("type" + a).value == "direct" && document.getElementById("amount" + a).value > 0){
				document.getElementById("payment" + a).checked = true;
			} else {
				document.getElementById("payment" + a).checked = false;
			}
		}

	}
}

csi.changeDate = function(val){
	var dat = val.value.split(".");
	if(dat[1]){
 		newDat = dat[2] + "-" + dat[1] + "-" + dat[0];
		val.value = newDat;
	}
}

//id: id и name на селектора(еднакво е)
//value: намерената стойност - ID на реда от базата данни
//data: избраната дата в текстови формат, която да се попълни в селектора
csi.selector = function(id, value, data){
	document.getElementById(id + "-data").value = data;
	document.getElementById(id).value = value;
	document.getElementById(id + "-list").innerHTML = "";
}

csi.napSpravki = function(val, elem){
	if(val != "0"){
		$(elem).prop("checked", true);
	} else {
		$(elem).prop("checked", false);
	}
}

csi.proportions = function (){
	var dept = 0;
	for (b = 1; b <= S("#totalSums").value; b++){
		dept = dept + Number(S("#sum" + b).value);
	}
	S("#dept").innerHTML = dept;
	var sum = Number(document.getElementById("sum").value);

	for (a = 1; a <= S("#totalSums").value; a++){
		document.getElementById("multi" + a).innerHTML = (Number(S("#sum" + a).value) * (sum/dept)).toFixed(2);
		document.getElementById("division" + a).innerHTML = (Number(S("#sum" + a).value) / (dept/sum)).toFixed(2);
	}
}

csi.checkStarters = function(val, elem){
	for(a = 1; a <= 100; a++){
		if(val.checked == true && document.getElementById("case_" + a).value != ""){
			document.getElementById(elem + "_" + a).checked = true;
			if(elem == "red"){$(".red_" + a).prop("checked", true);}
		} else {
			document.getElementById(elem + "_" + a).checked = false;
			if(elem == "red"){$(".red_" + a).prop("checked", false);}
		}
	}
}

csi.noteQuick = function(elem){
	S("#note").value= elem.options[elem.selectedIndex].text;
	S("#usePeriod").checked = true;
	S.toggle('#periodChanger');
	let today = new Date();
	today.setDate(today.getDate() + (elem.value == "pdi" ? 30 : 5));
	S("#period_date").value = today.toISOString().slice(0, 10);
	S("#events").checked = true;
	S("#payment").checked = true;
}

csi.section = function(elem){
	if(S(elem).classList.contains("open")){
		S(elem).classList.remove("open");
	} else {
		S(elem).classList.add("open")
	}
	location.hash = S(elem).id;
}

csi.massEdit = function(id){
	elem = S(id);
	if(event.target.checked == true){
		elem.value = elem.value + event.target.id + ",";
	} else {
		elem.value = elem.value.replace(event.target.id + ",",'');
	}
}

csi.totalSum = function(el, resultDestination, value){
	let resultElement = S(resultDestination);
	let toFix = 0;
	if (value.includes(".")){
		toFix = value.split(".")[1].split("").length;
	}
	let finalResult = el.checked ? Number(resultElement.innerHTML) + Number(value) : Number(resultElement.innerHTML) - Number(value);
	resultElement.innerHTML = finalResult.toFixed(toFix);
}

csi.distribute = function(elem){
	const split =  elem.id.split("-");
	const type = split[0];
	const id = split[1];
	const sum = Number(S("#distribute-sum").innerHTML); // Get current sum to distribute
	const current = Number(elem.getAttribute("data-current")); // Current elem value before the change
	const value = Number(elem.value); // The value we want to use for update
	const max = Number(elem.max); // Maximum value for the current element
	let distribute = value;

	//Set distribute sum based on available money and current max value
	if (Number(elem.value) > sum + current) {distribute = sum + current;}
	if (distribute > max) {distribute = max;}
	const difference = current - distribute;
	
	if(value > distribute) {elem.value = distribute;} //Set distribute value based on current max value
	S("#distribute-sum").innerHTML = (sum + difference).toFixed(2); //Update current available sum for distribution
	
	if  (type == "tax") {
		S("#tax-total").innerHTML = (Number(S("#tax-total").innerHTML) - current + distribute).toFixed(2);
	} else if(type == "total") {
		const debt = elem.getAttribute("debt-id");
		S(`#${type}-${debt}`).innerHTML = (Number(S(`#${type}-${debt}`).innerHTML) - current + distribute).toFixed(2);

		const sum = S(`#sum-${id}`);
		const prop = S(`#prop-${id}`);
		const total = Number(sum.max) + Number(prop.max);
		const sumValue = Number(sum.max) * (distribute/total);
		const propValue = Number(prop.max) * (distribute/total);
		sum.value = sumValue.toFixed(2);
		prop.value = propValue.toFixed(2);
		S(`#sum-${debt}`).innerHTML = (Number(S(`#sum-${debt}`).innerHTML) - Number(sum.getAttribute("data-current")) + sumValue).toFixed(2);
		sum.setAttribute("data-current", sumValue.toFixed(2));
		S(`#prop-${debt}`).innerHTML = (Number(S(`#prop-${debt}`).innerHTML) - Number(prop.getAttribute("data-current")) + propValue).toFixed(2);
		prop.setAttribute("data-current", propValue.toFixed(2));
	} else {
		const debt = elem.getAttribute("debt-id");
		S(`#${type}-${debt}`).innerHTML = (Number(S(`#${type}-${debt}`).innerHTML) - current + distribute).toFixed(2);
	}
	
	elem.setAttribute("data-current", distribute); // Update current element current value
}

csi.distributeAuto = function(){
	let items = [];
	S.all("#distribute-data input", el => {
		el.value = 0;
		el.setAttribute("data-current", "0");
		if (el.getAttribute("data-order")) {
			if(!items[el.getAttribute("data-order")]){ items[el.getAttribute("data-order")] = [];}
			items[el.getAttribute("data-order")].push(el);
		}
	});

	S.all(".total", el => {
		el.innerHTML = 0;
	});
	S("#distribute-sum").innerHTML = S("#distribute-amount").innerHTML;

	for(let i = 0; i < items.length; i++){
		if(items[i]) {
			for (let n = 0; n < items[i].length; n++) {
				items[i][n].value = Number.MAX_SAFE_INTEGER;
				csi.distribute(items[i][n]);
			}
		}
	}
}