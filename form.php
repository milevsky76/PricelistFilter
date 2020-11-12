<form id="form" action="table.php" method="POST" autocomplete="on">
    Показать товары, у которых
    <!-- Выбор типа цены -->
    <select id="price-type" name="price-type">        
        <option value="0">Розничная цена</option>
        <option value="1">Оптовая цена</option>        
    </select>
    от
    <!-- Цена от -->
    <input id="price-from" type="number" name="price-from" value="0">
    до
    <!-- Цена до -->
    <input id="price-to" type="number" name="price-to" value="999999">
    рублей и на складе
    <!-- Диапазон на складе -->
    <select id="range-in-stock" name="range-in-stock">
      <option value="0">Более</option>
      <option value="1">Менее</option>
    </select>
    <!-- Коолличество товара на складе -->
    <input id="quantity-in-stock" type="number" name="quantity-in-stock" value="0">
    штук.
    <!-- Кнопка для отправки формы -->
    <input type="submit" value="ПОКАЗАТЬ ТОВАРЫ" />
</form>