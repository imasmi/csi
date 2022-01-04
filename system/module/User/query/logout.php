<?php
unset($_SESSION["id"]);
unset($_SESSION["group"]);
echo '<script>location.href=\'' . \system\Core::url() . '\'</script>';
?>