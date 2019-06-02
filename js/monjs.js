var divDiag = document.getElementById("chartdiv");

divDiag.addEventListener("click", sijeDoubleClikDev);
divDiag.addEventListener("click", sijeDoubleClikRef);
divDiag.addEventListener("click", sijeDoubleClikData);


function sijeDoubleClikDev() {
    ///////////////////////----dev---///////////////////////////
    var diagramdevAbs = document.getElementById("id-455");
    diagramdevAbs.addEventListener("click", devAbsclicker);

    function devAbsclicker() {
        document.location.href = "presence.php?promo=Dev Web&statut=Absent";

    }

    var diagramdevPres = document.getElementById("id-413");
    diagramdevPres.addEventListener("click", devPresclicker);

    function devPresclicker() {
        document.location.href = "presence.php?promo=Dev Web&statut=Present";

    }
    ///////////////////////----Fin dev---///////////////////////////
}

function sijeDoubleClikRef() {
    ///////////////////////----Ref Dig---///////////////////////////
    var diagramrefAbs = document.getElementById("id-469");
    diagramrefAbs.addEventListener("click", refAbsclicker);

    function refAbsclicker() {
        document.location.href = "presence.php?promo=Ref Dig&statut=Absent";

    }

    var diagramrefPres = document.getElementById("id-427");
    diagramrefPres.addEventListener("click", refPresclicker);

    function refPresclicker() {
        document.location.href = "presence.php?promo=Ref Dig&statut=Present";

    }
    ///////////////////////----Fin Ref Dig---///////////////////////////
}

function sijeDoubleClikData() {
    ///////////////////////----data art---///////////////////////////
    var diagramdataAbs = document.getElementById("id-483");
    diagramdataAbs.addEventListener("click", dataAbsclicker);

    function dataAbsclicker() {
        document.location.href = "presence.php?promo=Data Art&statut=Absent";

    }

    var diagramdataPres = document.getElementById("id-441");
    diagramdataPres.addEventListener("click", dataPresclicker);

    function dataPresclicker() {
        document.location.href = "presence.php?promo=Data Art&statut=Present";

    }
    ///////////////////////----Fin data art---///////////////////////////
}