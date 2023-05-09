document.addEventListener("DOMContentLoaded", function () {
  const searchForm = document.getElementById("search-form");
  const searchResults = document.getElementById("search-results");
  const hotelDetail = document.getElementById("hotel-detail");

  if (searchForm) {
    searchForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(searchForm);
      fetch("search.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          const queryString = new URLSearchParams(formData).toString();
          window.location.href = `search_results.html?${queryString}`;
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(error => {
        console.error("Error:", error);
      });
    });
  }

  if (searchResults) {
    const urlParams = new URLSearchParams(window.location.search);
    fetch("search.php?" + urlParams.toString())
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          if (data.results.length > 0) {
            data.results.forEach(hotel => {
              const hotelDiv = document.createElement("div");
              hotelDiv.innerHTML = `<h2><a href="hotel_detail.html?id=${hotel.id}">${hotel.name}</a></h2><p>${hotel.address}, ${hotel.city}</p><p>Rating: ${hotel.rating}</p><button data-hotel-id="${hotel.id}" class="book-room-button">Book a room</button>`;
              searchResults.appendChild(hotelDiv);
            });
            const bookRoomButtons = document.querySelectorAll('.book-room-button');
            bookRoomButtons.forEach(button => {
              button.addEventListener('click', function(event) {
                const hotelId = event.target.getAttribute('data-hotel-id');
                window.location.href = `booking.html?hotel_id=${hotelId}`;
              });
            });
          } else {
            const noResultsMessage = document.createElement("p");
            noResultsMessage.textContent = "No hotels available for the given search criteria.";
            searchResults.appendChild(noResultsMessage);
          }
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(error => {
        console.error("Error:", error);
      });
  }

  const bookingForm = document.getElementById("booking-form");

  if (bookingForm) {
    const urlParams = new URLSearchParams(window.location.search);
    const hotelId = urlParams.get('hotel_id');
    if (hotelId) {
      const hotelIdInput = document.getElementById('hotel-id');
      hotelIdInput.value = hotelId;
      getRoomTypes(hotelId);
    }
    bookingForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(bookingForm);
      fetch("book_room.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Room booked successfully!");
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(error => {
        console.error("Error:", error);
      });
    });
  }

  // const hotelId = getHotelIdFromUrl();
  //     if (hotelId) {
  //         getHotelDetails(hotelId);
  //     }
  const hotelId = new URLSearchParams(window.location.search).get("id");
      if (hotelId) {
        getHotelDetails(hotelId);
      }
      initializeLoginForm();
      initializeRegisterForm();
});

function getRoomTypes(hotelId) {
  console.log("hotelId:", hotelId);
  fetch(`get_room_types.php?hotel_id=${hotelId}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        populateRoomTypes(data.result);
        populateHotelDetails(data.result[0]);
      } else {
        console.error("Failed to fetch room types:", data.message);
      }
    })
    .catch(error => {
      console.error("Error fetching room types:", error);
    });
}

function populateRoomTypes(roomTypes) {
  const roomTypeSelect = document.getElementById("room-type");
  roomTypes.forEach(roomType => {
    const option = document.createElement("option");
    option.value = roomType.id;
    option.textContent = `${roomType.room_type} - $${roomType.price} per night`;
    roomTypeSelect.appendChild(option);
  });
}

function populateHotelDetails(hotel) {
  const hotelName = document.getElementById("hotel-name");
  const hotelAddress = document.getElementById("hotel-address");
  const hotelCity = document.getElementById("hotel-city");
  const hotelRating = document.getElementById("hotel-rating");
  const hotelIdInput = document.getElementById("hotel-id");

  hotelName.textContent = hotel.name;
  hotelAddress.textContent = hotel.address;
  hotelCity.textContent = hotel.city;
  hotelRating.textContent = `Rating: ${hotel.rating}`;
  hotelIdInput.value = hotel.id;
}

//   function getHotelDetails(hotelId) {
//     fetch(`hotel-detail.php?id=${hotelId}`)
//       .then(response => response.json())
//       .then(data => {
//         if (data.success) {
//           const hotel = data.result;
//           const hotelDiv = document.createElement("div");
//           hotelDiv.innerHTML = `
//             <h2>${hotel.name}</h2>
//             <p>${hotel.address}, ${hotel.city}</p>
//             <p>Rating: ${hotel.rating}</p>
//             <h3>Rooms</h3>
//             <ul id="room-types"></ul>
//           `;
//           hotelDetail.appendChild(hotelDiv);

//           const roomTypesList = document.getElementById("room-types");
//           getRoomTypes(hotelId).then(roomTypes => {
//             roomTypes.forEach(roomType => {
//               const listItem = document.createElement("li");
//               listItem.textContent = `${roomType.room_type} - $${roomType.price} per night`;
//               roomTypesList.appendChild(listItem);
//             });
//           });
//         } else {
//           alert("Error: " + data.message);
//         }
//       })
//       .catch(error => {
//         console.error("Error:", error);
//       });
//   }

function getHotelDetails(hotelId) {
  fetch(`hotel_detail.php?id=${hotelId}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const hotel = data.result;
        populateHotelDetails(hotel);
        getRoomTypes(hotelId);
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch(error => {
      console.error("Error:", error);
    });
}

function submitBookingForm(event) {
  event.preventDefault();

  const hotelId = document.getElementById("hotel-id").value;
  const roomType = document.getElementById("room-type").value;
  const checkInDate = document.getElementById("check-in-date").value;
  const checkOutDate = document.getElementById("check-out-date").value;
  const username = document.getElementById("username").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  const formData = new FormData();
  formData.append("room-id", roomType);
  formData.append("check-in-date", checkInDate);
  formData.append("check-out-date", checkOutDate);
  formData.append("username", username);
  formData.append("email", email);
  formData.append("password", password);

  fetch("process_booking.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.text())
    .then(text => {
      console.log(text);
      alert("Reservation successfully made.");
    })
    .catch(error => {
      console.error("Error:", error);
    });
}

const bookingFormElement = document.getElementById("booking-form-element");
if (bookingFormElement) {
  bookingFormElement.addEventListener("submit", submitBookingForm);
}
// Existing code ...

// Add the following code for login and registration forms

document.getElementById("login-form").addEventListener("submit", function (event) {
  event.preventDefault();

  const email = document.getElementById("login-email").value;
  const password = document.getElementById("login-password").value;

  const formData = new FormData();
  formData.append("email", email);
  formData.append("password", password);

  fetch("process_login.php", {
      method: "POST",
      body: formData,
  })
      .then((response) => response.text())
      .then((result) => {
          if (result === "success") {
              window.location.href = "user_account.html";
          } else {
              alert("Invalid email or password");
          }
      })
      .catch((error) => {
          console.error("Error:", error);
      });
});

document.getElementById("register-form").addEventListener("submit", function (event) {
  event.preventDefault();

  const username = document.getElementById("register-username").value;
  const email = document.getElementById("register-email").value;
  const password = document.getElementById("register-password").value;

  const formData = new FormData();
  formData.append("username", username);
  formData.append("email", email);
  formData.append("password", password);

  fetch("process_registration.php", {
      method: "POST",
      body: formData,
  })
      .then((response) => response.text())
      .then((result) => {
          if (result === "success") {
              window.location.href = "user_account.html";
          } else {
              alert("Error: " + result);
          }
      })
      .catch((error) => {
          console.error("Error:", error);
      });
});

// End of the new code
function initializeLoginForm() {
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const email = document.getElementById("login-email").value;
      const password = document.getElementById("login-password").value;

      const formData = new FormData();
      formData.append("email", email);
      formData.append("password", password);

      fetch("process_login.php", {
          method: "POST",
          body: formData,
      })
          .then((response) => response.text())
          .then((result) => {
              if (result === "success") {
                  window.location.href = "user_account.html";
              } else {
                  alert("Invalid email or password");
              }
          })
          .catch((error) => {
              console.error("Error:", error);
          });
          return false;
    });
  }
}

function initializeRegisterForm() {
  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const username = document.getElementById("register-username").value;
      const email = document.getElementById("register-email").value;
      const password = document.getElementById("register-password").value;

      const formData = new FormData();
      formData.append("username", username);
      formData.append("email", email);
      formData.append("password", password);

      fetch("process_registration.php", {
          method: "POST",
          body: formData,
      })
          .then((response) => response.text())
          .then((result) => {
              if (result === "success") {
                  window.location.href = "user_account.html";
              } else {
                  alert("Error: " + result);
              }
          })
          .catch((error) => {
              console.error("Error:", error);
          });
          return false;
    });
  }
}

// ...
function displayReservations(reservations) {
  const reservationsContainer = document.createElement("div");
  reservationsContainer.classList.add("reservations-container");

  const reservationsTitle = document.createElement("h2");
  reservationsTitle.textContent = "Your Reservations:";
  reservationsContainer.appendChild(reservationsTitle);

  if (reservations.length === 0) {
    const noReservations = document.createElement("p");
    noReservations.textContent = "You have no reservations.";
    reservationsContainer.appendChild(noReservations);
  } else {
    reservations.forEach((reservation) => {
      const reservationItem = document.createElement("div");
      reservationItem.classList.add("reservation-item");

      const reservationDetails = document.createElement("p");
      reservationDetails.innerHTML = `Reservation ID: ${reservation.id}<br> Room ID: ${reservation.room_id}<br> Check-in: ${reservation.check_in}<br> Check-out: ${reservation.check_out}`;
      reservationItem.appendChild(reservationDetails);

      reservationsContainer.appendChild(reservationItem);
    });
  }

  return reservationsContainer;
}

function initializeUserAccount() {
  const userAccountPage = document.getElementById("user-account-page");
  if (userAccountPage) {
    fetch("get_user_data.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          const userEmail = document.createElement("p");
          userEmail.textContent = "Email: " + data.email;
          userAccountPage.appendChild(userEmail);

          const reservationsContainer = displayReservations(data.reservations);
          userAccountPage.appendChild(reservationsContainer);
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
}
// ...
