

function copypaste(id) {
	var copyText = document.getElementById(id);
	document.getElementById("search-id").value = copyText.value;
	document.getElementById("search-id2").value = copyText.value;

	/* Select the text field */
	copyText.select();
	copyText.setSelectionRange(0, 99999); /* For mobile devices */
	document.execCommand("copy");
	alert("ID Copied!");
}
function copyFunction(id) {
	copypaste(id);
}

