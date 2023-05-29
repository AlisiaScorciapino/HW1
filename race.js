//JS di race

function jsonRace(json) {
    console.log(json);

    const container = document.getElementById('results');
    container.innerHTML = '';

    const button = document.createElement('button');
    button.textContent = "Salva";
    container.appendChild(button);
    button.addEventListener('click',save);
    
    button.dataset.data = json.date;
    button.dataset.track = json.track;

    const cont = document.createElement('div');
    container.appendChild(cont);

    const data = document.createElement('p');
    data.textContent = json.date;
    cont.appendChild(data);

    const track = document.createElement('strong');
    track.textContent= json.track;
    cont.appendChild(track);

    

}

function OnResponse(response){
    console.log(response);
    return response.json();
}

function searchRace(event){
    
    const form_data = new FormData(document.querySelector("#search form"));
    // Mando le specifiche della richiesta alla pagina PHP, che prepara la richiesta e la inoltra
    fetch("search_race.php?race_no=" + encodeURIComponent(form_data.get('search'))).then(OnResponse).then(jsonRace);
    // Evito che la pagina venga ricaricata
    event.preventDefault();
}

document.querySelector("#search form").addEventListener("submit", searchRace);
  
function save(event){
    // Preparo i dati da mandare al server e invio la richiesta con POST
    console.log("Salvataggio")

    const card = event.currentTarget.parentNode;
    const formData = new FormData();
    formData.append('data', card.dataset.data);
    formData.append('track', card.dataset.track);
    fetch("save.php", {method: 'post', body: formData}).then(dispatchResponse, dispatchError);
    event.stopPropagation();
  }

  function dispatchResponse(response) {
  
    console.log(response);
    return response.json().then(databaseResponse); 
  }
  
  function dispatchError(error) { 
    console.log("Errore");
  }
  
  function databaseResponse(json) {
    if (!json.ok) {
        dispatchError();
        return null;
    }
}


