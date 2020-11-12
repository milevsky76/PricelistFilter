<?php

    require_once __DIR__ . "/CModel.php";
    $model = new CModel();
    
    if(!empty($_POST)){
        $filter = [
            "FILED" => $_POST["price-type"] == 0 ? "price_retail" : "price_wholesale",
            "FROM" => $_POST["price-from"],
            "TO" => $_POST["price-to"],
            "RANGE" => $_POST["range-in-stock"] == 0 ? ">" : "<",
            "VALUE" => $_POST["quantity-in-stock"],
        ];
        $result = $model->GetSelectFilter($filter);
    } else{
        $result = $model->GetSelect();
        require_once "form.php";
    }

    if(isset($result) && $result != false){
		//Количество товаров
        $i = count($result);
		//Количество товаров на Складе1
        $availabilityStock1 = 0;
		//Количество товаров на Складе2
        $availabilityStock2 = 0;
		//Сумма розничной цены
        $totalRetailPrice = 0;
		//Сумма оптовой цены
        $totalWholesalePrice = 0;
		//дорогой товар (по рознице)
        $max;
		//дешевый товар (по опту)
        $min;
		//Тип товара
        $type;
        
        //Работа со значениями
        foreach($result as $val){
            if(!empty($max)){
                foreach($max as $Vmax){
                    if($Vmax["price_retail"] < $val["price_retail"]){
                        $max = [];
                        $max[$val["id"]] = $val;
                    } else if($Vmax["price_retail"] > $val["price_retail"]){
                        continue;
                    } else{
                        $max[$val["id"]] = $val;
                    }
                }
            }else{
                $max[$val["id"]] = $val;
            }
            
            if(!empty($min)){
                foreach($min as $Vmin){
                    if($Vmin["price_wholesale"] > $val["price_wholesale"]){
                        $min = [];
                        $min[$val["id"]] = $val;
                    } else if($Vmin["price_wholesale"] < $val["price_wholesale"]){
                        continue;
                    } else{
                        $min[$val["id"]] = $val;
                    }
                }
            }else{
                $min[$val["id"]] = $val;
            }
            
            $availabilityStock1 += $val["availability_stock1"];
            $availabilityStock2 += $val["availability_stock2"];
            $totalRetailPrice += $val["price_retail"];
            $totalWholesalePrice += $val["price_wholesale"];
        }
        ?>
        
        <table id="table">
            <tr>
                <th>Наименование товара</th>
                <th>Стоимость розница, руб</th>
                <th>Стоимость опт, руб</th>
                <th>Наличие на складе 1, шт</th>
                <th>Наличие на складе 2, шт</th>
                <th>Страна производства</th>
                <th>Примечание</th>
            </tr>
            
        <?php        
            foreach($result as $row) {        
                if(!isset($type) || ($type != $row["type"])){
                    $type = $row["type"]; ?>
            <tr><td colspan="7"><b><?= $row["type"]; ?></b></td></tr>
                <?php } ?>
            <tr 
            <?php
				//Выделяем в красным цветом самый дорогой товар (по рознице)
                if(in_array($row["id"], array_keys($max))){
                    echo "class=\"expensive\"";
                }//Выделяем в зеленым цветом самый дешевый товар (по опту)
				else if(in_array($row["id"], array_keys($min))){
                    echo "class=\"cheap\"";
                } 
            ?>>
                <td><?= $row["name"]; ?></td>
                <td><?= $row["price_retail"]; ?></td>
                <td><?= $row["price_wholesale"]; ?></td>
                <td><?= $row["availability_stock1"]; ?></td>
                <td><?= $row["availability_stock2"]; ?></td>
                <td><?= $row["country_production"]; ?></td>
                <td>
                <?php
                    if($row["availability_stock1"] < 20 || $row["availability_stock2"] < 20){
                        echo "Осталось мало!! Срочно докупите!!!";
                    }
                ?>
                </td>
            </tr>
        <?php } ?>
        </table>
        
        <?php
        //Cредняя стоимость розничной цены товара
        $availabilityRetailPrice = round($totalRetailPrice / $i, 2);
		//Cредняя стоимость оптовой цены товара
        $availabilityWholesalePrice = round($totalWholesalePrice / $i, 2);
        
        echo "Общее количество товаров на Складе1 - <b>$availabilityStock1</b> <br>";
        echo "Общее количество товаров на Складе2 - <b>$availabilityStock2</b> <br>";
        echo "Средняя стоимость розничной цены товара - <b>$availabilityRetailPrice</b> руб.<br>";
        echo "Средняя стоимость оптовой цены товара - <b>$availabilityWholesalePrice</b> руб.<br>";
    } else{
        echo "Товара не найдено!";
    }

?>