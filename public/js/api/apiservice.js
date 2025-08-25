import { CONFIG } from '../config.js';
import { modal, modalSuccess, modalError } from '../utils/modals.js';
export default class ApiService{
    constructor() {
        this.url = CONFIG.url;
        modal();
        //console.log(this.url);
    }
    // CREATE -> Crea un nuevo registro
    async create(data, controller, method = 'create', idbtn = false){
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
            const response = await fetch(`${this.url}/${controller}/${method}`,config);
            if(!response.ok){
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const result = await response.json();
            console.log('Success POST', result);
            modalSuccess();
            return result;
        } catch(error){
            modalError();
            console.error("Error en la peticion CREATE", error);
        } finally{
            if (idbtn) {
                const btn = document.getElementById(`${idbtn}`);
                btn.disabled = false;
                btn.textContent = "Guardar";
            }
            console.log("Termina la peticion, falla o es exitoso se cumple esto");
        }
    }
    // READ -> Obtiene todos los registros
    async read(controller,method='get'){
        try{
            const config ={
                method: "GET",
                headers: {"Content-Type":"application/json"},
            }
            const response = await fetch(`${this.url}/${controller}/${method}`,config);
             if(!response.ok){
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const data = await response.json();
            console.log('Success GET', data);
            return data;
        }catch(error){
            console.error("Error en la peticion GET: ", error);
            throw new Error("Error en crud GET", error);
        }
    }
    // UPDATE -> Actualiza un registro
    async update(data, controller, method='update'){
        try{
            const config = {
                method: "PATCH",
                headers: {"Content-Type":"application/json"},
                body: JSON.stringify(data)
            }
            const response = await fetch(`${this.url}/${controller}/${method}`,config);
            if(!response.ok){
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const result = await response.json();
            console.log('Success UPDATE', result);
            modalSuccess();
            return result;
        } catch(error){
            modalError();
            console.error("Error en la peticion Actualizar", error);
            throw new Error("Error en crud UPDATE", error);
        }
    }
    // DELETE -> Elimina un registro
    async delete(id,controller,method='delete'){
        try{
            if(typeof id !== 'object'){
                var id = {'id':id};
            }
            const config = {
                method: "POST",
                headers: {"Content-Type":"application/json"},
                body: JSON.stringify(id)
            }
            if(!confirm('Desea eliminar el registro?')){
                return false;
            }
            const response = await fetch(`${this.url}/${controller}/${method}`,config);
            if(!response.ok){
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const result = await response.json();
            console.log('Success DELETE', result);
            modalSuccess();
            return result;
        }catch(error){
            modalError();
            console.error("Error en la peticion Eliminar", error);
            throw new Error("Error en crud DELETE", error);
        }
    }
    // READ ONLY ONE -> Obtiene un solo registro
    async readOne(id,controller,method='getOne'){
        try{
            if(typeof id !== 'object'){
                var id = {'id':id};
            }
            const config ={
                method: "POST",
                headers: {"Content-Type":"application/json"},
                body: JSON.stringify(id)
            }
            const response = await fetch(`${this.url}/${controller}/${method}`,config);
             if(!response.ok){
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const data = await response.json();
            console.log('Success READ ONE', data);
            //console.info('Success READ ONE', data);
            return data;
        }catch(error){
            console.error("Error en la peticion READ ONE", error);
            throw error;
        }
        
    }
    // CREATE WITH FILES,IMGs -> Inserta datos con archivos o imagenes => FORMDATA
    async createWithFiles(data, controller, method = 'createFiles', idbtn = false){
        try{
            // Bloquear botón si se pasa idbtn
            if (idbtn) {
                const btn = document.getElementById(`${idbtn}`);
                btn.disabled = true;
                btn.textContent = "Guardando...";
            }
            const config = {
                method: "POST",
                body: data
            }
            const response = await fetch(`${this.url}/${controller}/${method}`,config);
            if(!response.ok){
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const result = await response.json();
            console.log('Success POST', result);
            modalSuccess();
            return result;
        } catch(error){
            modalError();
            console.error("Error en la peticion INSERTAR CON ARCHIVOS", error);
        } finally{
            if (idbtn) {
                const btn = document.getElementById(`${idbtn}`);
                btn.disabled = false;
                btn.textContent = "Guardar";
            }
            console.log("Termina la peticion, falla o es exitoso se cumple esto");
        }
    }
}