paypal
  .Buttons({
    createOrder: function (data, actions) {
      return actions.order.create({
        purchase_units: [
          {
            amount: {
              value: 5.0,
              currency_code: "USD",
            },
          },
        ],
      });
    },
    onApprove: function (data, actions) {
      // Always call capture regardless of the response or status
      console.log("wayayayayayay");

      checkTransactionStatus(data.orderID);
      return actions.order
        .capture()
        .then(function (details) {
          console.log("el den wayayayayayay");

          const transaction = details.purchase_units[0].payments.captures[0];
          console.log("osker la tenemo");
          checkTransactionStatus(data.orderID); // Call the function to handle status

          // Check if the status is COMPLETED or other
          if (transaction.status === "COMPLETED") {
            alert("Transaction completed successfully.");
          } else {
            alert(
              "Transaction status: " + transaction.status + ". Please verify."
            );
          }
        })
        .catch(function (error) {
          // Handle any error during the capture call
          alert("Error capturing the transaction: " + error.message);
          console.error(error);
          checkTransactionStatus(data.orderID); // Still check the status
        });
    },
    onError: function (error) {
      alert("Error during PayPal flow: " + error.message);
      console.error("PayPal Button Error:", error);
    },
  })
  .render("#paypal-button-container");

function checkTransactionStatus(orderID) {
  console.log("pos fijese kentramo");

  // Example API call (you should set up a server-side handler for this request)
  fetch(`http://localhost/penpal/endpoint.php?orderID=${orderID}`)
    .then((response) => response.json())
    .then((data) => {
      console.log("Transaction details from API:", data);
      alert("Transaction details: " + JSON.stringify(data));
    })
    .catch((error) => {
      console.error("Error fetching transaction status:", error);
      alert(
        "Failed to fetch transaction status. Please check the server endpoint."
      );
    });
}
