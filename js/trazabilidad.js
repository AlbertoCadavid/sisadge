document.addEventListener("DOMContentLoaded", function () {
  const eventList = document.getElementById("event-list");
  const searchButton = document.getElementById("searchButton");

  searchButton.addEventListener("click", function () {
    let op = document.getElementById("op").value;

    if (op !== "0") {
      var getUrl = window.location.pathname;
      $.ajax({
        dataType: "json",
        data: {
          op: op,
        },
        url: getUrl + "?c=Ctrazabilidad&a=stateCreate",
        type: "post",
        beforeSend: function () {
          //Lo que se hace antes de enviar el formulario
          eventList.innerHTML = "";
        },
        success: function (data) {

          if (data) {
            createDivEstado(
              eventos[0].descripcion,
              data.fecha_registro_op,
              eventos[0].tipo,
              "div"
            );
            stateExtrusion();
          }
        },
      });

      function stateExtrusion() {
        $.ajax({
          dataType: "json",
          data: {
            op: op,
          },
          url: getUrl + "?c=Ctrazabilidad&a=stateExtrusion",
          type: "post",
          beforeSend: function () {
            //Lo que se hace antes de enviar el formulario
          },
          success: function (data) {

            if (data.length > 1) {
              containerProcesos(eventos[1].descripcion, data[0]["fechaI_r"], eventos[1].tipo, data, "Rollos Extruidos", "subcontainer");
            } else {
              createDivEstado(
                "NO HA LLEGADO A EXTRUSION",
                "",
                eventos[1].tipo,
                "unavailable"
              );
            }
            stateImpresion()
          },
        });
      }

      function stateImpresion() {
        $.ajax({
          dataType: "json",
          data: {
            op: op,
          },
          url: getUrl + "?c=Ctrazabilidad&a=stateImpresion",
          type: "post",
          beforeSend: function () {
            //Lo que se hace antes de enviar el formulario
          },
          success: function (data) {
console.log(data);
            if (data.length > 1) {
              containerProcesos(eventos[3].descripcion, data[0]["fechaI_r"], eventos[3].tipo, data, "Rollos Impresos", "subcontainer2");
              /* data.forEach((element) => {
                createDivRollo(
                  `rollo ${element.rollo_r}`,
                  element.fechaF_r,
                  eventos[3].tipo,
                  "containerRollo"
                );
              }); */
            } else {
              createDivEstado(
                "NO HA LLEGADO A IMPRESION",
                "",
                eventos[1].tipo,
                "unavailable"
              );
            }
            stateSellado()
          },
        });
      }

      function stateSellado() {
        $.ajax({
          dataType: "json",
          data: {
            op: op,
          },
          url: getUrl + "?c=Ctrazabilidad&a=stateSellado",
          type: "post",
          beforeSend: function () {
            //Lo que se hace antes de enviar el formulario
          },
          success: function (data) {

            if (data.length > 1) {
              containerProcesos(eventos[5].descripcion, data[0]["fechaI_r"], eventos[5].tipo, data, "Rollos Sellados", "subcontainer3");
              data.forEach((element) => {
                /* createDivRollo(
                  `rollo ${element.rollo_r}`,
                  element.fechaF_r,
                  eventos[5].tipo,
                  "containerRollo"
                ); */
              });
            } else {
              createDivEstado(
                "NO HA LLEGADO A SELLADO",
                "",
                eventos[1].tipo,
                "unavailable"
              );
            }
          },
        });
      }
    }
  });

  const eventos = [
    { tipo: "entrada", descripcion: "Orden de produccion creada" },
    { tipo: "procesamiento", descripcion: "Orden Iniciada en extrusion" },
    { tipo: "salida", descripcion: "OP completada en extrusion" },
    { tipo: "procesamiento", descripcion: "Orden Iniciada en Impresion" },
    { tipo: "salida", descripcion: "OP completada en impresion" },
    { tipo: "procesamiento", descripcion: "Orden Iniciada en sellado" },
    { tipo: "salida", descripcion: "Enviado al cliente" },
    { tipo: "entrada", descripcion: "Recibido de proveedor" },
    { tipo: "procesamiento", descripcion: "Empaquetando producto" },
  ];

  function createDivEstado(eventDescript, descript, type, nClass = "") {
    let tag = document.createElement("div");
    tag.setAttribute("class", `div ${nClass}`);
    tag.textContent = eventDescript + " " + descript;
    tag.classList.add(`event-${type}`);
    eventList.appendChild(tag);
  }

  function createDivRollo(eventDescript, descript, type, nClass = "") {
    let tag = document.createElement("div");
    tag.setAttribute("class", `div`);
    tag.textContent = eventDescript + " " + descript;
    tag.classList.add(`event-${type}`);
    tag.classList.add(`${nClass}`);
    document.querySelector(`${parent}`).appendChild(tag);
  }
  

  function containerProcesos(evento, txt, tipo, data, txt2, id) {

    let div1 = document.createElement("div");
    div1.setAttribute("class", "flex");
    eventList.appendChild(div1);

    let div2 = document.createElement("div");
    div2.setAttribute("class", `div`);
    div2.textContent = evento + " " + txt;
    div2.classList.add(`event-${tipo}`);
    div1.appendChild(div2);

    let div3 = document.createElement("div");
    div1.appendChild(div3);

    let div4 = document.createElement("div");
    let idiv4 = document.createElement("div");
    idiv4.setAttribute("class", "titulo");
    idiv4.textContent = txt2;
    idiv4.classList.add(`event-${tipo}`);
    div4.appendChild(idiv4);
    div3.appendChild(div4);

    let div5 = document.createElement("div");
    div5.setAttribute("class", "wrapRollos");
    div5.setAttribute("id", id);
    div3.appendChild(div5);

    data.forEach((element) => {
      let div6 = document.createElement("div");
      div6.setAttribute("class", `div`);
      div6.textContent = `ROLLO ${element.rollo_r}` + "\n" + element.fechaF_r;
      div6.classList.add(`event-${tipo}`);
      div6.classList.add("containerRollo");
      document.getElementById(id).appendChild(div6);
    });
  }
});

$("#op").select2({
  ajax: {
    url: "select3/proceso.php",
    type: "post",
    dataType: "json",
    delay: 250,
    data: function (params) {
      return {
        palabraClave: params.term, // search term
        var1: "id_op", //campo normal para usar
        var2: "tbl_orden_produccion", //tabla
        var3: "", //where
        var4: "ORDER BY id_op DESC",
        var5: "id_op", //clave
        var6: "id_op", //columna a buscar
      };
    },
    processResults: function (response) {
      return {
        results: response,
      };
    },
    cache: true,
  },
});

$(document).ready(function () {
  var ref = $("#id_ref").val();
  var ops = $("#op").val();
});

