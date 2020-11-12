$( document ).ready(function() {
    
    $("form").submit(function(evenr) {
        //Убираем действие по умолчанию
        event.preventDefault();
        
        //Проверка минимального значения цены
        if($("#price-from").val() < 0){
            alert("Минимальная цена не может быть отрицательной!");
            return;
        }else{
            if($("#price-from").val() == ""){
                $("#price-from").val(0);            
            }
        }

        //Проверка максимального значения цены
        if($("#price-to").val() < 0){
            alert("Максимальная цена не может быть отрицательной!");
            return;
        }else{
            if($("#price-to").val() == ""){
                $("#price-to").val(9999999);         
            }
            if($("#price-from").val() > $("#price-to").val()){
                alert("Максимальная цена не может быть меньше минимальной!");
                return;
            }
        }
        
        //Проверка колличество товара, минимальный диапазон
        if($("#quantity-in-stock").val() == ""){
            //Больше от 0
            if($("#range-in-stock").val() == 0){
                $("#quantity-in-stock").val(0);
            }
            //Меньше от 1
            if($("#range-in-stock").val() == 1){
                $("#quantity-in-stock").val(1);
            }
        }
        
        if($("#quantity-in-stock").val() < 0){
            alert("Количество товара не может быть отрицательным!");
            return;
        }
        
        if($("#range-in-stock").val() == 1 && $("#quantity-in-stock").val() == 0){
            alert("Количество товара не может быть меньше 0!");
            return;
        }
        
        
        //Отправка данных
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(date){
                $("#pricelist").empty();
                $("#pricelist").html(date);
            },
        });

    });
});