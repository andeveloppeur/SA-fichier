var divDiag = document.getElementById("chartdiv");

divDiag.addEventListener("click", sijeDoubleClikDev);
divDiag.addEventListener("click", sijeDoubleClikRef);
divDiag.addEventListener("click", sijeDoubleClikData);


function sijeDoubleClikDev() {
    ///////////////////////----dev---///////////////////////////
    var diagramdevAbs = document.getElementById("id-455");
    diagramdevAbs.addEventListener("click", devAbsclicker);
    var jour = document.getElementById("jourR");
    var jourR = jour.getAttribute("class");

    function devAbsclicker() {
        document.location.href = "presence.php?promo=Dev Web&statut=absents&laDate=" + jourR;

    }

    var diagramdevPres = document.getElementById("id-413");
    diagramdevPres.addEventListener("click", devPresclicker);

    function devPresclicker() {
        document.location.href = "presence.php?promo=Dev Web&statut=present&laDate=" + jourR;

    }
    ///////////////////////----Fin dev---///////////////////////////
}

function sijeDoubleClikRef() {
    ///////////////////////----Ref Dig---///////////////////////////
    var diagramrefAbs = document.getElementById("id-469");
    diagramrefAbs.addEventListener("click", refAbsclicker);
    var jour = document.getElementById("jourR");
    var jourR = jour.getAttribute("class");

    function refAbsclicker() {
        document.location.href = "presence.php?promo=Ref Dig&statut=absents&laDate=" + jourR;

    }

    var diagramrefPres = document.getElementById("id-427");
    diagramrefPres.addEventListener("click", refPresclicker);

    function refPresclicker() {
        document.location.href = "presence.php?promo=Ref Dig&statut=present&laDate=" + jourR;

    }
    ///////////////////////----Fin Ref Dig---///////////////////////////
}

function sijeDoubleClikData() {
    ///////////////////////----data art---///////////////////////////
    var diagramdataAbs = document.getElementById("id-483");
    diagramdataAbs.addEventListener("click", dataAbsclicker);
    var jour = document.getElementById("jourR");
    var jourR = jour.getAttribute("class");

    function dataAbsclicker() {
        document.location.href = "presence.php?promo=Data Art&statut=absents&laDate=" + jourR;

    }

    var diagramdataPres = document.getElementById("id-441");
    diagramdataPres.addEventListener("click", dataPresclicker);

    function dataPresclicker() {
        document.location.href = "presence.php?promo=Data Art&statut=present&laDate=" + jourR;

    }
    ///////////////////////----Fin data art---///////////////////////////
}