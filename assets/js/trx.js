function generateTransaction(eventId, ammount) {
paypal
  .Buttons({
    fundingSource: paypal.FUNDING.CARD, // Show only credit card funding source
    createOrder: function (data, actions) {
      return actions.order.create({
        purchase_units: [
          {
            amount: {
              value: ammount,
              currency_code: "USD",
            },
            shipping_preference: "NO_SHIPPING"
          },
        ],
      });
    },
    onApprove: function (data, actions) {
      // Always call capture regardless of the response or status
      return actions.order
        .capture()
        .then(function (details) {

          const transaction = details.purchase_units[0].payments.captures[0];
          // Check if the status is COMPLETED or other
          if (transaction.status === "COMPLETED") {
            alert("Transaccion completada satisfactoriamente.");
            registerTransaction(transaction, eventId);
          } else {
            alert(
              "Tu transaccion no pudo ser completada, status: " + transaction.status + ". Verifica tu balance e intenta de nuevo en unos minutos."
            );
          }
        })
        .catch(function (error) {
          // Handle any error during the capture call
          alert("Error capturando la transaccion, contacte al administrador con este mensaje: " + error.message);
          console.error(error);
          //checkTransactionStatus(data.orderID); // Still check the status
        });
    },
    onError: function (error) {
      alert("Error iniciando transaccion, contacte al administrador con este mensaje: " + error.message);
      console.error("PayPal Button Error:", error);
    },
  })
  .render("#paypal-button-container-"+eventId);

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
    fetch("http://localhost/vesca/VetCapMembers/register_trx.php", {
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
            alert("Transaction registered successfully: " + JSON.stringify(data));
            registerUserToEvent(eventId);
          });
        } else if (response.status === 400) {
          return response.json().then((data) => {
            console.error("Status 400: Bad Request", data);
            alert("Bad Request: " + JSON.stringify(data));
          });
        } else if (response.status === 500) {
          return response.text().then((errorMessage) => {
            console.error("Status 500: Internal Server Error", errorMessage);
            alert("Internal Server Error: " + errorMessage);
          });
        } else {
          console.warn("Unhandled status code:", response.status);
          alert(`Unexpected status code: ${response.status}`);
          return response.text().then((message) => console.log(message));
        }
      })
      .catch((error) => {
        console.error("Error during fetch:", error);
        alert("Failed to register transaction. Please check the server.");
      });
    
  }

  function registerUserToEvent(eventId) {
    const event = {
      event_id: eventId,
    };

    // Send transaction data via POST request
    fetch("http://localhost/vesca/VetCapMembers/register_user_event.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(event),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Response from API:", data);
        alert("User registered on event successfully: " + JSON.stringify(data));

      })
      .catch((error) => {
        console.error("Error registering user:", error);
        alert("Failed to register user on event. Please check the server.");
      });

  }
  
