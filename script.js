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

function addCategory() {
  document.getElementById("add-intervention-category-popup").classList.remove("hidden");
}

function closePopupEditUser() {
  document.getElementById("edit-user-popup").classList.add("hidden");
}

function closeCategoryPopup() {
  document.getElementById("add-intervention-category-popup").classList.add("hidden");
}

function editIntervention(
  id,
  clientId,
  startDate,
  startHour,
  employeeId,
  interventionId,
  longDescription
) {
  document.getElementById("edit-intervention-popup").classList.remove("hidden");

  document.getElementById("edit-id-intervention").value = id;
  document.getElementById("edit-client").value = clientId;
  document.getElementById("edit-startDate").value = startDate; // ✅ format "2025-04-04"
  document.getElementById("edit-startHour").value = startHour; // ✅ format "14:00"
  document.getElementById("edit-employe").value = employeeId;
  document.getElementById("edit-intervention").value = interventionId;
  document.getElementById("edit-longDescription").value = longDescription;
}

function closePopupIntervention() {
  document.getElementById("edit-intervention-popup").classList.add("hidden");
}
