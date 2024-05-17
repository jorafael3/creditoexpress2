<?php

require 'views/header.php';

// var_dump($this->proveedores);
?><style>
    .verification-code {
        display: flex;
        justify-content: space-between;
        width: 200px;
        /* Ajusta el ancho según sea necesario */
        margin: auto;
    }

    .verification-code input {
        text-align: center;
        width: 60px;
        height: 60px;
        font-size: 24px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        margin: 5px;
        font-weight: bold;
    }

    .code-input {
        text-align: center;
        width: 60px;
        height: 60px;
        font-size: 24px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        margin: 0px;
        font-weight: bold;
    }

    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    #form-container {
        background-image: url('<?php echo constant("URL") ?>/public/img/SV24BackgroundLC.jpg');
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        /* padding: 10px; */
        /* Añade relleno para evitar que el contenido se superponga con la imagen */
    }
</style>

<div class="row justify-content-center" id="form-container">
    <div class="col-xl-4 col-md-6" style="margin-top: 80px;">
        <div class="card ">
            <div class="card-body">
                <div class="row justify-content-center">
                    <!-- <div class="col-5">
                        <img style="width: 100%;" src="<?php echo constant("URL") ?>/public/img/SV24 - Logos LC_Salvacero.png" alt="">
                    </div> -->
                    <div class="col-8">
                        <img style="width: 100%;" src="<?php echo constant("URL") ?>/public/img/SV24 - Logos LC_Credito.png" alt="">
                    </div>
                </div>
                <div class="stepper stepper-pills" id="kt_stepper_example_basic">
                    <div class="stepper-nav flex-center flex-wrap mb-5">
                        <div class="stepper-item current" data-kt-stepper-element="nav">
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!-- <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number"></span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                    </h3>

                                    <div class="stepper-desc">
                                    </div>
                                </div> -->
                            </div>
                            <!-- <div class="stepper-line h-40px"></div> -->
                        </div>
                        <div class="stepper-item" data-kt-stepper-element="nav">
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!-- <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Step 2
                                    </h3>

                                    <div class="stepper-desc">
                                        Description
                                    </div>
                                </div> -->
                            </div>
                            <!-- <div class="stepper-line h-40px"></div> -->
                        </div>
                        <div class="stepper-item" data-kt-stepper-element="nav">
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!-- <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Step 3
                                    </h3>

                                    <div class="stepper-desc">
                                        Description
                                    </div>
                                </div> -->
                            </div>
                            <!-- <div class="stepper-line h-40px"></div> -->
                        </div>

                    </div>
                    <form class="form mx-auto" novalidate="novalidate" id="kt_stepper_example_basic_form">
                        <div class="mb-5">
                            <div class="flex-column current" data-kt-stepper-element="content">
                                <div id="SECC_CEL">
                                    <div class="fv-row mb-5">
                                        <label class="form-label fw-bold fs-1">Ingresa tu número celular</label>
                                        <h6 class="text-muted">Se enviará un código de verificación para validar el número</h6>
                                        <input placeholder="xxxxxxxxxx" id="CELULAR" type="text" class="form-control form-control-solid" name="input1" placeholder="" value="" />
                                    </div>
                                    <div class="fv-row mb-5">
                                        <label class="form-check form-check-custom form-check-solid">
                                            <a class="fw-bold text-success" href="#!" onclick="$('#exampleModalreq').modal('show')">
                                                Ver requisitos
                                            </a>
                                        </label>
                                    </div>
                                    <div class="fv-row mb-10">
                                        <label class="form-label">Terminos y condiciones</label>
                                        <label class="form-check form-check-custom form-check-solid">
                                            <input id="TERMINOS" class="form-check-input" checked="checked" type="checkbox" value="1" />
                                            <span class="form-check-label fw-bold">
                                                He leído y acepto los
                                                <a class="fw-bold" href="#!" onclick="$('#exampleModalLong').modal('show')">
                                                    Términos y Condiciones
                                                </a>
                                            </span>
                                        </label>
                                    </div>
                                </div>


                            </div>
                            <div class="flex-column" data-kt-stepper-element="content">
                                <div id="SECC_COD">

                                </div>
                            </div>
                            <div class="flex-column" data-kt-stepper-element="content">
                                <div id="SECC_CRE">


                                </div>
                                <div id="SECC_APR">

                                </div>
                            </div>

                        </div>
                        <div class="d-flex flex-stack justify-content-center">
                            <div class="me-2">
                                <!-- <button type="button" class="btn btn-light btn-active-light-success fs-3 fw-bold" data-kt-stepper-action="previous">
                                    Regresar
                                </button> -->
                            </div>
                            <div id="SECC_B">
                                <button onclick="Verificar()" type="button" class="btn btn-success fs-3 fw-bold" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        Verificar
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>

                                <button type="button" class="btn btn-success fs-3 fw-bold" data-kt-stepper-action="next">
                                    Continuar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
    <script defer src="app.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container text-center">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-12">
                <h2>
                    � Como tomar foto desde el navegador Web usando JavaScript y PHP �
                </h2>
                <hr />
            </div>
            <img src="assets/imgs/sorpresa.gif" class="img-fluid" alt="sorpresa" style="width: 350px" />
            <div class="col-md-12 center">
                <video id="theVideo" autoplay muted></video>
                <canvas id="theCanvas"></canvas>
            </div>

            <div class="d-grid gap-2 d-md-block">
                <button class="btn btn-primary" id="btnCapture">Tomar foto</button>
                <button class="btn btn-primary" id="btnDownloadImage">
                    descargar imagen
                </button>
                <button class="btn btn-primary" id="btnSendImageToServer" disabled>
                    guardar imagen
                </button>
                <button class="btn btn-primary" id="btnStartCamera">
                    Iniciar camara
                </button>
            </div>
        </div>
    </div>

    <a href="fotos.php" target="_blank" id="bottomRightButton"> fotos </a>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</body>
<script>
    const videoWidth = 420;
    const videoHeight = 320;
    const videoTag = document.getElementById("theVideo");
    const canvasTag = document.getElementById("theCanvas");
    const btnCapture = document.getElementById("btnCapture");
    const btnDownloadImage = document.getElementById("btnDownloadImage");
    const btnSendImageToServer = document.getElementById("btnSendImageToServer");
    const btnStartCamera = document.getElementById("btnStartCamera");

    let cameraActive = false; // Variable para rastrear el estado de la cámara

    // Establecer estado inicial de los botones
    btnCapture.disabled = true;
    btnDownloadImage.disabled = true;
    btnSendImageToServer.disabled = true;

    // Set video and canvas attributes
    videoTag.setAttribute("width", videoWidth);
    videoTag.setAttribute("height", videoHeight);
    canvasTag.setAttribute("width", videoWidth);
    canvasTag.setAttribute("height", videoHeight);

    btnStartCamera.addEventListener("click", async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: false,
                video: {
                    width: videoWidth,
                    height: videoHeight
                },
            });
            videoTag.srcObject = stream;
            btnStartCamera.disabled = true;

            // Habilitar los botones cuando la cámara está activa
            cameraActive = true;
            btnCapture.disabled = false;
        } catch (error) {
            console.log("error", error);
        }
    });

    // Capture button..
    btnCapture.addEventListener("click", () => {
        const canvasContext = canvasTag.getContext("2d");
        canvasContext.drawImage(videoTag, 0, 0, videoWidth, videoHeight);
        btnDownloadImage.disabled = false;
        btnSendImageToServer.disabled = false;
    });

    /**
     * Boton para forzar la descarga de la imagen
     */
    btnDownloadImage.addEventListener("click", () => {
        const link = document.createElement("a");
        link.download = "capturedImage.png";
        link.href = canvasTag.toDataURL();
        link.click();
    });

    /**
     *Enviar imagen al serrvidor para se guardada
     */
    btnSendImageToServer.addEventListener("click", async () => {
        const dataURL = canvasTag.toDataURL();
        const blob = await dataURLtoBlob(dataURL);
        const data = new FormData();
        data.append("capturedImage", blob, "capturedImage.png");

        try {
            const response = await axios.post("upload.php", data, {
                headers: {
                    "Content-Type": "multipart/form-data"
                },
            });
            alert(response.data);
        } catch (error) {
            console.error("Error al enviar la imagen:", error);
        }
    });

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
</script>

</html>


<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Términos y condiciones</h5>
                <button class="btn" type="button" onclick="$('#exampleModalLong').modal('hide')" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- <body>

                    <h1>AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES</h1>
                    <h2>SALVACERO CIA. LTDA.</h2>

                    <p>Por medio de la presente autorizo de manera libre, voluntaria, previa, informada e inequívoca a SALVACERO CIA. LTDA.
                        para que en los términos legalmente establecidos realice el tratamiento de mis datos personales como parte de la relación
                        precontractual, contractual y post contractual para:</p>

                    <ul>
                        <li>El procesamiento, análisis, investigación, estadísticas, referencias y demás trámites para facilitar, promover, permitir o mantener las relaciones con SALVACERO CIA. LTDA.</li>
                        <li>Cuantas veces sean necesarias, gestione, obtenga y valide de cualquier entidad pública y/o privada que se encuentre facultada en el país, de forma expresa a la Dirección General de Registro Civil, Identificación y Cedulación, a la Dirección Nacional de Registros Públicos, al Servicio de Referencias Crediticias, a los burós de información crediticia, instituciones financieras de crédito, de cobranza, compañías emisoras o administradoras de tarjetas de crédito, personas naturales y los establecimientos de comercio, personas señaladas como referencias, empleador o cualquier otra entidad y demás fuentes legales de información autorizadas para operar en el país, información y/o documentación relacionada con mi perfil, capacidad de pago y/o cumplimiento de obligaciones, para validar los datos que he proporcionado, y luego de mi aceptación sean registrados para el desarrollo legítimo de la relación jurídica o comercial, así como para realizar actividades de tratamiento sobre mi comportamiento crediticio, manejo y movimiento de cuentas bancarias, tarjetas de crédito, activos, pasivos, datos/referencias personales y/o patrimoniales del pasado, del presente y las que se generen en el futuro, sea como deudor principal, codeudor o garante, y en general, sobre el cumplimiento de mis obligaciones. Faculto expresamente a SALVACERO CIA. LTDA. para transferir o entregar a las mismas personas o entidades, la información relacionada con mi comportamiento crediticio.</li>
                        <li>Tratar, transferir y/o entregar la información que se obtenga en virtud de esta solicitud incluida la relacionada con mi comportamiento crediticio y la que se genere durante la relación jurídica y/o comercial a autoridades competentes, terceros, socios comerciales y/o adquirientes de cartera, para el tratamiento de mis datos personales conforme los fines detallados en esta autorización o que me contacten por cualquier medio para ofrecerme los distintos servicios y productos que integran su portafolio y su gestión, relacionados o no con los servicios financieros. En caso de que el SALVACERO CIA. LTDA. ceda o transfiera cartera adeudada por mí, el cesionario o adquiriente de dicha cartera queda desde ahora expresamente facultado para realizar las mismas actividades establecidas en esta autorización.</li>
                        <li>Fines informativos, marketing, publicitarios y comerciales a través del servicio de telefonía, correo electrónico, mensajería SMS, WhatsApp, redes sociales y/o cualquier otro medio de comunicación electrónica.</li>
                    </ul>

                    <p>Entiendo y acepto que mi información personal podrá ser almacenada de manera digital, y accederán a ella los funcionarios de SALVACERO CIA. LTDA., estando obligados a cumplir con la legislación aplicable a las políticas de confidencialidad, protección de datos y sigilo bancario. En caso de que exista una negativa u oposición para el tratamiento de estos datos, no podré disfrutar de los servicios o funcionalidades que SALVACERO CIA. LTDA. ofrece y no podrá suministrarme productos, ni proveerme sus servicios o contactarme y en general cumplir con varias de las finalidades descritas en la Política.</p>

                    <p>SALVACERO CIA. LTDA. conservará la información personal al menos durante el tiempo que dure la relación comercial y el que sea necesario para cumplir con la normativa respectiva del sector relativa a la conservación de archivos.</p>

                    <p>Declaro conocer que para el desarrollo de los propósitos previstos en el presente documento y para fines precontractuales, contractuales y post contractuales es indispensable el tratamiento de mis datos personales conforme a la Política disponible en la página web de SALVACERO CIA. LTDA.</p>

                    <p>Asimismo, declaro haber sido informado por el SALVACERO CIA. LTDA. de los derechos con que cuento para conocer, actualizar y rectificar mi información personal; así como, si no deseo continuar recibiendo información comercial y/o publicidad, deberé remitir mi requerimiento a través del proceso de atención de derechos ARSO+ en cualquier momento y sin costo alguno, utilizando la página web <a href="https://www.salvacero.com/terminos">https://www.salvacero.com/terminos</a> o comunicado escrito a Srs. Salvacero y enviando un correo electrónico a la dirección <a href="mailto:marketing@salvacero.com">marketing@salvacero.com</a></p>

                    <p>En virtud de que, para ciertos productos y servicios SALVACERO CIA. LTDA. requiere o solicita el tratamiento de datos personales de un tercero que como cliente podré facilitar, como por ejemplo referencias comerciales o de contacto, garantizo que, si proporciono datos personales de terceras personas, les he solicitado su aceptación e informado acerca de las finalidades y la forma en la que SALVACERO CIA. LTDA. necesita tratar sus datos personales.</p>

                    <p>Para la comunicación de sus datos personales se tomarán las medidas de seguridad adecuadas conforme la normativa vigente.</p>

                    <h2>AUTORIZACIÓN EXPLÍCITA DE TRATAMIENTO DE DATOS PERSONALES</h2>
                    <h2>SALVACERO CIA. LTDA.</h2>

                    <p>Declaro que soy el titular de la información reportada, y que la he suministrado de forma voluntaria, completa, confiable, veraz, exacta y verídica:</p>

                    <p>Como titular de los datos personales, particularmente el código dactilar, no me encuentro obligado a otorgar mi autorización de tratamiento a menos que requiera consultar y/o aplicar a un producto y/o servicio financiero. A través de la siguiente autorización libre, especifica, previa, informada, inequívoca y explícita, faculto al tratamiento (recopilación, acceso, consulta, registro, almacenamiento, procesamiento, análisis, elaboración de perfiles, comunicación o transferencia y eliminación) de mis datos personales incluido el código dactilar con la finalidad de: consultar y/o aplicar a un producto y/o servicio financiero y ser sujeto de decisiones basadas única o parcialmente en valoraciones que sean producto de procesos automatizados, incluida la elaboración de perfiles. Esta información será conservada por el plazo estipulado en la normativa aplicable.</p>

                    <p>Así mismo, declaro haber sido informado por SALVACERO CIA. LTDA. de los derechos con que cuento para conocer, actualizar y rectificar mi información personal, así como, los establecidos en el artículo 20 de la LOPDP y remitir mi requerimiento a través del proceso de atención de derechos ARSO+; en cualquier momento y sin costo alguno, utilizando la página web <a href="https://www.salvacero.com/terminos">https://www.salvacero.com/terminos</a>, comunicado escrito o en cualquiera de las agencias de SALVACERO CIA. LTDA.</p>

                    <p>Para proteger esta información tenemos medidas técnicas y organizativas de seguridad adaptadas a los riesgos como, por ejemplo: anonimización, cifrado, enmascarado y seudonimización.</p>

                    <p>Con la lectura de este documento manifiesto que he sido informado sobre el Tratamiento de mis Datos Personales, y otorgo mi autorización y aceptación de forma voluntaria y verídica, tanto para la SALVACERO CIA. LTDA. y para cualquier cesionario o endosatario, especialmente Banco Solidario S.A. En señal de aceptación suscribo el presente documento.</p>

                </body> -->

                <body>

                    <h1>AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES</h1>
                    <h2>BANCO SOLIDARIO S.A.</h2>

                    <p>Por medio de la presente autorizo de manera libre, voluntaria, previa, informada e inequívoca a BANCO SOLIDARIO
                        S.A. para que en los términos legalmente establecidos realice el tratamiento de mis datos personales como parte de
                        la relación precontractual, contractual y post contractual para: </p>

                    <ul>
                        <li>El procesamiento, análisis, investigación, estadísticas, referencias y demás trámites para facilitar, promover, permitir
                            o mantener las relaciones con el BANCO. </li>
                        <li>Cuantas veces sean necesarias, gestione, obtenga y valide de cualquier entidad pública y/o privada que se encuentre
                            facultada en el país, de forma expresa a la Dirección General de Registro Civil, Identificación y Cedulación, a la Dirección
                            Nacional de Registros Públicos, al Servicio de Referencias Crediticias, a los burós de información crediticia, instituciones
                            financieras de crédito, de cobranza, compañías emisoras o administradoras de tarjetas de crédito, personas naturales
                            y los establecimientos de comercio, personas señaladas como referencias, empleador o cualquier otra entidad y demás
                            fuentes legales de información autorizadas para operar en el país, información y/o documentación relacionada con mi
                            perfil, capacidad de pago y/o cumplimiento de obligaciones, para validar los datos que he proporcionado, y luego de
                            mi aceptación sean registrados para el desarrollo legítimo de la relación jurídica o comercial, así como para realizar
                            actividades de tratamiento sobre mi comportamiento crediticio, manejo y movimiento de cuentas bancarias, tarjetas
                            de crédito, activos, pasivos, datos/referencias personales y/o patrimoniales del pasado, del presente y las que se
                            generen en el futuro, sea como deudor principal, codeudor o garante, y en general, sobre el cumplimiento de mis
                            obligaciones. Faculto expresamente al Banco para transferir o entregar a las mismas personas o entidades, la
                            información relacionada con mi comportamiento crediticio. Esta expresa autorización la otorgo al Banco o a cualquier
                            cesionario o endosatario</li>
                        <li>Tratar, transferir y/o entregar la información que se obtenga en virtud de esta solicitud incluida la relacionada con mi
                            comportamiento crediticio y la que se genere durante la relación jurídica o comercial a autoridades competentes,
                            terceros, socios comerciales y/o adquirientes de cartera, para el tratamiento de mis datos personales conforme los
                            fines detallados en esta autorización o que me contacten por cualquier medio para ofrecerme los distintos servicios y
                            productos que integran su portafolio y su gestión, relacionados o no con los servicios financieros del BANCO. En caso
                            de que el BANCO ceda o transfiera cartera adeudada por mí, el cesionario o adquiriente de dicha cartera queda desde
                            ahora expresamente facultado para realizar las mismas actividades establecidas en esta autorización. </li>
                    </ul>

                    <p>Entiendo y acepto que mi información personal podrá ser almacenada de manera impresa o digital, y accederán a ella
                        los funcionarios de BANCO SOLIDARIO, estando obligados a cumplir con la legislación aplicable a las políticas de
                        confidencialidad, protección de datos y sigilo bancario. En caso de que exista una negativa u oposición para el
                        tratamiento de estos datos, no podré disfrutar de los servicios o funcionalidades que el BANCO ofrece y no podrá
                        suministrarme productos, ni proveerme sus servicios o contactarme y en general cumplir con varias de las finalidades
                        descritas en la Política. </p>

                    <p>El BANCO conservará la información personal al menos durante el tiempo que dure la relación comercial y el que sea
                        necesario para cumplir con la normativa respectiva del sector relativa a la conservación de archivos. </p>

                    <p>Declaro conocer que para el desarrollo de los propósitos previstos en el presente documento y para fines
                        precontractuales, contractuales y post contractuales es indispensable el tratamiento de mis datos personales
                        conforme a la Política disponible en la página web del BANCO www.banco-solidario.com/transparencia Asimismo,
                        declaro haber sido informado por el BANCO de los derechos con que cuento para conocer, actualizar y rectificar mi
                        información personal; así como, si no deseo continuar recibiendo información comercial y/o publicidad, deberé remitir
                        mi requerimiento a través del proceso de atención de derechos ARSO+ en cualquier momento y sin costo alguno,
                        utilizando la página web (www.banco-solidario.com), teléfono: 1700 765 432, comunicado escrito o en cualquiera de
                        las agencias del BANCO. </p>


                    <p>En virtud de que, para ciertos productos y servicios el BANCO requiere o solicita el tratamiento de datos personales
                        de un tercero que como cliente podré facilitar, como por ejemplo referencias comerciales o de contacto, garantizo
                        que, si proporciono datos personales de terceras personas, les he solicitado su aceptación e informado acerca de las
                        finalidades y la forma en la que el BANCO necesita tratar sus datos personales. </p>

                    <p>Para la comunicación de sus datos personales se tomarán las medidas de seguridad adecuadas conforme la normativa
                        vigente.</p>

                    <h2>AUTORIZACIÓN EXPLÍCITA DE TRATAMIENTO DE DATOS PERSONALES</h2>
                    <h2>BANCO SOLIDARIO S.A.</h2>

                    <p>Declaro que soy el titular de la información reportada, y que la he suministrado de forma voluntaria, completa,
                        confiable, veraz, exacta y verídica: </p>

                    <p>Como titular de los datos personales, particularmente el código dactilar, dato biométrico facial, no me encuentro
                        obligado a otorgar mi autorización de tratamiento a menos que requiera consultar y/o aplicar a un producto y/o
                        servicio financiero. A través de la siguiente autorización libre, especifica, previa, informada, inequívoca y explícita,
                        faculto al tratamiento (recopilación, acceso, consulta, registro, almacenamiento, procesamiento, análisis, elaboración
                        de perfiles, comunicación o transferencia y eliminación) de mis datos personales incluido el código dactilar con la
                        finalidad de: consultar y/o aplicar a un producto y/o servicio financiero y ser sujeto de decisiones basadas única o
                        parcialmente en valoraciones que sean producto de procesos automatizados, incluida la elaboración de perfiles. Esta
                        información será conservada por el plazo estipulado en la normativa aplicable. </p>

                    <p>Así mismo, declaro haber sido informado por el BANCO de los derechos con que cuento para conocer, actualizar y
                        rectificar mi información personal, así como, los establecidos en el artículo 20 de la LOPDP y remitir mi requerimiento
                        a través del proceso de atención de derechos ARSO+; en cualquier momento y sin costo alguno, utilizando la página
                        web (www.banco-solidario.com), teléfono: 1700 765 432, comunicado escrito o en cualquiera de las agencias del
                        BANCO. </p>

                    <p>Para proteger esta información conozco que el Banco cuenta con medidas técnicas y organizativas de seguridad
                        adaptadas a los riesgos como, por ejemplo: anonimización, cifrado, enmascarado y seudonimización. </p>

                    <p>Con la lectura de este documento manifiesto que he sido informado sobre el Tratamiento de mis Datos Personales, y
                        otorgo mi autorización y aceptación de forma voluntaria y verídica. En señal de aceptación suscribo el presente
                        documento. </p>

                </body>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="$('#exampleModalLong').modal('hide')" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModalreq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Requisitos</h5>
                <button class="btn" type="button" onclick="$('#exampleModalreq').modal('hide')" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">

                <body>
                    <h1>Requisitos para solicitud de préstamo</h1>
                    <ul>
                        <li><strong>Edad:</strong> 21-63 años</li>
                        <li><strong>Documentos de identificación:</strong> Copia de cédula y certificado de votación.</li>
                        <li><strong>Comprobante de residencia:</strong> Planilla de servicios básicos (máximo un mes anterior al vigente).</li>
                        <li><strong>Referencias personales:</strong> 3 referencias (celular) personales y 1 laboral (jefe o compañero).</li>
                        <li><strong>Monto del préstamo:</strong> Mínimo $600 | Máximo $2.500</li>
                        <li><strong>Plazo del préstamo:</strong> Mínimo 6 meses | Máximo 36 meses</li>
                        <li><strong>Tasa de interés:</strong> La tasa de interés de la financiera es del 16.06% anual.</li>
                    </ul>
                </body>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="$('#exampleModalreq').modal('hide')" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Meta Pixel Code -->
<script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1534955887076711');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1534955887076711&ev=PageView&noscript=1" /></noscript>
<!-- End Meta Pixel Code -->


<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
<script src="assets/js/scripts.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<?php require 'views/footer.php'; ?>
<?php require 'funciones/guardar_js.php'; ?>
<script>
    // var codeInputs = $('.code-input');

    // // Añadir evento de entrada para cada campo
    // codeInputs.on('input', function() {
    //     // Obtener el índice del campo actual
    //     var currentIndex = codeInputs.index(this);

    //     // Mover al siguiente campo si se ha ingresado un dígito
    //     if ($(this).val().length === 1 && currentIndex < codeInputs.length - 1) {
    //         codeInputs.eq(currentIndex + 1).focus();
    //     }
    // });
    // codeInputs.first().focus();

    $(document).on('input', '.code-input', function(event) {
        var index = $('.code-input').index(this);
        if (event.originalEvent.inputType === 'deleteContentBackward' && index > 0) {
            if ($(this).val() === '') {
                index == 1 ? $('.code-input').eq(0).focus() : $('.code-input').eq(index - 1).focus();
            }
        } else if (index < $('.code-input').length - 1) {
            $('.code-input').eq(index + 1).focus();
        }
    });

    $(document).on('keydown', '.code-input', function(event) {
        if (event.which === 13) { // 13 is the keycode for Enter
            event.preventDefault();
            Validar_Codigo();
        }
    });

    $("#CELULAR").on('keydown', function(event) {
        if (event.which === 13) { // 13 is the keycode for Enter
            event.preventDefault();
            Guardar_Celular();
        }
    });
</script>