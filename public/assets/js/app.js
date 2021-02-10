/**
 * Rempli un select à partir des données passées en paramètre
 *
 * @param select
 * @param data
 * @param valueKey
 * @param textKey
 * @param selectAllOption
 * @param selectedValues
 */
function fillSelectBox(select, data, valueKey, textKey, selectAllOption, selectedValues)
{
    let options = "";
    if( data.length <=0){
        options = "";
    }else if( data.length === 1 ){
        if(select.prop("required") === true)
            options = "<option value='"+data[0][valueKey]+"' selected>"+data[0][textKey]+"</option>";
        else{
            options += "<option value=''>-- Choisissez --</option>";
            options += "<option value='"+data[0][valueKey]+"'>"+data[0][textKey]+"</option>";
        }
    }else if( data.length > 1 ){
        if( selectAllOption === true ){
            //if(selectedValues===undefined || !selectedValues || selectedValues===null)
            if(selectedValues===undefined || !selectedValues)
                options += "<option value='ALL' selected>Tout</option>";
            else
                options += "<option value='ALL'>Tout</option>";
        }else if( !select.prop("multiple") ){
            options += "<option value=''>-- Choisissez --</option>";
        }
        $.each(data, function(k,v){
            if( selectedValues!==undefined && $.inArray(v[valueKey], selectedValues) !== -1 ){
                options += "<option value='"+v[valueKey]+"' selected>"+v[textKey]+"</option>";
            } else
                options += "<option value='"+v[valueKey]+"' >"+v[textKey]+"</option>";
        });
    }

    select.find("option").remove();
    select.append(options);
}

/**
 * Chargement des données et stockage dans le local storage
 */
function loadData(){
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
}

$(document).ready(function(){
    loadData();
});
