const activity = document.querySelector('#disciplines');
const nbre = document.querySelector('#nbrpers');
const submit = document.querySelector('#submit');
const result = document.querySelector('#result');


submit.addEventListener('click', (e) => {
  e.preventDefault
 let activityPrix = activity.value;
 let nbrePrix = nbre.value;
 let total = activityPrix * nbrePrix;
 result.innerHTML = total


})
public/js/calculatePrice.js

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
