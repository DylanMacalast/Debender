// Create a request variable and assign a new XMLHttpRequest object to it.
var request = new XMLHttpRequest()

// Open a new connection, using the GET request on the URL endpoint
request.open('GET', 'http://localhost:8888/projects/debender/api/product/read.php', true)

request.onload = function(){
  // Begin accessing JSON data here
    var data = JSON.parse(this.response)

    if (request.status >=200 && request.status < 400) {

        // loop through json object and get title
        for (var key in data) {
            if(data.hasOwnProperty(key)){
                
                var title = data[key][0].Title;
                console.log(title);
            }
        }

        var div = document.getElementById('root');
        div.innerHTML = '<h1 id="title" style="display: none;">'+title+'</h1>';


    } else {
        console.log('error')
    }

}




request.send();
var button = document.getElementById('btn');
button.addEventListener("click", function(e) {
var title = document.getElementById('title');
    title.style.display = "block";
}, false);


