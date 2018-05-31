<?php

    class CSV {

        private $_csv_file = null;

        public function __construct($csv_file) {
            if (file_exists($csv_file)) {
                $this->_csv_file = $csv_file;
                echo($csv_file);
            } else {
                throw new Exception("File " . $csv_file . " not found!");
            }
        }

        public function setCSV(Array $csv) {
            $handle = fopen($this->_csv_file, "a");

            foreach ($csv as $value) {
                fputcsv($handle, explode(";", $value), ";");
            }
            fclose($handle);
        }

        public function getCSV() {
            $handle = fopen($this->_csv_file, "r");

            $array_line_full = array();
            while (($line = fgetcsv($handle, 0, ";")) !== FALSE) {
                $array_line_full[] = $line;
            }
            fclose($handle);
            return $array_line_full;
        }

    }

    try {
        $csv = new CSV("pages/lists/items_730_1507661135(edit).csv");
        $get_csv = $csv->getCSV();
        foreach ($get_csv as $value) {
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
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
    }
?>