function insert(data,controller,method='create'){
    $.ajax({
        type: "POST",
        url: `http://${host}/${proyect}/${controller}/${method}`,
        data: data,
        success: function (response) {
            console.log('success POST',response);
            modalSuccess();
        },error: function (error){
            //console.log('error POST',error);
            modalError();
            throw new Error("Asi no se puede bro! :c");
        }
    });
}
// SE USA UNA FUNCION ASYNC-> ASINCRONA PARA QUE LA FUNCION DEVUELVA LOS DATOS, ASI PODER TRATAR CON ESOS DATOS EN OTRA FUNCION Y NO DIRECTAMENTE EN EL AJAX
async function get(controller,method='get'){
    try{
        const data = await $.ajax({
            type: `POST`,
            url: `http://${host}/${proyect}/${controller}/${method}`,
            dataType: "json"
        });
        //console.log('Success GET');
        return data;
    }catch(error){
        console.log('ERROR GET');
        throw error;
    }
}
// FUNCIONA
async function getOne(id,controller,method='getOne'){
    if(typeof id !== 'object'){
        var id = {'id':id};
    }
    try{
        const data = await $.ajax({
            type: `POST`,
            url: `http://${host}/${proyect}/${controller}/${method}`,
            data: id,
            dataType: "json"
        });
        //console.log('Success GET');
        return data;
    }catch(error){
        console.log('ERROR GET');
        throw error;
    }
}
function delet(id,controller,method='getOne'){
    if(confirm('Desea eliminar el registro?')){
        $.ajax({
            type: "POST",
            url: `http://${host}/${proyect}/${controller}/${method}`,
            data: {id},
            dataType: "json",
            success: function (response) {
                console.log('success DELETE');
                modalSuccess();
            },error: function (error){
                console.log('error DELETE');
                modalError();
            }
        });
    }else{
        return false;
    }
}

// AUN NO FUNCIONA
function update(array){
    console.log(array);
    $.ajax({
        type: "POST",
        url: "url",
        data: {array},
        dataType: "json",
        success: function (response) {
            console.log('success PUT');
        },error: function (error){
            console.log('success PUT');
        }
    });
}