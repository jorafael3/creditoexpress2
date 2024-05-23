<?php

$url_Validar_Celular = constant('URL') . 'principal/Validar_Celular/';
$url_Validar_Codigo = constant('URL') . 'principal/Validar_Codigo/';
$url_Validar_Cedula = constant('URL') . 'principal/Validar_Cedula/';

?>

<script>
    var url_Validar_Celular = '<?php echo $url_Validar_Celular ?>';
    var url_Validar_Codigo = '<?php echo $url_Validar_Codigo ?>';
    var url_Validar_Cedula = '<?php echo $url_Validar_Cedula ?>';

    var TELEFONO;
    var ID_UNICO;
    var IMAGE = null;
    var CODIGO_SMS = null;
    var IMAGECEDULA = null;

    function Mensaje(t1, t2, ic) {
        Swal.fire(
            t1,
            t2,
            ic
        );
    }

    $("#CELULAR").focus();


    var element = document.querySelector("#kt_stepper_example_basic");

    // Initialize Stepper
    var stepper = new KTStepper(element);
    // Handle next step
    stepper.on("kt.stepper.next", function(stepper) {

        if (stepper.getCurrentStepIndex() === 1) {
            var celularInput = document.querySelector("#CELULAR");
            celularInput = celularInput.value.trim();
            if (celularInput == "") {
                Mensaje("Debe ingresar un numero celular", "", "error");
                $("#CELULAR").focus();
                return false;
            } else if (celularInput.length != 10) {
                Mensaje("Debe ingresar un numero celular valido", "", "error");
                $("#CELULAR").focus();
                return false;
            } else {
                let terminos = $("#TERMINOS").is(":checked");
                if (terminos == false) {
                    Mensaje("Debe aceptar los terminos y condiciones para continuar", "", "error");
                    return false;
                } else {
                    Guardar_Celular();
                }
            }
            // var codeInputs = $('.code-input');
            // codeInputs.first().focus();
            // stepper.goNext();

        }
        if (stepper.getCurrentStepIndex() === 2) {
            // var codeInputs = $('.code-input');
            // codeInputs.first().focus();
            Validar_Codigo();

            // stepper.goNext();
        }

        // stepper.goNext();
    });

    stepper.on("kt.stepper.previous", function(stepper) {
        // stepper.goPrevious();
    });

    function Guardar_Celular() {
        let cel = $("#CELULAR").val();
        let terminos = $("#TERMINOS").is(":checked");
        let param = {
            celular: cel,
            terminos: terminos,
            tipo: 2
        }
        AjaxSendReceiveData(url_Validar_Celular, param, function(x) {
            console.log('x: ', x);
            if (x[0] == 1) {
                TELEFONO = x[1];
                // ID_UNICO = x[3];
                $("#SECC_COD").append(x[2]);
                stepper.goNext();
                var codeInputs = $('.code-input');
                codeInputs.first().focus();
            } else if (x[0] == 2) {
                $("#SECC_CEL").empty();
                $("#SECC_B").empty();
                $("#SECC_CEL").append(x[3]);
            } else {
                Mensaje(x[1], "", x[2]);
            }
        });
    }

    function Validar_Codigo() {
        var codeInputs = document.querySelectorAll('.code-input');
        var valores = Array.from(codeInputs).map(function(input) {
            return input.value;
        });
        let CON = 0;
        valores.map(function(x) {
            if (x.trim() == "") {
                Mensaje("Ingrese el codigo de 4 digitos", "", "error")
                return;
            } else {
                CON++;
            }
        });
        if (CON == 4) {
            let param = {
                TELEFONO: $("#CEL_1").val(),
                CODIGO: valores
            }
            AjaxSendReceiveData(url_Validar_Codigo, param, function(x) {
                if (x[0] == 1) {
                    $("#SECC_CRE").append(x[2]);
                    CODIGO_SMS = valores
                    stepper.goNext();
                    $("#SECC_B").addClass("d-none");

                } else {
                    Mensaje(x[1], "", x[2]);
                }
            });
        }
    }

    function Verificar() {
        let Cedula = $("#CEDULA").val();
        let cel = $("#CEL").val();
        let email = $("#CORREO").val();

        if (Cedula == "") {
            Mensaje("Debe ingresar un número de cédula valido", "", "error")
        } else {
            // if (IMAGE == null) {
            //     Mensaje("Por favor debe tomarse una foto", "", "error")
            // } else {

            // }
            let param = {
                cedula: Cedula,
                celular: cel,
                email: email,
                tipo: 1,
                IMAGEN: IMAGE,
                IMAGECEDULA: IMAGECEDULA,
                CODIGO_SMS: CODIGO_SMS.join('')
            }
            console.log('param: ', param);
            if (IMAGE == null || IMAGECEDULA == null) {
                Mensaje("Al paracer una de las fotografias no esta completa", "Por favor vuelva a tomar la foto", "error");
            } else {

                $("#SECCION_GIF").removeClass("d-none");
                $("#SECCION_FOTO_CEDULA").addClass("d-none");
                $("#SECC_B").addClass("d-none");


                AjaxSendReceiveData(url_Validar_Cedula, param, function(x) {
                    console.log('x: ', x);
                    $("#SECCION_GIF").addClass("d-none");
                    $("#SECCION_FOTO_CEDULA").removeClass("d-none");
                    $("#SECC_B").removeClass("d-none");
                    if (x[0] == 1) {
                        $("#SECCION_GIF").addClass("d-none");
                        $("#SECC_CRE").empty();
                        $("#SECC_B").empty();
                        $("#SECCION_FOTO").empty();
                        $("#SECCION_FOTO_CEDULA").empty();
                        $("#SECC_APR").append(x[3]);
                    } else if (x[0] == 2) {
                        Mensaje(x[1], x[2], "error");
                        $("#SECCION_GIF").addClass("d-none");
                        $("#SECCION_FOTO_CEDULA").removeClass("d-none");
                        $("#SECC_B").removeClass("d-none");
                        // IMAGE = null
                    } else {
                        $("#SECCION_GIF").addClass("d-none");
                        $("#SECCION_FOTO_CEDULA").removeClass("d-none");
                        $("#SECC_B").removeClass("d-none");

                        // $("#SECCION_FOTO").addClass("d-none");
                        // $("#SECCION_INGRESO_DATOS").removeClass("d-none");
                        // $("#SECC_BTN_CON_DATOS").removeClass("d-none");
                        // $("#SECC_B").addClass("d-none");
                        // IMAGECEDULA = null
                        Mensaje(x[1], x[2], "error");
                    }
                });
            }
        }
    }

    $("#btnIrDatos").on("click", function(x) {
        console.log('x: ', x);
        let Cedula = $("#CEDULA").val();

        // if (IMAGE != null) {
        if (Cedula == "") {
            Mensaje("Debe ingresar un número de cédula valido", "", "error")
        } else {
            let val = validarCedulaEcuatoriana(Cedula);
            console.log('val: ', val);
            if (validarCedulaEcuatoriana(Cedula)) {
                $("#SECCION_FOTO").removeClass("d-none");
                $("#SECCION_INGRESO_DATOS").addClass("d-none");
                // $("#SECC_B").removeClass("d-none");
                $("#SECC_BTN_CON_DATOS").addClass("d-none");
                $("#SECC_BTN_CON_DATOS_CEDULA").removeClass("d-none");
            } else {
                console.log("Cédula inválida");
                Mensaje("La cédula ingresada no es valida", "por favor ingrese un número valido", "error")
            }

        }
    });

    $("#btnIrDatoscedula").on("click", function(x) {
        console.log('x: ', x);
        let Cedula = $("#CEDULA").val();

        // if (IMAGE != null) {
        if (Cedula == "") {
            Mensaje("Debe ingresar un número de cédula valido", "", "error")
        } else {

            if (validarCedulaEcuatoriana(Cedula)) {
                if (IMAGE == null) {
                    Mensaje("No se encontro foto", "por favor Debe tomarse un foto para continuar", "info")
                } else {
                    $("#SECCION_FOTO_CEDULA").removeClass("d-none");
                    $("#SECCION_FOTO").addClass("d-none");
                    $("#SECC_B").removeClass("d-none");
                    $("#SECC_BTN_CON_DATOS").addClass("d-none");
                    $("#SECC_BTN_CON_DATOS_CEDULA").addClass("d-none");
                }


            } else {

                console.log("Cédula inválida");
                Mensaje("La cédula ingresada no es valida", "por favor ingrese un número valido", "error")
            }


        }
    });

    $("#CEDULA").on('keydown', function(event) {
        if (event.which === 13) { // 13 is the keycode for Enter
            event.preventDefault();
            $("#btnIrDatos").click()
        }
    });


    $("#BtnBackToDatosCedula").on("click", function(x) {

        $("#SECCION_FOTO").addClass("d-none");
        $("#SECCION_INGRESO_DATOS").removeClass("d-none");
        $("#SECC_BTN_CON_DATOS_CEDULA").addClass("d-none");
        $("#SECC_BTN_CON_DATOS").removeClass("d-none");

    });

    $("#BtnBackToDatosfoto").on("click", function(x) {

        $("#SECCION_FOTO").removeClass("d-none");
        $("#SECCION_FOTO_CEDULA").addClass("d-none");
        $("#SECC_BTN_CON_DATOS_CEDULA").removeClass("d-none");
        $("#SECC_BTN_CON_DATOS").addClass("d-none");
        $("#SECC_B").addClass("d-none");

    });




    $("#CELULAR").on("input", function() {
        var cleanedValue = $(this).val().replace(/\D/g, '');
        cleanedValue = cleanedValue.slice(0, 10);
        $(this).val(cleanedValue);
    });

    $("#CEDULA").on("input", function() {
        var cleanedValue = $(this).val().replace(/\D/g, '');
        cleanedValue = cleanedValue.slice(0, 10);
        $(this).val(cleanedValue);
    });

    function validarCedulaEcuatoriana(cedula) {
        // Verificar que la cédula tenga 10 dígitos
        if (cedula.length !== 10) {
            return false;
        }

        // Verificar que solo contenga números
        if (!/^\d+$/.test(cedula)) {
            return false;
        }

        // Extraer el código de la región y verificar que sea válido
        var region = parseInt(cedula.substring(0, 2));
        if (region < 1 || region > 24) {
            return false;
        }

        // Aplicar el algoritmo de verificación
        var total = 0;
        var digitos = cedula.split('').map(Number);
        var coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

        for (var i = 0; i < coeficientes.length; i++) {
            var producto = digitos[i] * coeficientes[i];
            if (producto >= 10) {
                producto -= 9;
            }
            total += producto;
        }

        var digitoVerificador = total % 10 ? 10 - total % 10 : 0;

        // Verificar que el último dígito sea igual al dígito verificador
        return digitoVerificador === digitos[9];
    }






    const videoWidth = 420;
    const videoHeight = 320;
    const videoTag = document.getElementById("theVideo");
    const canvasTag = document.getElementById("theCanvas");
    const canvasTag2 = document.getElementById("theCanvas2");
    const btnCapture = document.getElementById("btnCapture");
    const btnDownloadImage = document.getElementById("btnDownloadImage");
    const btnSendImageToServer = document.getElementById("btnSendImageToServer");
    const btnStartCamera = document.getElementById("btnStartCamera");

    let cameraActive = false; // Variable para rastrear el estado de la cámara
    var stream;
    // Establecer estado inicial de los botones
    btnCapture.disabled = true;
    btnDownloadImage.disabled = true;
    btnSendImageToServer.disabled = true;

    // Set video and canvas attributes
    videoTag.setAttribute("width", videoWidth);
    videoTag.setAttribute("height", videoHeight);
    canvasTag.setAttribute("width", videoWidth);
    canvasTag.setAttribute("height", videoHeight);

    canvasTag2.setAttribute("width", videoWidth);
    canvasTag2.setAttribute("height", videoHeight);

    btnStartCamera.addEventListener("click", async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                audio: false,
                video: {
                    width: videoWidth,
                    height: videoHeight
                },
            });
            videoTag.srcObject = stream;
            btnStartCamera.disabled = true;
            $("#theVideo").removeClass("d-none");
            $("#theCanvas").addClass("d-none");
            $("#SECC_VECTOR").addClass("d-none");
            $("#CANVAS_CAMARA").removeClass("d-none");

            // Habilitar los botones cuando la cámara está activa
            cameraActive = true;
            btnCapture.disabled = false;
            IMAGE = null
        } catch (error) {
            console.log("error", error);
            Mensaje("Error al iniciar la camara", "Asegurese de dar permisos a la camara, o tener una conectada", "error")
        }
    });

    // Capture button..
    btnCapture.addEventListener("click", () => {
        const canvasContext = canvasTag.getContext("2d");
        canvasContext.drawImage(videoTag, 0, 0, videoWidth, videoHeight);
        btnDownloadImage.disabled = false;
        btnSendImageToServer.disabled = false;
        const imageDataURL = canvasTag.toDataURL("image/jpeg");
        IMAGE = imageDataURL;
        // Hacer algo con la imagen en base64, como mostrarla en una etiqueta de imagen o enviarla al servidor
        console.log("Imagen en base64:", imageDataURL);
        btnCapture.disabled = true;

        $("#theVideo").addClass("d-none");
        $("#theCanvas").removeClass("d-none");
        cameraActive = false;
        stopCamera()

    });


    const videoWidth2 = 420;
    const videoHeight2 = 250;
    const videoTag2 = document.getElementById("theVideo2");
    const canvasTag3 = document.getElementById("theCanvas3");
    const btnCapture2 = document.getElementById("btnCaptureCedula");
    const btnStartCamera2 = document.getElementById("btnStartCameraCedula");

    let cameraActive2 = false; // Variable para rastrear el estado de la cámara
    var stream2;

    videoTag2.setAttribute("width", videoWidth);
    videoTag2.setAttribute("height", videoHeight);
    canvasTag3.setAttribute("width", videoWidth);
    canvasTag3.setAttribute("height", videoHeight);

    btnStartCamera2.addEventListener("click", async () => {
        try {
            stream2 = await navigator.mediaDevices.getUserMedia({
                audio: false,
                video: {
                    width: videoWidth2,
                    height: videoHeight2
                },
            });
            videoTag2.srcObject = stream2;
            btnStartCamera2.disabled = true;
            $("#theVideo2").removeClass("d-none");
            $("#theCanvas3").addClass("d-none");
            $("#SECC_VECTOR2").addClass("d-none");
            $("#CANVAS_CAMARA2").removeClass("d-none");

            // Habilitar los botones cuando la cámara está activa
            cameraActive2 = true;
            btnCapture2.disabled = false;
            IMAGECEDULA = null
        } catch (error) {
            console.log("error", error);
            Mensaje("Error al iniciar la camara", "Asegurese de dar permisos a la camara, o tener una conectada", "error")
        }
    });

    btnCapture2.addEventListener("click", () => {
        const canvasContext = canvasTag3.getContext("2d");
        canvasContext.drawImage(videoTag2, 0, 0, videoWidth2, videoHeight2);
        const imageDataURL = canvasTag3.toDataURL("image/jpeg");
        btnDownloadImage.disabled = false;
        btnSendImageToServer.disabled = false;
        IMAGECEDULA = imageDataURL;
        // Hacer algo con la imagen en base64, como mostrarla en una etiqueta de imagen o enviarla al servidor
        console.log("Imagen en base64:", imageDataURL);
        btnCapture2.disabled = true;

        $("#theVideo2").addClass("d-none");
        $("#theCanvas3").removeClass("d-none");
        cameraActive2 = false;
        stopCamera2()

    });


    // Detener la transmisión de la cámara
    function stopCamera() {
        if (stream) {
            console.log('stream: ', stream);
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            videoTag.srcObject = null;
            stream = null;
            cameraActive = false;
            btnStartCamera.disabled = false;
        }
    }

    function stopCamera2() {
        if (stream2) {
            console.log('stream: ', stream2);
            const tracks = stream2.getTracks();
            tracks.forEach(track => track.stop());
            videoTag2.srcObject = null;
            stream2 = null;
            cameraActive2 = false;
            btnStartCamera2.disabled = false;
        }
    }

    function Btn_Datos() {
        console.log('x: ');
    }



    /**
     * Boton para forzar la descarga de la imagen
     */
    // btnDownloadImage.addEventListener("click", () => {
    //     const link = document.createElement("a");
    //     link.download = "capturedImage.png";
    //     link.href = canvasTag.toDataURL();
    //     link.click();
    // });

    /**
     *Enviar imagen al serrvidor para se guardada
     */
    // btnSendImageToServer.addEventListener("click", async () => {
    //     const dataURL = canvasTag.toDataURL();
    //     const blob = await dataURLtoBlob(dataURL);
    //     const data = new FormData();
    //     data.append("capturedImage", blob, "capturedImage.png");

    //     try {
    //         const response = await axios.post("upload.php", data, {
    //             headers: {
    //                 "Content-Type": "multipart/form-data"
    //             },
    //         });
    //         alert(response.data);
    //     } catch (error) {
    //         console.error("Error al enviar la imagen:", error);
    //     }
    // });

    async function dataURLtoBlob(dataURL) {
        const arr = dataURL.split(",");
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        const n = bstr.length;
        const u8arr = new Uint8Array(n);
        for (let i = 0; i < n; i++) {
            u8arr[i] = bstr.charCodeAt(i);
        }
        return new Blob([u8arr], {
            type: mime
        });
    }

    function AjaxSendReceiveData(url, data, callback) {
        var xmlhttp = new XMLHttpRequest();

        // Mostrar la barra de progreso al iniciar la solicitud AJAX
        $.blockUI({
            message: '<div class="d-flex justify-content-center align-items-center">' +
                '<p class="mr-3 mb-0">Estamos validando tus datos ...</p>' +
                '<div class="progress" style="width: 150px;">' +
                '<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
                '</div>',
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                // Ocultar la barra de progreso cuando la solicitud AJAX haya finalizado
                $.unblockUI();
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    callback(data);
                } else {
                    // Manejar errores aquí
                }
            }
        };

        xmlhttp.upload.onprogress = function(event) {
            if (event.lengthComputable) {
                var percentComplete = (event.loaded / event.total) * 100;
                // Actualizar el valor de la barra de progreso mientras se carga la solicitud
                document.getElementById("progressBar").style.width = percentComplete + "%";
            }
        };

        xmlhttp.onerror = function() {
            // Ocultar la barra de progreso en caso de error
            $.unblockUI();
            // Manejar errores aquí
        };

        data = JSON.stringify(data);
        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(data);
    }


    // function AjaxSendReceiveData(url, data, callback) {
    //     var xmlhttp = new XMLHttpRequest();
    //     $.blockUI({
    //         message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Cargando ...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
    //         css: {
    //             backgroundColor: 'transparent',
    //             color: '#fff',
    //             border: '0'
    //         },
    //         overlayCSS: {
    //             opacity: 0.5
    //         }
    //     });

    //     xmlhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             var data = this.responseText;
    //             data = JSON.parse(data);
    //             callback(data);
    //         }
    //     }
    //     xmlhttp.onload = () => {
    //         $.unblockUI();
    //         // 
    //     };
    //     xmlhttp.onerror = function() {
    //         $.unblockUI();
    //     };
    //     data = JSON.stringify(data);
    //     xmlhttp.open("POST", url, true);
    //     xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //     xmlhttp.send(data);

    // }
</script>