<script>
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="<?= $defaultText ?>";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("txtHint").innerHTML=this.responseText;
	  console.log=this.responseText
    }
  }
  xmlhttp.open("GET","<?= BASE_URL.$modname ?>/getUser/"+str,true);
  xmlhttp.send();
}
</script>

<div class="container">
	<form>
	<select name="users" onchange="showUser(this.value)">
		<option value="">Select a person:</option>
	<?php foreach($rows as $row) { ?>
		<option value="<?= $row->id ?>"><?= $row->firstname ?> <?= $row->lastname ?></option>
	<?php }?>
	</select>
	</form>
	<br>
	<div id="txtHint"><?= $defaultText ?></div>
</div>