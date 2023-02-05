/* gestion des mails */

/**
 * isValide
 *
 * @return void
 */
function isValideMail(mail, min = 6, max = 32) {
	let msg = "";
	let validRegex =
		/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

	if (!mail.match(validRegex)) {
		msg = "Format mail invalide!";
	}
	if (mail.length <= min) {
		msg = "Mail trop court!";
	}
	if (mail.length >= max) {
		msg = "Mail trop long!";
	}
	if (mail.length == 0) {
		msg = "Mail vide!";
	}
	return msg;
}

/**
 * onValidateMail
 *
 * @return void
 */
function onValidateMail(form, id) {
	let error_msg = document.getElementById(id);
	let mail = form.mail.value;
	let err = isValideMail(mail);
	if (err == "") {
		form.submit();
	} else {
		error_msg.innerText = err;
		error_msg.classList.toggle("collapse");
		setTimeout(() => {
			error_msg.classList.toggle("collapse");
		}, 2000);
	}
}
