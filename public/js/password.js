function onView(pass, elem) {
	const password = document.querySelector(pass);
	const type =
		password.getAttribute("type") === "password" ? "text" : "password";
	password.setAttribute("type", type);
	elem.classList.toggle("bi-eye");
}

function onViewDelay(pass, elem) {
	const password = document.querySelector(pass);
	const type =
		password.getAttribute("type") === "password" ? "text" : "password";
	password.setAttribute("type", type);
	elem.classList.toggle("bi-eye");

	setTimeout(() => {
		password.getAttribute("type") === "password" ? "text" : "password";
		password.setAttribute("type", "password");
		elem.classList.toggle("bi-eye");
	}, 3000);
}
