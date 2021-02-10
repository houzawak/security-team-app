
/*function loadData(){
    $.ajax({
        url: Routing.generate("load_data"),
        type: "get",
        dataType: "json",
        success: function(response){
            $.each(response.data, function(key, value){
                if( sessionStorage.getItem(key) ) sessionStorage.removeItem(key);
                sessionStorage.setItem(key,JSON.stringify(value) );
            });

        },
        error: function(){
            alert("Une erreur s'est produite lors du chargement des données")
        }
    });
}*/

function regionChange(){
    let code_region = $("#region").val();
    let prefectures = JSLINQ( JSON.parse( sessionStorage.getItem("prefectures") ) )
        .Where(function(item){ return item.region.code === code_region ;  })
        .Select(function(item){ return item; })
    ;
    console.log(prefectures);
    prefectures = prefectures.items;
    fillSelectBox($("#prefecture"), prefectures,"code","libelle");
}

function prefectureChange(){
    let code_prefecture = $("#prefecture").val();
    console.log(code_prefecture);
    let communes = JSLINQ( JSON.parse( sessionStorage.getItem("communes") ) )
        .Where(function(item){ return item.prefecture.code === code_prefecture ;  })
        .Select(function(item){ return item; })
    ;
    communes = communes.items;
    fillSelectBox($("#commune"), communes,"code","libelle");
}

function communeChange(){
    let code_commune = $("#commune").val();
    console.log(JSON.parse( sessionStorage.getItem("villes")));
    let villes = JSLINQ( JSON.parse( sessionStorage.getItem("villes") ) )
        .Where(function(item){ return item.commune.code === code_commune ;  })
        .Select(function(item){ return item; })
    ;
    villes = villes.items;
    console.log(villes);
    fillSelectBox($("#ville"), villes,"code","libelle");
}

function villeChange(){
    let code_ville = $("#ville").val();
    console.log(JSON.parse( sessionStorage.getItem("camps")));
    let villes = JSLINQ( JSON.parse( sessionStorage.getItem("camps") ) )
        .Where(function(item){ return item.ville.code == code_ville ;  })
        .Select(function(item){ return item; })
    ;
    villes = villes.items;
    console.log(villes);
    fillSelectBox($("#camp"), villes,"code","libelle");
}

/**
 * Recherche des personnes
 */
function searchTeamForm()
{
    $.ajax({
        url: Routing.generate("search_team"),
        type: "get",
        dataType: "json",
        success: function(response){
            if(response.status === "success"){

            }else{
                alert("Une erreur s'est produite : "+response.message);
            }
            $.each(response.data, function(key, value){
                if( sessionStorage.getItem(key) ) sessionStorage.removeItem(key);
                sessionStorage.setItem(key,JSON.stringify(value) );
                /*if( key === "villesList" ){
                    //Extraction des villes ayants au moins une agence
                    let result = JSLINQ(value)
                        .Where(function(item){  return item.hasAgence === true })
                        .Select(function(item){ return item; })
                    ;
                    sessionStorage.setItem("villesHavingAgences",JSON.stringify(result.items) );
                }*/
            });

        },
        error: function(){
            alert("Une erreur s'est produite lors du chargement des données")
        }
    })
}


$(document).ready(function(){
    //loadData();
    $("select").select2();
    $("#region").on("change", function(){
        regionChange();
    });
    $("#prefecture").on("change", function(){
        prefectureChange();
    });
    $("#commune").on("change", function(){
        communeChange();
    });
    $("#ville").on("change", function(){
        villeChange();
    });

    //Soumission du formulaire
    $("#searchTeam").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: Routing.generate("search_team"),
            type: "get",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response){
                if( response.status === "success" ){
                    let resultat = "";
                    $.each(response.data, function(k,v){
                        let row_style = "border-bottom:1px: solid #dedede";
                        if(v.position === 1){
                            row_style = "border-bottom:1px: solid #dedede;border: 2px solid #264DF1;background: #B7F1F9;border-radius:3px ";
                        }
                        //resultat += "<div class='row' style='border-bottom:1px: solid #dedede'>" +
                        resultat += "<div class='row mt-3 pt-2' style='"+row_style+"'>" +
                            "<div class='col-sm-3'>" +
                            "<img src='"+v.photo+"' alt='Photo' style='max-width: 100%;max-height: 100%' />" +
                            "</div>" +
                            "<div class='col-sm-8'>" +
                            "<ul>" +
                            "<li><span style='font-weight: bolder'>Nom : </span>"+v.nom+"</li>" +
                            "<li><span style='font-weight: bolder'>Prénoms : </span>"+v.prenoms+"</li>" +
                            "<li><span style='font-weight: bolder'>Poste : </span>"+v.poste+"</li>" +
                            "<li><span style='font-weight: bolder'>Grade : </span>"+v.grade+"</li>" +
                            "<li><span style='font-weight: bolder'>Camp/Poste : </span>"+v.campAffectation.libelle+"</li>" +
                            "</ul>" +
                            "</div>" +
                            "</div>";
                    });
                    $("#resultat").html( resultat );
                }else{
                    alert("Aucun résultat retrouvé");
                }
            },
            error: function(){
                alert("Une erreur s'est produit, merci de vérifier votre connexion");
            }
        });
    })
});
