
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

            if (data.exito == true && data.op == -1) {
                localStorage.setItem("sesion_token", datos.token);
                if(localStorage.getItem("sesion_token") != null) {
                    window.location.replace(url_base + "/home");
                    localStorage.setItem("flag", true);
                }
            }

            if (data.op == 1) {
                InfoModal(
                    titulo,
                    data.respuesta
                );
            } else if(data.op == 0) {
                $("#tab-alu").empty();
                for (var i = data.respuesta.length - 1; i >= 0; i--) {
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
        usuario:    document.getElementById("inputEmail").value,
        contraseña: document.getElementById("inputPassword").value
    };

    Peticiones(
        dict_data,
        "Inicio de sesion",
        url,
        0
    );
}