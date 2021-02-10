

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
    fillSelectBox($("#camp_ville"), villes,"code","libelle");
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
});
