var flechita;
var ubicacionenc;
$(document).ready(function(){
    flechita = document.getElementById("flechita-back");
    ubicacionenc=window.location.pathname.split("/").pop();
    ubicacionenc =ubicacionenc.slice(0,-4);
    if(ubicacionenc==="encabezado"){
        flechita.hidden = true;
    }else{
        flechita.hidden = false;
        var opci = document.getElementById(`grupo__${ubicacionenc}`);
        if(opci!==null){
            opci.removeAttribute("href");
            opci.setAttribute('href', `javascript:void(0)`);
            opci.classList.add('grupo__menu-activo');
        }
    }
}
);