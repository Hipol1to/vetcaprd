paypal
  .Buttons({
    fundingSource: paypal.FUNDING.CARD, // Show only credit card funding source
    createOrder: function (data, actions) {
      return actions.order.create({
        purchase_units: [
          {
            amount: {
              value: 5.0,
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
            registerTransaction(transaction);
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
  .render("#paypal-button-container");

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

  function registerTransaction(transaction) {
    // Extract transaction details
    const transactionData = {
      id: transaction.id,
      status: transaction.status,
      currency_code: transaction.amount.currency_code,
      value: transaction.amount.value,
      seller_protection_status: transaction.seller_protection.status,
      dispute_categories: JSON.stringify(transaction.seller_protection.dispute_categories), // Handle array or object
      create_time: transaction.create_time,
      update_time: transaction.update_time,
    };
  
    // Send transaction data via POST request
    fetch("http://localhost/penpal/endpoint.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(transactionData),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Response from API:", data);
        alert("Transaction registered successfully: " + JSON.stringify(data));
      })
      .catch((error) => {
        console.error("Error registering transaction:", error);
        alert("Failed to register transaction. Please check the server.");
      });
  }
  
