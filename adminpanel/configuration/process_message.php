<?php

//penghapusan
function del_success()
{ echo "<div class='alert alert-danger'>
  <strong>Success!</strong> Data berhasil dihapus. 
</div>"; }

//update
function update_success()
{ echo "<div class='alert alert-success'>
  <strong>Success!</strong> Data telah diupdate.
</div>"; 
}

//moving
function moving_success($moving_ke)
{ echo "<div class='alert alert-success'>
  <strong>Success!</strong> $moving_ke.
</div>"; 
}

function moving_fail($moving_ke)
{ echo "<div class='alert alert-danger'>
  <strong>Success!</strong> $moving_ke.
</div>"; 
}



function update_password_success()
{ echo "<div class='alert alert-success'>
  <strong>Success!</strong> Password telah diupdate. <span style='float:right'><a href='http://localhost/indosat/profile'>Kembali</a></span>
</div>"; }
function update_fail()
{ echo "<div class='alert alert-danger'>
  <strong>Success!</strong> Data gagal diupdate.
</div>"; }
//add
function add_success()
{ echo "<div class='alert alert-success'>
  <strong>Success!</strong> Data telah tersimpan.
</div>"; }
function add_fail()
{ echo "<div class=warning>Maaf, data gagal disimpan. Silakan ulangi beberapa saat lagi.</div><br />"; }
//delete image
//email salah
function wrong_mail()
{ echo "<div class='alert alert-warning'><strong>Warning!</strong> Email telah terdaftar.</div>"; }

function wrong_employee()
{ echo "<div class='alert alert-warning'><strong>Warning!</strong> Employee ID telah terdaftar.</div>"; }

function wrong_employeeid()
{ echo "<div class='alert alert-danger'><strong>Warning!</strong> Employee ID salah / tidak terdaftar.</div>"; }


function exist($field)
{ echo "<div class=warning>Maaf, pilihan <b>$field</b> sudah ada. Silakan pilih <b>$field</b> yang lain.</div><br />"; }
?>