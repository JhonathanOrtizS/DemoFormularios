/*=============================================
CAPTURANDO LA RUTA DE MI CMS
=============================================*/
var ruta = $("#ruta").val();

/*=============================================
PREVISUALIZAR IMÁGENES TEMPORALES
=============================================*/
$("input[type='file']").change(function() {
    //capturando el 1er archivo que capture el input de tipo file
    var imagen = this.files[0];

    //pidiendo el atributo name del input de este,
    //quiere decir que es para cualquier input que cumpla con los requisitos
    //en este caso es el input[type='file']
    var tipo = $(this).attr("name");
    //console.log(tipo);
    //var atributo = $(this).attr("name");
    //console.log(atributo);

    /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if (
        imagen["type"] != "image/jpeg" &&
        imagen["type"] != "image/png" &&
        imagen["type"] != "image/jpg"
    ) {
        $("input[type='file']").val("");

        notie.alert({
            type: 3,
            text: "¡La imagen debe estar en formato JPG o PNG!",
            time: 7
        });
    } else if (imagen["size"] > 2000000) {
        $("input[type='file']").val("");

        notie.alert({
            type: 3,
            text: "¡La imagen no debe pesar más de 2MB!",
            time: 7
        });
    } else {
        var datosImagen = new FileReader();
        datosImagen.readAsDataURL(imagen);

        //console.log(datosImagen);

        $(datosImagen).on("load", function(event) {
            var rutaImagen = event.target.result;

            $(".previsualizarImg_" + tipo).attr("src", rutaImagen);
        });
    }
});

/*=============================================
SUMMERNOTE
=============================================*/
$(".summernote-sm").summernote({
    height: 300,

    //es una respuesta despues de la accion del plugin
    //recibe una respuesta despues de subir una imagen en el servidor
    callbacks: {
        //funcion exclusiva para subir la imagen o archivos que pidamos
        onImageUpload: function(files) {
            //vemos si esta trallendo el archivo
            //console.log(files);

            //recorrido de los archivos que se estan subiendo
            for (var i = 0; i < files.length; i++) {
                //le pasamos como parametro todos los archivos que esten en
                //el indice
                upload_sm(files[i]);
            }
        }
    }
});

$(".summernote-smc").summernote({
    height: 300,
    callbacks: {
        onImageUpload: function(files) {
            for (var i = 0; i < files.length; i++) {
                upload_smc(files[i]);
            }
        }
    }
});

/*=============================================
SUBIR IMAGEN AL SERVIDOR
=============================================*/
function upload_sm(file) {
    console.log("file", file);

    //para enviar un formulario para enviar a php
    var datos = new FormData();

    //agregando el tipo de documento en datos[0]
    //1o. variable post 'file'
    //2do. el valor que viene en el parametro file (upload_sm(file))
    //3ro. el nombre que viene en el parametro file
    datos.append("file", file, file.name);

    //se agrega un input oculto donde traiga la url del servidor
    //agregando la ruta del documento en datos[1]
    //1ro. es el nombre de la variable post a enviar
    //2do. ruta trae el valor de la ruta del servidor cms
    datos.append("ruta", ruta);

    $.ajax({
        url: ruta + "/ajax/upload.php",
        method: "POST",
        //estamos enviando la data que contiene la variabla datos
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        //se nombra una variable que contendrá la respuesta
        success: function(respuesta) {
            //con el summernote le indicamos que haga un insert de la imagen
            //que trae la respuesta
            $(".summernote-sm").summernote("insertImage", respuesta);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus + " " + errorThrown);
        }
    });
}

function upload_smc(file) {
    var datos = new FormData();
    datos.append("file", file, file.name);
    datos.append("ruta", ruta);

    $.ajax({
        url: ruta + "/ajax/upload.php",
        method: "POST",
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        success: function(respuesta) {
            $(".summernote-smc").summernote("insertImage", respuesta);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus + " " + errorThrown);
        }
    });
}

/*=============================================
PREGUNTAR ANTES DE ELIMINAR REGISTRO
=============================================*/
$(document).on("click", ".eliminarRegistro", function() {
    var action = $(this).attr("action");
    var method = $(this).attr("method");
    /*var token = $(this)
        .children("[name='_token']")
        .attr("value");
        */
    var token = $(this).attr("token");
    var pagina = $(this).attr("pagina");
    //console.log(token);

    swal({
        title: "¿Está seguro de eliminar este registro?",
        text: "¡Si no está seguro, Puede cancelar esta acción!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Eliminar Registro"
    }).then(function(result) {
        if (result.value) {
            var datos = new FormData();
            datos.append("_method", method);
            datos.append("_token", token);

            $.ajax({
                url: action,
                method: "POST",
                //estamos enviando la data que contiene la variabla datos
                data: datos,
                contentType: false,
                cache: false,
                processData: false,
                success: function(respuesta) {
                    if (respuesta == "Ok") {
                        swal({
                            type: "success",
                            text: "¡El registro ha sido eliminado!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result) {
                            if (result.value) {
                                window.location = ruta + "/" + pagina;
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        }
    });
});

/*=============================================
DATA TABLE ADMIN MANEJO CON SERVIDOR CON COMPOSER
=============================================*/
/*$.ajax({
    url: ruta + "/administradores",
    success: function(respuesta) {
        //console.log("respuesta", respuesta);
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus + " " + errorThrown);
    }
});*/

/*=============================================
Limpiar rutas de caracteres especiales
y espacios
=============================================*/
function limpiarUrl(texto) {
    var texto = texto.toLowerCase();
    texto = texto.replace(/[á]/g, "a");
    texto = texto.replace(/[é]/g, "e");
    texto = texto.replace(/[í]/g, "i");
    texto = texto.replace(/[ó]/g, "o");
    texto = texto.replace(/[ú]/g, "u");
    texto = texto.replace(/[ñ]/g, "n");
    texto = texto.replace(/ /g, "-");

    return texto;
}

$(document).on("keyup", ".inputRuta", function() {
    $(this).val(limpiarUrl($(this).val()));
});

// $(document).ready(function() {
//     $("input[type=checkbox]").live("click", function() {
//         var parent = $(this)
//             .parent()
//             .attr("id");
//         $("#" + parent + " input[type=checkbox]").removeAttr("checked");
//         $(this).attr("checked", "checked");
//     });
// });
