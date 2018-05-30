<?php

class CSV {
    private $_csv_file = null;
 
    /**
     * @param string $csv_file  - путь до csv-файла
     */
    public function __construct($csv_file) {
        if (file_exists($csv_file)) { //Если файл существует
            $this->_csv_file = $csv_file; //Записываем путь к файлу в переменную
			echo($csv_file);
        }
        else { //Если файл не найден то вызываем исключение
            throw new Exception("File " . $csv_file . " not found!"); 
        }
    }
 
    public function setCSV(Array $csv) {
        //Открываем csv для до-записи, 
        //если указать w, то  ифнормация которая была в csv будет затерта
        $handle = fopen($this->_csv_file, "a"); 
 
        foreach ($csv as $value) { //Проходим массив
            //Записываем, 3-ий параметр - разделитель поля
            fputcsv($handle, explode(";", $value), ";"); 
        }
        fclose($handle); //Закрываем
    }
 
    /**
     * Метод для чтения из csv-файла. Возвращает массив с данными из csv
     * @return array;
     */
    public function getCSV() {
        $handle = fopen($this->_csv_file, "r"); //Открываем csv для чтения
 
        $array_line_full = array(); //Массив будет хранить данные из csv
        //Проходим весь csv-файл, и читаем построчно. 3-ий параметр разделитель поля
        while (($line = fgetcsv($handle, 0, ";")) !== FALSE) { 
            $array_line_full[] = $line; //Записываем строчки в массив
        }
        fclose($handle); //Закрываем файл
        return $array_line_full; //Возвращаем прочтенные данные
    }
 
}
 
try {
    $csv = new CSV("pages/lists/items_730_1507661135(edit).csv");
    $get_csv = $csv->getCSV();
    foreach ($get_csv as $value){
        echo $value[0] . "<br>";
        echo $value[1] . "<br>";
        echo $value[2] . "<br>";
		echo $value[3] . "<br>";
		echo $value[4] . "<br>";
		echo $value[5] . "<br>";
		echo $value[6] . "<br>";
		echo $value[7] . "<br>";
		echo $value[8] . "<br>";
        echo $value[9] . "<br>";
		echo $value[10] . "<br>";
		echo $value[11] . "<br>";
		echo $value[12] . "<br>";
		echo $value[13] . "<br>";
		echo $value[14] . "<br>";
        echo "<br/>";
    }
	
}
catch (Exception $e) { //Если csv файл не существует, выводим сообщение
    echo "Ошибка: " . $e->getMessage();
}


?>