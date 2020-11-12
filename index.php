<style>

    table {
        border-collapse: collapse;
    }
    th {
        padding: 10px; 
    }
    td {
        padding: 0px 10px;
        text-align: center;
    }
    table, th, td{
        border: 1px solid #000;
    }
    .expensive{
        background-color: red;
    }
    .cheap{
        background-color: green;
    }

</style>

<?php    
    //Вывод Формы
    require_once "form.php";
?>
    
<div id="pricelist">
    <?php require_once "table.php"; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/form-validation.js"></script>