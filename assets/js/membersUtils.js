function toggleFields(modalId) {
    let metodoDePagoModal = document.getElementById("metodo_de_pago_"+modalId); 
    const selectedOption = metodoDePagoModal.value;
    const eventPrice = metodoDePagoModal.getAttribute("amountRd");
    console.log(modalId);
    console.log(eventPrice);
    

    let comprobanteDePagoContainer = document.getElementById("comprobante_pago_field_container_"+modalId);
    let inscribirButton = document.getElementById("inscribir_button_"+modalId);
    let paypalButtonContainer = document.getElementById("paypal-button-container-"+modalId);


    // Hide all fields initially
    comprobanteDePagoContainer.classList.add("hidden");
    inscribirButton.classList.add("hidden");
    paypalButtonContainer.classList.add("hidden");

    // Show the relevant field based on the selected option
    if (selectedOption === "Transferencia") {
      if (comprobanteDePagoContainer.classList.contains("hidden")) {
        comprobanteDePagoContainer.classList.remove("hidden");
        if (inscribirButton.classList.contains("hidden")) {
          inscribirButton.classList.remove("hidden");
        }
      }
    } else if (selectedOption === "Tarjeta") {
      if (paypalButtonContainer.classList.contains("hidden")) {
        paypalButtonContainer.classList.remove("hidden"); 
      }      
      for (let i = 0; i < window.isTrxRunning.length; i++) {
        console.log("verifying start transaction for: "+window.isTrxRunning[i][0]);
        console.log("verifying start transaction for: "+window.isTrxRunning[i][1]);
        if (window.isTrxRunning[i][0] === modalId && window.isTrxRunning[i][1] === 0 && window.isTrxRunning[i][0] != undefined && window.isTrxRunning[i][1] != undefined) {
        console.log("starting transaction for: "+modalId);
        
        generateTransaction(modalId, parseFloat(eventPrice).toFixed(2));
        //isTrxRunning = true;
        window.isTrxRunning[i][1] = 1;
        console.log("is there a transaction running?: "+window.isTrxRunning[i][1]);
      } 
      }
    }
  }

  function openMyEventsModal() {
    document.getElementById('my-events-modal').style.display = 'flex';
  }

  function closeMyEventsModal() {
    document.getElementById('my-events-modal').style.display = 'none';
  }

  function unsubscribeEvent(eventId) {
    if(confirm("¿Estás seguro que quieres desinscribir este evento?")) {
        const event = {
            event_id: eventId,
          };
      
          // Send transaction data via POST request
          fetch("http://localhost/vesca/VetCapMembers/unsubscribe_user_event.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(event),
          })
            .then((response) => response.json())
            .then((data) => {
              console.log("Response from API:", data);
              if(confirm("El evento fue desuscrito correctamente.")) {
                location.reload(true);
              } else {
                location.reload(true);
              }
            })
            .catch((error) => {
              console.error("Error registering user:", error);
              alert("Hubo un error al desinscribir tu evento, contacta al administrador con este mensaje: "+error);
            });
    }
  }