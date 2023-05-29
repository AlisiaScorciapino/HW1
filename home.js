//file js di api home notizie

function JsonNews(json){
    console.log(json);

    const container = document.getElementById('results');
    container.innerHTML = '';

    for(let i=0; i<json.length; i++){
        console.log(json[i]);

        const cont = document.createElement('div');
        container.appendChild(cont);

        const title = document.createElement('strong');
        title.innerHTML = json[i].title;
        cont.appendChild(title);

        const link = document.createElement('element');//verifica
        link.url = json[i].url;
        cont.appendChild(link);

    }

}
    


function OnResponseNews(response){

    console.log(response);
    return response.json();
}


function search(){
    // Mando le specifiche della richiesta alla pagina PHP, che prepara la richiesta e la inoltra
    fetch("search_news.php?").then(OnResponseNews).then(JsonNews);
}

search();

  
  