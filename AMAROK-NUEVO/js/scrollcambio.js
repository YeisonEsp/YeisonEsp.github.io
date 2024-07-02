window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("scrollBtn").style.display = "block";
    } else {                                                                            //ESTE JS ES PARA QUE SE MUESTRE UN BOTÓN CUANDO SE HACE SCROLL EN EL LANDING PAGE
    document.getElementById("scrollBtn").style.display = "none";
    }
}

function scrollToTop() {
  document.body.scrollTop = 0; // Para navegadores Safari
  document.documentElement.scrollTop = 0; // Para otros navegadores
}