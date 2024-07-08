// const activity = document.querySelector('#disciplines');
// const nbre = document.querySelector('#nbrpers');
// const submit = document.querySelector('#submit');
// const result = document.querySelector('#result');


// submit.addEventListener('click', (e) => {
//   e.preventDefault
//  let activityPrix = activity.value;
//  let nbrePrix = nbre.value;
//  let total = activityPrix * nbrePrix;
//  result.innerHTML = total


// })
// public/js/calculatePrice.js

// document.addEventListener('DOMContentLoaded', function() {
//   const activity = document.querySelector('#disciplines');
//   const nbre = document.querySelector('#nbrpers');
//   const result = document.querySelector('#result');

//   function calculatePrice() {
//       const selectedOption = activity.options[activity.selectedIndex];
//       const activityPrix = parseFloat(selectedOption.dataset.price);
//       const nbrePrix = parseInt(nbre.value);
//       let total = 0;

//       if (selectedOption.text.includes('Coaching') || selectedOption.text.includes('Bien Etre')) {
//           total = activityPrix * nbrePrix;
//           result.value = total.toFixed(2); // Update the price field with the total rounded to 2 decimal places
//       } else if (selectedOption.text.includes('Decouverte') || selectedOption.text.includes('Animation')) {
//           result.value = ''; // Clear the price field
//           alert('Sur devis'); // Display "Sur devis"
//       }
//   }

//   activity.addEventListener('change', calculatePrice);
//   nbre.addEventListener('change', calculatePrice);

//   calculatePrice(); // Initial calculation on page load
// });
document.addEventListener('DOMContentLoaded', function() {
  // Sélection des éléments du formulaire
  const selectActivite = document.getElementById('reservation_form_idDiscipline');
  const selectNbrPersonnes = document.getElementById('reservation_form_nbrPers');
  const inputPrix = document.getElementById('reservation_form_price');

  // Écoute des changements dans les champs
  selectActivite.addEventListener('change', updatePrice);
  selectNbrPersonnes.addEventListener('change', updatePrice);

  // Fonction pour mettre à jour le prix
  function updatePrice() {
      // Récupérer l'option sélectionnée
      const selectedOption = selectActivite.options[selectActivite.selectedIndex];

      // Récupérer le prix de l'activité sélectionnée
      const prix = parseFloat(selectedOption.dataset.prix);

      // Récupérer le nombre de personnes
      const nbrPersonnes = parseInt(selectNbrPersonnes.value);

      // Calculer le prix total
      let prixTotal = prix * nbrPersonnes;

      // Afficher le prix ou un message si le prix est zéro
      if (prixTotal > 0) {
          inputPrix.value = prixTotal.toFixed(2); // Affichage avec deux décimales
      } else {
          inputPrix.value = ''; // Réinitialisation du champ
          inputPrix.placeholder = 'Demande sur devis'; // Message si le prix est zéro
      }
  }
});
