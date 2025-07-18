function generateTransaction(eventId, ammount) {
  let ammountConverted = ammount / 61.50;
  let extraFee = ammountConverted * 0.05;
  let ammountToCharge = extraFee + ammountConverted;

  let paypalButtonContainer = document.getElementById("paypal-button-container-" + eventId);

  // Hide the button container before PayPal initializes
  paypalButtonContainer.style.display = "none"; 

  paypal
      .Buttons({
          fundingSource: paypal.FUNDING.CARD, // Show only credit card funding source
          createOrder: function (data, actions) {
              return actions.order.create({
                  purchase_units: [
                      {
                          amount: {
                              value: parseFloat(ammountToCharge).toFixed(2),
                              currency_code: "USD",
                          },
                          shipping_preference: "NO_SHIPPING"
                      },
                  ],
              });
          },
          onApprove: function (data, actions) {
              return actions.order
                  .capture()
                  .then(function (details) {
                      const transaction = details.purchase_units[0].payments.captures[0];

                      if (transaction.status === "COMPLETED") {
                          registerTransaction(transaction, eventId);
                      } else {
                          alert(
                              "Tu transacción no pudo ser completada, status: " + transaction.status + ". Verifica tu balance e intenta de nuevo en unos minutos."
                          );
                      }
                  })
                  .catch(function (error) {
                      alert("Error capturando la transacción, contacte al administrador con este mensaje: " + error.message);
                      console.error(error);
                  });
          },
          onError: function (error) {
              alert("Error iniciando transacción, contacte al administrador con este mensaje: " + error.message);
              console.error("PayPal Button Error:", error);
          },
          onInit: function (data, actions) {
              // Show the button container only when PayPal is ready
              paypalButtonContainer.style.display = "block";
          }
      })
      .render("#paypal-button-container-" + eventId);
}

  function printTransaction(transaction) {
    let result = "";
    for (let key in transaction) {
      if (typeof transaction[key] === "object" && transaction[key] !== null) {
        result += `${key}: ${JSON.stringify(transaction[key], null, 2)}\n`;
      } else {
        result += `${key}: ${transaction[key]}\n`;
      }
    }
    alert(result);
  }

  function registerTransaction(transaction, eventId) {
    // Extract transaction details
    const transactionData = {
      id: transaction.id,
      eventId: eventId,
      status: transaction.status,
      currency_code: transaction.amount.currency_code,
      value: transaction.amount.value,
      seller_protection_status: transaction.seller_protection.status,
      dispute_categories: JSON.stringify(transaction.seller_protection.dispute_categories), // Handle array or object
      create_time: transaction.create_time,
      update_time: transaction.update_time,
    };
  
    // Send transaction data via POST request
    fetch("http://localhost/vescaprod/VetCapMembers/register_trx.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(transactionData),
    })
      .then((response) => {
        if (response.status === 200) {
          return response.json().then((data) => {
            console.log("Status 200: Success", data);
            //alert("Transaccion registrada correctamente");
            let transactionToken = data.trxToken;
            registerUserToEvent(eventId, transactionToken);
          });
        } else if (response.status === 400) {
          return response.json().then((data) => {
            console.error("Status 400: Bad Request", data);
            alert("Lo sentimos, tu solicitud no pudo ser procesada, por favor contacta al administrador con este mensaje: " + JSON.stringify(data));
          });
        } else if (response.status === 500) {
          return response.text().then((errorMessage) => {
            console.error("Status 500: Internal Server Error", errorMessage);
            alert("Lo sentimos, el servicio no está disponible, por favor contacta al administrador con este mensaje:" + errorMessage);
          });
        } else {
          console.warn("Unhandled status code:", response.status);
          alert(`Ha ocurrido un error inesperado, por favor contacta al administrador con este mensaje: ${response.status}`);
          return response.text().then((message) => console.log(message));
        }
      })
      .catch((error) => {
        console.error("Error during fetch:", error);
        alert("Ha ocurrido un error durante tu solicitud, por favor contacta al administrador con este mensaje. \n"+error);
      });
    
  }

  function registerUserToEvent(eventId, trxToken) {
    const event = {
      event_id: eventId,
      trx_token: trxToken,
    };

    // Send transaction data via POST request
    fetch("http://localhost/vescaprod/VetCapMembers/register_user_event.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(event),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Response from API:", data);
        setTimeout(() => {
          if (confirm("Evento suscrito satisfactoriamente, la pagina se actualizara automaticamente en unos segundos")) {
            console.log("User confirmed the action.");
            setTimeout(() => {
              console.log("User deffinitely confirmed the action.");
              location.reload();
            }, 500); // Delays the reload by 1 second
          } else {
            console.log("User canceled the action.");
            alert("Evento suscrito satisfactoriamente, la pagina se actualizara automaticamente en unos segundos");
            setTimeout(() => {
              console.log("User subscribed.");
              location.reload();
            }, 5000); // Delays the reload by 1 second
          }
        }, 0); // Delay added to make sure it works consistently

      })
      .catch((error) => {
        console.error("Error registering user:", error);
        alert("Failed to register user on event. Please check the server.");
      });

  }
  
