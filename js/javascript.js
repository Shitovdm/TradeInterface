

//Автоматические подтверждения предложений обмена в Стиме. Выполняется каждую минуту.
//function confirmation(){	
//}
//setInterval(confirmation, 60000) ;

/*Загрузка 5 предметов*/



//	Функция раскрытия и закрытия списка параметров профиля в хедере
function showList(){
	if(document.getElementById('header_profile_paramList').style.display == "block"){
		$("#header_profile_paramList").fadeOut('fast');
	}else{
		 $("#header_profile_paramList").fadeIn('fast');
	}
}

