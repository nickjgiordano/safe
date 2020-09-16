// toggles product page side menus to and from collapsed state
function menu_toggle(hide, show) {
	document.getElementById(hide).style.visibility='hidden';
	document.getElementById(show).style.visibility='visible';
}
// validates user registration data entry
function validation() {
	// pattern variables to be searched for
	var chars = /[ `!@#$%^&*()+\=\[\]{};':"\\|,<>\/?~]/;
	var phone = /^\d{11}$/;
	
	// checks that disallowed characters aren't in entered username
	var username = document.getElementById('username').value;
	if(chars.test(username) || !username) {
		document.getElementById('username').focus();
		document.getElementById('username').select();
		return false;
	}
	
	// checks that entered phone number is only numerical, and exactly 11 digits
	if( !document.getElementById('phone').value.match(phone) ) {
		document.getElementById('phone').focus();
		document.getElementById('phone').select();
		return false;
	}
	
	// checks that entered email contains "@" symbol, and DOESN'T contain disallowed characters
	var email = document.getElementById('email').value;
	if(email.search('@') > 0) {
		email_start = email.substring(0, email.search('@') );
		email_end = email.substring(email.search('@')+1, email.length);
		if(chars.test(email_start) || !email_start || chars.test(email_end) || !email_end) {
			document.getElementById('email').focus();
			document.getElementById('email').select();
			return false;
		}
	}
	else {
		document.getElementById('email').focus();
		document.getElementById('email').select();
		return false;
	}
	
	// checks that entered passwords match, and is at least 8 characters
	var password1 = document.getElementById('password').value;
	var password2 = document.getElementById('retype').value;
	if( chars.test(password1) || password1.length < 8 == true) {
		document.getElementById('password').value = '';
		document.getElementById('retype').value = '';
		document.getElementById('password').focus();
		document.getElementById('password').select();
		return false;
	}
	if(password1 != document.getElementById('retype').value && password2) {
		document.getElementById('password').value = '';
		document.getElementById('retype').value = '';
		document.getElementById('password').focus();
		document.getElementById('password').select();
		return false;
	}
}