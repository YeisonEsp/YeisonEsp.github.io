// traerParametros.php
const telefonoemp = document.getElementById("telefonoemp")
const correoemp = document.getElementById("correoemp")

function traerparametros(){
    $.ajax({                                        //TRAER PARÁMETROS PARA MOSTRAR EN EL INDEX
        url: 'src/traerParametros.php',
        type: 'POST',  
        dataType:'json', 
        beforesend: function(){
            $('#mostrar-mensaje').html("Mensaje antes de enviar");
        },
        success: function(object){
            telefonoemp.textContent = object[0]["emprecel"]
            correoemp.textContent = object[0]["empreema"]
        },
        
    });
}

traerparametros()