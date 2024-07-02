var anteriorl;
var urll;
var flechita;
$(document).ready(function(){
    flechita = document.getElementById("flechita-back");
    anteriorl=document.referrer;
    if(anteriorl!=""){
        anteriorl = new URL(anteriorl);
        urll = anteriorl.pathname.split("/").pop();
        flechita.removeAttribute("href");
        
        if(urll==""){
            flechita.setAttribute('href', `../`);
        }else{
            flechita.setAttribute('href', `${urll}`);
        }
    }
}
);
		