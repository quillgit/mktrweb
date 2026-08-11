
<?php
    include "../parser-php-version.php";
    include "../configuration/connection.php";
    $subcategory = mysql_query('SELECT id_sub_kategori , id_kategori, sub_kategori FROM tabel_produk_sub_kategori WHERE id_kategori = "'.$_POST['id'].'"');
    if (mysql_num_rows($subcategory)!=0) {
?>
    <label for="data-name">Kategori Sub Produk</label>
    <select class="form-control" name="subcategory">
        <?php
            while ($result_subcategory = mysql_fetch_array($subcategory)) {
                echo "<option value='".$result_subcategory["id_sub_kategori"]."'>".$result_subcategory["sub_kategori"]."</option>";
            }
        ?>
    </select>
<?php } ?>