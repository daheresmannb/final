
function InfoModal(titulo, texto) {
    $("#titulomodal").empty();
    $("#titulomodal").append("<p>" + titulo + "</p>");
    $("#textmodal").empty();
    $("#textmodal").append("<p>" + texto + "</p>");
    $("#confirma-del").hide();
    $('#info_modal_id').modal('show');
}

function Peticiones(dict_data, titulo, url, flag) {
    console.log(url);
    $.ajax({
        type: 'POST',
        url:  url,
        dataType: "json",
        data: dict_data,
     
        success: function(data) {
            console.log(data);
            datos = data;

            if (flag != 0 && datos.exito != true) {
                InfoModal(
                    titulo, 
                    data.respuesta
                );
            }

            if (datos.exito == true && datos.op == -1) {
                
                localStorage.setItem("sesion_token", datos.token);

                if (typeof(localStorage) !== "undefined") {
                    if(localStorage.getItem("sesion_token") != null) {
                        window.location.replace(url_base + "/home");
                        localStorage.setItem("flag", true);
                    }
                } else {
                    console.log(localStorage.getItem("Sorry, your browser does not support Web Storage..."));
                }
            }

            if (datos.op == 2) {
                $("#tab-alu").empty();
                for (var i = datos.respuesta.length - 1; i >= 0; i--) {
                    $("#tab-alu").append(
                        "<tr><th scope='row'>"+datos.respuesta[i].id+
                        "</th><td>"+datos.respuesta[i].nombre+
                        "</td><td>"+datos.respuesta[i].apellido+
                        "</td><td>"+datos.respuesta[i].correo+
                        "</td><td>"+datos.respuesta[i].telefono+
                        "</td><td>"+datos.respuesta[i].direccion+
                        "</td></tr>"
                    );
              }
            }
        },
        error: function(xhr, textStatus, thrownError) {
            console.log(xhr);
            console.log(thrownError +"error "+ textStatus);
        }
    });
}

function Login(url) {
    dict_data = {
        usuario: document.getElementById("inputEmail").value,
        contraseña: document.getElementById("inputPassword").value
    };

    Peticiones(
        dict_data,
        "Inicio de sesion",
        url,
        0
    );
}

function AlumnosCrear() {
    dict_data = {
        nombre:    document.getElementById("nombre").value,
        apellido:  document.getElementById("apellido").value,
        correo:    document.getElementById("correo").value,
        telefono:  document.getElementById("telefono").value,
        direccion: document.getElementById("direccion").value
    };

    Peticiones(
        dict_data,
        "Registro de alumnos",
        "alumnos/crear",
        1
    );
}

$(document).ready(
    function() {
        $("#iniciar").click(
            function() {
                Login("<?php echo $this->url->get('/login')?>");
            }
        );
    }
);