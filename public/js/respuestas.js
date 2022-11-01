/*=============================================
DATA TABLE ADMIN MANEJO CON SERVIDOR CON COMPOSER
=============================================*/
/*$.ajax({
    url: ruta + "/categorias",
    success: function(respuesta) {
        console.log("respuesta", respuesta);
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus + " " + errorThrown);
    }
});*/

/*=============================================
DATA TABLE ADMIN
=============================================*/

//establecemos una variable esto se hace cuando ya estamos trabajando con la libreria de dataTable
//para aplicar orden codigo que esta abajo de esta funcion.
var tablaRespuestas = $("#tablaRespuestas").DataTable({
    /**
     * Vamos a pedir los siguientes parametros para que nos mande la información
     * a la tabla-
     */
    processing: true,
    serverSide: true,
    ajax: {
        url: ruta + "/respuestas"
    },
    //vamos a poner orden a los id, que no muestre el id del usuario de la DB
    //sino que muestre como un contador en la tabla de Administradores
    columnDefs: [
        {
            searchable: true,
            orderable: true,
            targets: 0
        }
    ],
    order: [[0, "desc"]],
    //ahora vamos a pedir que lo construlla en las siguientes columnas
    columns: [
        {
            //columna ID
            data: "id_respuesta",
            name: "id_respuesta"
        },
        {
            //columna ID Indicador
            data: "titulo_respuesta",
            name: "titulo_respuesta"
        },
        {
            //Respuestas
            data: "p_respuestas",
            name: "p_respuestas"
        },
        {
            //Respuestas
            data: "descripcion",
            name: "descripcion"
        },
        {
            //columna ACCIONES
            //volvemos a pedir el id para poder enviarlo al modal de editar o para eliminarlo
            data: "acciones",
            name: "acciones"
        }
    ],

    language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando registros del _START_ al _END_",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior"
        },
        oAria: {
            sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
            sSortDescending:
                ": Activar para ordenar la columna de manera descendente"
        }
    }
});

//continuación para establecer el orden en la tabla de administradores
//con DataTable
tablaRespuestas
    .on("order.dt search.dt", function() {
        tablaRespuestas
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
    })
    .draw();
