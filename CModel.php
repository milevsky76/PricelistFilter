<?php

    class CModel{
        private $mysql;
        private $result;
    
        public function __construct() {
            $connectionData = [ "host" => "", "userName" => "", "password" => "", "dbName" => "" ];
            
            $mysql = mysqli_connect($connectionData["host"], $connectionData["userName"], $connectionData["password"], $connectionData["dbName"]);
            
            if(!$mysql){
                die("Connection error: " . mysql_error());
            }
            
            mysqli_query($mysql, "SET NAMES 'utf8_general_ci'");
            mysqli_query($mysql, "SET CHARACTER SET 'utf8_general_ci'");
            
            $this->mysql = $mysql;
        }
        
		//Выборка таблицы
        public function GetSelect(){
            $resultDB = mysqli_query($this->mysql, "SELECT * FROM `products`");
            
            if($resultDB){
                while($row = mysqli_fetch_assoc($resultDB)){
                    $result[] = $row;
                }
        		return $result;
            }
            return false;
        }
        
		//Выборка по фильтру
        public function GetSelectFilter($filter){
            $resultDB = mysqli_query($this->mysql, "SELECT * FROM `products` WHERE ($filter[FILED] BETWEEN $filter[FROM] AND $filter[TO]) AND (availability_stock1 $filter[RANGE] $filter[VALUE] OR availability_stock2 $filter[RANGE] $filter[VALUE]) ORDER BY id ASC");

            if($resultDB){
                while($row = mysqli_fetch_assoc($resultDB)){
                    $result[] = $row;
                }
        		return $result;
            }
            return false;
        }
		
		//Обновление инкремента
        public function GetAutoIncr(){
            $resultDB = mysqli_query($this->mysql, "ALTER TABLE `products` AUTO_INCREMENT = 0");
            
    		return $resultDB;           
        }
        
		//Вставка значений
        public function GetInsert($str){             
            $resultDB = mysqli_query($this->mysql, "INSERT INTO `products` (`id`, `type`, `name`, `price_retail`, `price_wholesale`, `availability_stock1`, `availability_stock2`, `country_production`) VALUES $str");
            
            return $resultDB;
        }
    }

?>