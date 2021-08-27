<?php
unset($_SESSION["id"]);
unset($_SESSION["role"]);
echo '<script>location.href=\'' . $Core->url() . '\'</script>';
?>