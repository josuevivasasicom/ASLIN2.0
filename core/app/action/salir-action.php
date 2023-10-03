<?php
session_destroy();

echo '<script>
	localStorage.clear();
	window.location= "./index.php?";
</script>';