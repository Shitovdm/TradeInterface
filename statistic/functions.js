/*
*	Функции используемые на страницах расчера статистики.
*/


// Функция пересчета общей выгоды. val - измененное значение, cell - измененная ячейка.
function reCalculate(new_val,cell,old_val){
	var received = Number($("#received_amount").text());// Получено при продаже(старое значение).
	var spent = Number($("#spent_amount").text());// Потрачено при покупке(старое значение).
	if(cell.attr("operation") == "buy_price_steam"){
		spent = (spent - Number(old_val)) + Number(new_val);
		$("#spent_amount").text(number_format(spent, 2, '.', ''));
	}else if(cell.attr("operation") == "sell_price_tm"){
		received = (received - Number(old_val)) + Number(new_val);
		$("#received_amount").text(number_format(received, 2, '.', ''));
	}
	var difference = (received - spent);
	var percent = ((received * 100)/spent) - 100;
	$("#loss").text(number_format(difference, 2, '.', ''));
	$("#full_percent").text(number_format(percent, 2, '.', ''));
}

$(function()	{
	$('td').click(function(e)	{
		//ловим элемент, по которому кликнули
		var t = e.target || e.srcElement;
		//получаем название тега
		var block_id = t.id;
		var elm_name = t.tagName.toLowerCase();
		//если это инпут или спец. класс - ничего не делаем
		if(elm_name == 'input' || $('#'+block_id).hasClass('no-edit')){
			return false;
		}
		var old_value = $(this).html();
		var val = $(this).html();
		var code = '<input type="text" id="edit" value="'+val+'" />';
		$(this).empty().append(code);
		$('#edit').focus();
		$('#edit').blur(function(){
			// Пересчет общих значений статистики.
			reCalculate($(this).val(),$(this).parent(),old_value);
			saveInformation($(this).val(),$(this).parent());
			var val = $(this).val();
			$(this).parent().empty().html(val);
		});
	});
});

<script src="https://www.google.com/jsapi"></script>
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
   ['Item Price', 'Buying', 'Selling'],
   ['<1 rub', <?php echo($sell_price_0_1); ?>, <?php echo($buy_price_0_1); ?>],
   ['1-50 rub', <?php echo($sell_price_1_50); ?>, <?php echo($buy_price_1_50); ?>],
   ['50-250 rub', <?php echo($sell_price_50_250); ?>, <?php echo($buy_price_50_250); ?>],
   ['250-1000 rub', <?php echo($sell_price_250_1000); ?>, <?php echo($buy_price_250_1000); ?>],
   ['1000-5000 rub', <?php echo($sell_price_1000_5000); ?>, <?php echo($buy_price_1000_5000); ?>],
   ['5000< rub', <?php echo($sell_price_5000_inf); ?>, <?php echo($buy_price_5000_inf); ?>],
]);
var options = {
 title: 'Items amount',
 hAxis: {title: 'Price'},
 vAxis: {title: 'Amount'}
};
var chart = new google.visualization.ColumnChart(document.getElementById('gistogram_stat'));
chart.draw(data, options);
}