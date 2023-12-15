function checkPasswords() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    if (password !== confirm_password) {
      alert("Wachtwoorden komen niet overeen!");
      return false;
    }
    return true;
  }