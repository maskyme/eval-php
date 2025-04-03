// Fontion pour éditer les employés
function editUser(id, lastName, firstName, phone, email, adress, id_category) {
  document.getElementById("edit-user-popup").classList.remove("hidden");

  document.getElementById("edit-id-user").value = id;
  document.getElementById("edit-lastName-user").placeholder = lastName;
  document.getElementById("edit-firstName-user").placeholder = firstName;
  document.getElementById("edit-phone-user").placeholder = phone;
  document.getElementById("edit-mail-user").placeholder = email;
  document.getElementById("edit-adress-user").placeholder = adress;
  document.getElementById("edit-category-user").value = id_category;
}

function closePopupEditUser() {
  document.getElementById("edit-user-popup").classList.add("hidden");
}

function editClient(
  id,
  lastName,
  firstName,
  phone,
  email,
  adress,
  id_category
) {
  document.getElementById("edit-user-popup").classList.remove("hidden");

  document.getElementById("edit-id-user").value = id;
  document.getElementById("edit-lastName-user").placeholder = lastName;
  document.getElementById("edit-firstName-user").placeholder = firstName;
  document.getElementById("edit-phone-user").placeholder = phone;
  document.getElementById("edit-mail-user").placeholder = email;
  document.getElementById("edit-adress-user").placeholder = adress;
}

function closePopupEditClient() {
  document.getElementById("edit-user-popup").classList.add("hidden");
}
