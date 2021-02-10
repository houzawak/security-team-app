
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
    let camps = JSLINQ( JSON.parse( sessionStorage.getItem("camps") ) )
        .Where(function(item){ return item.ville.code == code_ville ;  })
        .Select(function(item){ return item; })
    ;
    camps = camps.items;
    console.log(camps);
    fillSelectBox($("#personne_campAffectation"), camps,"code","libelle");
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
});
