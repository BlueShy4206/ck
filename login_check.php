<?php
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['MM_Username'] == NULL){
		
?>
<script>
 alert("您沒有權限查看此頁面!!"); 
 document.location.href=".";
</script>
<?php }?>