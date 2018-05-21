function alertBanner(hideOrshow) {
  if (hideOrshow == 'hide') {
    localStorage.setItem("alertWasShown",1);
    document.getElementById('alertBanner').style.display = "none";
  }
  else if(localStorage.getItem("alertWasShown") == null) {
    document.getElementById('alertBanner').removeAttribute('style');
  }
}

jQuery(function($) {
	window.onload = function () {
    setTimeout(function () {
      alertBanner('show');
    }, 0);
	}
});
