

var container = document.querySelector(".container");

var body = document.querySelector("body");

var pageToggle = document.querySelector("#page-toggle");

pageToggle.addEventListener('click', function(event){
    event.preventDefault();
    if(body.classList.contains("about--open")){
        body.classList.remove("about--open");
        pageToggle.href = "#about";
        pageToggle.innerHTML = "About";
    }else{
        body.classList.add("about--open");
        pageToggle.href = "#about";
        pageToggle.innerHTML = "Information";
    }
  });



