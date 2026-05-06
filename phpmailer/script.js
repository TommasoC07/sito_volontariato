function salvaDati() {
    
    const email = document.getElementById('email').value;
    const nome = document.getElementById('name').value;
    const cognome = document.getElementById('surname').value;
    const donazione = document.getElementById('donation').value;
    const codice = document.getElementById('codice').value;
    
    const regexp = new RegExp("[a-z]");
    const name = new RegExp("[0-9]");
    const regemail = new RegExp("[^]+?@[^]+?\.[^]+", "gi");
    const id = new RegExp("[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]");
    
    let message = "";
    
    if(!regemail.test(email)){
    
        message += "Inserisci un'email corretta";
    
    }
    
    if(regexp.test(donazione)){
    
        message += "\nInserisci importo in modo corretto";
    
    }
    
    if(name.test(nome)){
        
        message += "\nInserisci nome in modo corretto";
        
    }
    
    if(name.test(cognome)){
    
        message += "\nInserisci cognome in modo corretto";
    
    }
    
    if(!id.test(codice)){
        
        message += "\nInserisci codice fiscale in modo corretto";
    
    }
    
    
    if(message==""){
        
        const dati = {
            nome: nome,
            cognome: cognome,
            donation: donazione,
            email: email,
            id: codice
        };
    
        const fileJson = JSON.stringify(dati, null, 2);
        window.alert(fileJson);
        
    }else{
    
        window.alert(message);
    }
    
    
    /*const blob = new Blob([fileJson], {type: 'application/json'});
    
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'utenti.json';
    link.click();
    URL.revokeObjectURL(link.href);*/
 }
 
 function writeTable(){
     
     const email = document.getElementById('emaillog').value;
     const password = document.getElementById('password').value;
     
     
     
     if(email=="prova@mail.com"){
        document.getElementById('nametable').innerHTML= "Prova";
       
     }
     
     
     
     
     
     
     
 }