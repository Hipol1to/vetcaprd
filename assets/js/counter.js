function updateCountdown(eventId, timestamp) {
  // Replace the space with 'T' to match the desired format
  let dateString = ""+timestamp;
  const formattedTimestampString = dateString.replace(" ", "T");
  newTimestamp = new Date(formattedTimestampString).getTime();
  const now = new Date().getTime();
  const timeLeft = newTimestamp - now;

  if (timeLeft <= 0) {
    document.getElementById("countdown-"+eventId).innerHTML = "Tiempo agotado!";
    clearInterval(timerInterval);
    return;
  }

  // Calculate time units
  const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
  const hours = Math.floor(
    (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

  // Update the DOM 
  document.getElementById("days-"+eventId).textContent = days
    .toString()
    .padStart(2, "0");
  document.getElementById("hours-"+eventId).textContent = hours
    .toString()
    .padStart(2, "0");
  document.getElementById("minutes-"+eventId).textContent = minutes
    .toString()
    .padStart(2, "0");
  document.getElementById("seconds-"+eventId).textContent = seconds
    .toString()
    .padStart(2, "0");
}