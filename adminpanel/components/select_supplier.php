<?php
include "../parser-php-version.php";
include "../configuration/connection.php";

$supplier = mysql_query('SELECT id_supplier, nama_supplier, no_supplier FROM tabel_supplier');
?>
<select class="form-control" name="id_suplier">
    <option value="0">Tidak ada suplier</option>
    <?php
        while ($result_supplier = mysql_fetch_array($supplier)) {
            echo "<option value='".$result_supplier["id_supplier"]."'>".$result_supplier["nama_supplier"]."|".$result_supplier["no_supplier"]."</option>";
        }
    ?>
</select>
<button class="btn btn-primary" type="button" style="margin-top: 5px" name="btn-supplierBaru">Supplier Baru</button>