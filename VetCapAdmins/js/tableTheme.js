function setTableTheme(theTheme) {
    let emailsTable = document.getElementById("emailsTable");
    let addressListEmailTable = document.getElementById("adressListTable");
    let messageTable = document.getElementById("theEmailsTable");
    
    if (theTheme === 'dark' && emailsTable && emailsTable.classList && !emailsTable.classList.contains('table-dark')) {
    emailsTable.classList.add('table-dark');
  }
  if (theTheme === 'light' && emailsTable && emailsTable.classList && emailsTable.classList.contains('table-dark')) {
    emailsTable.classList.remove('table-dark');
  }
  if (theTheme === 'auto') {        
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
      if(emailsTable && emailsTable.classList && !emailsTable.classList.contains('table-dark')) {
         emailsTable.classList.add('table-dark');
      }
    } else {
      if(emailsTable && emailsTable.classList && emailsTable.classList.contains('table-dark')) {
        emailsTable.classList.remove('table-dark');
      }
      }
  }
  
  
  if (theTheme === 'dark' && addressListEmailTable && addressListEmailTable.classList && !addressListEmailTable.classList.contains('table-dark')) {
    addressListEmailTable.classList.add('table-dark');
  }
  if (theTheme === 'light' && addressListEmailTable && addressListEmailTable.classList && addressListEmailTable.classList.contains('table-dark')) {
    addressListEmailTable.classList.remove('table-dark');
  }
  if (theTheme === 'auto') {        
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
      if(addressListEmailTable && addressListEmailTable.classList && !addressListEmailTable.classList.contains('table-dark')) {
         addressListEmailTable.classList.add('table-dark');
      }
    } else {
      if(addressListEmailTable && addressListEmailTable.classList && addressListEmailTable.classList.contains('table-dark')) {
        addressListEmailTable.classList.remove('table-dark');
      }
      }
  }
  
  
  if (theTheme === 'dark' && messageTable && messageTable.classList && !messageTable.classList.contains('table-dark')) {
    messageTable.classList.add('table-dark');
  }
  if (theTheme === 'light' && messageTable && messageTable.classList && messageTable.classList.contains('table-dark')) {
    messageTable.classList.remove('table-dark');
  }
  if (theTheme === 'auto') {        
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
      if(messageTable && messageTable.classList && !messageTable.classList.contains('table-dark')) {
         messageTable.classList.add('table-dark');
      }
    } else {
      if(messageTable && messageTable.classList && messageTable.classList.contains('table-dark')) {
        messageTable.classList.remove('table-dark');
      }
      }
  }
  }