// Create and Update, inserta datos
function insert(data,controller,method='create'){
    $.ajax({
        type: "POST",
        url: `${url}/${controller}/${method}`,
        data: data,
        success: function (response) {
            console.log('success POST '+response);
            modalSuccess();
        },error: function (error){
            //console.log('error POST',error);
            modalError();
            throw new Error("Asi no se puede bro! :c "+error);
        }
    });
}

// CREATE -> Inserta datos y maneja una promesa
async function insertFetch(data, controller, method = 'create', idbtn = false) {
    try{
        // Bloquear botón si se pasa idbtn
        if (idbtn) {
            const btn = document.getElementById(`${idbtn}`);
            btn.disabled = true;
            btn.textContent = "Guardando...";
        }
        const config = {
            method: "POST",
            headers: {"Content-Type":"application/json"},
            body: JSON.stringify(data)
        }
        const response = await fetch(`${url}/${controller}/${method}`,config);
        if(!response.ok){
            throw new Error(`Error HTTP: ${response.status}`);
        }
        const result = await response.json();
        console.log('Success POST', result);
        modalSuccess();
        return result;
    } catch(error){
        modalError();
        console.error("Asi no se puede bro! :c", error);
    } finally{
        if (idbtn) {
            const btn = document.getElementById(`${idbtn}`);
            btn.disabled = false;
            btn.textContent = "Guardar";
        }
        console.log("Termina la peticion, falla o es exitoso se cumple esto");
    }
}
// CREATE WITH FILES,IMGs -> Inserta datos con archivos o imagenes y maneja una promesa
function insertWithFiles(data,controller,method='create'){
    $.ajax({
        type: "POST",
        url: `${url}/${controller}/${method}`,
        data: data,
        processData: false,
        contentType: false,
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
// READ -> Obtiene los datos y devuelve una promesa para procesarla despues
async function get(controller,method='get'){
    try{
        const data = await $.ajax({
            type: `POST`,
            url: `${url}/${controller}/${method}`,
            dataType: "json"
        });
        //console.log('Success GET');
        return data;
    }catch(error){
        console.log('ERROR GET');
        throw new Error("Error en crud Get"+error);
    }
}
// READ ONLY ONE -> obtiene datos de un solo registro o usuario
async function getOne(id,controller,method='getOne'){
    if(typeof id !== 'object'){
        var id = {'id':id};
    }
    try{
        const data = await $.ajax({
            type: `POST`,
            url: `${url}/${controller}/${method}`,
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
function delet(id,controller,method='delete'){
    if(typeof id !== 'object'){
        var id = {'id':id};
    }
    if(confirm('Desea eliminar el registro?')){
        $.ajax({
            type: "POST",
            url: `${url}/${controller}/${method}`,
            data: id,
            success: function (response) {
                console.log('success DELETE',response);
                modalSuccess();
            },error: function (error){
                console.log('error DELETE',error);
                modalError();
            }
        });
    }else{
        return false;
    }
}

// UPDATE -> Actualiza los datos
function update(data,controller,method='create'){
    $.ajax({
        type: "POST",
        url: `${url}/${controller}/${method}`,
        data: data,
        success: function (response) {
            console.log('success POST UPDATE '+response);
            modalSuccess();
        },error: function (error){
            //console.log('error POST',error);
            modalError();
            throw new Error("Asi no se puede bro! :c "+error);
        }
    });
}