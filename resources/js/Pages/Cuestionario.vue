<script setup>
import {onMounted, onUnmounted, ref} from "vue";
import {router, Link, usePage, useForm} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import Stepper from 'bs-stepper'
import 'bs-stepper/dist/css/bs-stepper.min.css'
import {genFileId} from "element-plus";

const page = usePage()

defineProps({
    usuarios: Object,
    empresas: Object
})

let formGuardado = ref(JSON.parse(localStorage.getItem('form')));
let form = useForm({
    signos_vitales: {
        peso: formGuardado.value !== null ? formGuardado.value.signos_vitales.peso : null,
        estatura: formGuardado.value !== null ? formGuardado.value.signos_vitales.estatura : null,
        p_sistolica: formGuardado.value !== null ? formGuardado.value.signos_vitales.p_sistolica : null,
        p_diastolica: formGuardado.value !== null ? formGuardado.value.signos_vitales.p_diastolica : null,
        pulso: formGuardado.value !== null ? formGuardado.value.signos_vitales.pulso : null,
        temperatura: formGuardado.value !== null ? formGuardado.value.signos_vitales.temperatura : null,
    },
    medidas: {
        cuello: formGuardado.value !== null ? formGuardado.value.medidas.cuello : null,
        pecho: formGuardado.value !== null ? formGuardado.value.medidas.pecho : null,
        cintura: formGuardado.value !== null ? formGuardado.value.medidas.cintura : null,
        caderas: formGuardado.value !== null ? formGuardado.value.medidas.caderas : null,
    },
    datos_generales: {
        empresa: formGuardado.value !== null ? formGuardado.value.datos_generales.empresa : null,
        nombre: formGuardado.value !== null ? formGuardado.value.datos_generales.nombre : null,
        avatar: formGuardado.value !== null ? formGuardado.value.datos_generales.avatar : null,
        nacimiento: formGuardado.value !== null ? formGuardado.value.datos_generales.nacimiento : null,
        edad: formGuardado.value !== null ? formGuardado.value.datos_generales.edad : null,
        sexo: formGuardado.value !== null ? formGuardado.value.datos_generales.sexo : null,
        ciudad_origen: formGuardado.value !== null ? formGuardado.value.datos_generales.ciudad_origen : null,
    },
    info_contacto: {
        telefono: formGuardado.value !== null ? formGuardado.value.info_contacto.telefono : null,
        correo: formGuardado.value !== null ? formGuardado.value.info_contacto.correo : null,
        direccion: formGuardado.value !== null ? formGuardado.value.info_contacto.direccion : null,
        desde_cuando: formGuardado.value !== null ? formGuardado.value.info_contacto.desde_cuando : null,
        lugar_crianza: formGuardado.value !== null ? formGuardado.value.info_contacto.lugar_crianza : null,
    },
    estado_civil: {
        estado: formGuardado.value !== null ? formGuardado.value.estado_civil.estado : null,
        desde_cuando: formGuardado.value !== null ? formGuardado.value.estado_civil.desde_cuando : null,
        hijos: formGuardado.value !== null ? formGuardado.value.estado_civil.hijos : null,
        edades_hijos: formGuardado.value !== null ? formGuardado.value.estado_civil.edades_hijos : null,
    },
    escolaridad: {
        grado_estudios: formGuardado.value !== null ? formGuardado.value.escolaridad.grado_estudios : null,
        carrera: formGuardado.value !== null ? formGuardado.value.escolaridad.carrera : null,
    },
    oficio_profesion: {
        oficio: formGuardado.value !== null ? formGuardado.value.oficio_profesion.oficio : null,
        profesion: formGuardado.value !== null ? formGuardado.value.oficio_profesion.profesion : null,
        ultimo_trabajo: formGuardado.value !== null ? formGuardado.value.oficio_profesion.ultimo_trabajo : null,
        hasta_cuando: formGuardado.value !== null ? formGuardado.value.oficio_profesion.hasta_cuando : null,
    },
    toxicomanias: {
        fuma: formGuardado.value !== null ? formGuardado.value.toxicomanias.fuma : null,
        cuantos_cigarillos: formGuardado.value !== null ? formGuardado.value.toxicomanias.cuantos_cigarillos : null,
        bebe: formGuardado.value !== null ? formGuardado.value.toxicomanias.bebe : null,
    },
    vivienda: {
        personas_vivienda: formGuardado.value !== null ? formGuardado.value.vivienda.personas_vivienda : [],
        cantidad_personas: formGuardado.value !== null ? formGuardado.value.vivienda.cantidad_personas : null,
        estado_vivienda: formGuardado.value !== null ? formGuardado.value.vivienda.estado_vivienda : null,
        propietario_vivienda: formGuardado.value !== null ? formGuardado.value.vivienda.propietario_vivienda : null,
        recamaras: formGuardado.value !== null ? formGuardado.value.vivienda.recamaras : null,
        banos: formGuardado.value !== null ? formGuardado.value.vivienda.banos : null,
        cuartos: formGuardado.value !== null ? formGuardado.value.vivienda.cuartos : null,
        material_vivienda: formGuardado.value !== null ? formGuardado.value.vivienda.material_vivienda : null,
    },
    estado_salud: {
        vacuna_influenza: formGuardado.value !== null ? formGuardado.value.estado_salud.vacuna_influenza : null,
        vacuna_covid: formGuardado.value !== null ? formGuardado.value.estado_salud.vacuna_covid : null,
        ejercicio_semana: formGuardado.value !== null ? formGuardado.value.estado_salud.ejercicio_semana : null,
    },
    habitos_sueno: {
        ronca: formGuardado.value !== null ? formGuardado.value.habitos_sueno.ronca : null,
        deja_respirar: formGuardado.value !== null ? formGuardado.value.habitos_sueno.deja_respirar : null,
        adormilado: formGuardado.value !== null ? formGuardado.value.habitos_sueno.adormilado : null,
    },
    senas_particulares: {
        tono_piel: formGuardado.value !== null ? formGuardado.value.senas_particulares.tono_piel : null,
        color_cabello: formGuardado.value !== null ? formGuardado.value.senas_particulares.color_cabello : null,
        pelo_tenido: formGuardado.value !== null ? formGuardado.value.senas_particulares.pelo_tenido : null,
        tipo_cabello: formGuardado.value !== null ? formGuardado.value.senas_particulares.tipo_cabello : null,
        longitud_cabello: formGuardado.value !== null ? formGuardado.value.senas_particulares.longitud_cabello : null,
        complexion_fisica: formGuardado.value !== null ? formGuardado.value.senas_particulares.complexion_fisica : null,
        forma_nariz: formGuardado.value !== null ? formGuardado.value.senas_particulares.forma_nariz : null,
        color_ojos: formGuardado.value !== null ? formGuardado.value.senas_particulares.color_ojos : null,
        lunar: formGuardado.value !== null ? formGuardado.value.senas_particulares.lunar : null,
        lunar_descripcion: formGuardado.value !== null ? formGuardado.value.senas_particulares.lunar_descripcion : null,
        tatuaje: formGuardado.value !== null ? formGuardado.value.senas_particulares.tatuaje : null,
        tatuaje_descripcion: formGuardado.value !== null ? formGuardado.value.senas_particulares.tatuaje_descripcion : null,
        cicatriz: formGuardado.value !== null ? formGuardado.value.senas_particulares.cicatriz : null,
        cicatriz_descripcion: formGuardado.value !== null ? formGuardado.value.senas_particulares.cicatriz_descripcion : null,
    },
    discapacidades: {
        discapacidad: formGuardado.value !== null ? formGuardado.value.discapacidades.discapacidad : null,
        protesis: formGuardado.value !== null ? formGuardado.value.discapacidades.protesis : null,
        funcion_protesis: formGuardado.value !== null ? formGuardado.value.discapacidades.funcion_protesis : null,
        claudica: formGuardado.value !== null ? formGuardado.value.discapacidades.claudica : null,
        discapacidad_visual: formGuardado.value !== null ? formGuardado.value.discapacidades.discapacidad_visual : [],
        lentes_pupilentes: formGuardado.value !== null ? formGuardado.value.discapacidades.lentes_pupilentes : null,
        falta_pieza_dental: formGuardado.value !== null ? formGuardado.value.discapacidades.falta_pieza_dental : null,
        empastes: formGuardado.value !== null ? formGuardado.value.discapacidades.empastes : null,
        patologias: formGuardado.value !== null ? formGuardado.value.discapacidades.patologias : [],
        patologias_familia: formGuardado.value !== null ? formGuardado.value.discapacidades.patologias : [],

    },
    avatar: null,
})
let discapacidad_visual_otros = ref(null);
let aceptar_politica = ref(JSON.parse(localStorage.getItem('aceptar_politica')) === true ? true: false);
let modal_politica = ref(null);
let step = ref(1);
let stepper = ref(null);

const upload = ref();
let dialogImageUrl = ref('');
let dialogVisible = ref(false);
let prevImageHeight = ref(210);
let fullScreen = ref(document.fullscreenElement);

const opciones = [
    {value: 'Hipertensión',label: 'Hipertensión',},
    {value: 'Diabetes',label: 'Diabetes',},
    {value: 'Triglicéridos elevados',label: 'Triglicéridos elevados',},
    {value: 'Colesterol alto',label: 'Colesterol alto',},
    {value: 'Ácido úrico elevado',label: 'Ácido úrico elevado',},
    {value: 'Gota',label: 'Gota',},
    {value: 'Lesiones en la columna vertebral',label: 'Lesiones en la columna vertebral',},
    {value: 'Cirugías previas',label: 'Cirugías previas',},
    {value: 'Mareos recurrentes',label: 'Mareos recurrentes',},
    {value: 'Anemia crónica',label: 'Anemia crónica',},
    {value: 'Alergias',label: 'Alergias',},
    {value: 'Gastritis',label: 'Gastritis',},
    {value: 'Cáncer',label: 'Cáncer (especificar tipo si es conocido)',},
    {value: 'Artritis',label: 'Artritis',},
    {value: 'Problemas cardíacos',label: 'Problemas cardíacos',},
    {value: 'Trastornos respiratorios',label: 'Trastornos respiratorios',},
    {value: 'Enfermedades hereditarias',label: 'Enfermedades hereditarias',},
]

onMounted(()=>{
    document.addEventListener('DOMContentLoaded', ()=>{
        let rect = document.getElementById('avatar').getBoundingClientRect();
        prevImageHeight.value = rect.height;
    })

    const options = {
        backdrop: 'static'
    }
    const myModalEl = document.getElementById('staticBackdropPoliticaPrivacidad');
    const myModal = new bootstrap.Modal(myModalEl, options);
    modal_politica.value = myModal;
    !aceptar_politica.value ? modal_politica.value.show() : null;

    localStorage.setItem('sb|sidebar-toggle', false);
    toggleNavbar()

    const btn_aceptar = document.querySelector('#btn_aceptar');
    btn_aceptar.addEventListener('click', ()=>{
        modal_politica.value.hide();
        localStorage.setItem('aceptar_politica', true);
    })

    myModalEl.addEventListener('hidden.bs.modal', (e) => {
        JSON.parse(localStorage.getItem('aceptar_politica')) === true || aceptar_politica.value === 'cancel' ? myModal.hide(): myModal.show()
    })

    const show_politica_privacidad = document.querySelector('#show_politica_privacidad');
    show_politica_privacidad.addEventListener('click', ()=>{
        modal_politica.value.show();
    })

    stepper.value = new Stepper(document.querySelector('.bs-stepper'));
    const bsStepperHeader = document.querySelector('.bs-stepper-header');
    step.value = localStorage.getItem('step') !== null ? Number(localStorage.getItem('step')) : 1
    stepper.value.to(step.value);
    step.value === 1 ? bsStepperHeader.scrollLeft+= 0 : bsStepperHeader.scrollLeft += (50 * step.value);
    const btnNext = document.querySelector('#btnNext')
    btnNext.addEventListener('click', () =>{
        if(validarEtapa(step.value)){
            localStorage.setItem('form', JSON.stringify(form));
            stepper.value.next();
            step.value++;
            localStorage.setItem('step', step.value);
            bsStepperHeader.scrollLeft += 65;

        }
    })

    const btnPrev = document.querySelector('#btnPrev')
    btnPrev.addEventListener('click', () =>{
        stepper.value.previous();
        step.value--;
        localStorage.setItem('step', step.value);
        bsStepperHeader.scrollLeft -= 65;
    })

    const flexRadioDefault4 = document.querySelector('#flexRadioDefault4');
    flexRadioDefault4.addEventListener('click', () => {
        const ciudad_otros = document.querySelector('#ciudad_otros');
        ciudad_otros.focus();
        form.datos_generales.ciudad_origen = null;
    })

    const flexRadioDefault7 = document.querySelector('#flexRadioDefault7');
    flexRadioDefault7.addEventListener('click', () => {
        const ciudad_otros = document.querySelector('#estado_civil_otros');
        ciudad_otros.focus();
        form.estado_civil.estado = null;
    })

    const flexRadioDefault16 = document.querySelector('#flexRadioDefault16');
    flexRadioDefault16.addEventListener('click', () => {
        const oficio_otros = document.querySelector('#oficio_otros');
        oficio_otros.focus();
        form.oficio_profesion.oficio = null;
    })

    const flexRadioDefault18 = document.querySelector('#flexRadioDefault18');
    flexRadioDefault18.addEventListener('click', () => {
        const profesion_otros = document.querySelector('#profesion_otros');
        profesion_otros.focus();
        form.oficio_profesion.profesion = null;
    })

    const flexRadioDefault30 = document.querySelector('#flexRadioDefault30');
    flexRadioDefault30.addEventListener('click', () => {
        const propietario_vivienda = document.querySelector('#propietario_vivienda');
        propietario_vivienda.focus();
        form.vivienda.propietario_vivienda = null;
    })

    const flexRadioDefault54 = document.querySelector('#flexRadioDefault54');
    flexRadioDefault54.addEventListener('click', () => {
        const material_vivienda = document.querySelector('#material_vivienda');
        material_vivienda.focus();
        form.vivienda.material_vivienda = null;
    })

    const flexRadioDefault74 = document.querySelector('#flexRadioDefault74');
    flexRadioDefault74.addEventListener('click', () => {
        const piel_otras = document.querySelector('#piel_otras');
        piel_otras.focus();
        form.senas_particulares.tono_piel = null;
    })

    const flexRadioDefault79 = document.querySelector('#flexRadioDefault79');
    flexRadioDefault79.addEventListener('click', () => {
        const color_cabello_otros = document.querySelector('#color_cabello_otros');
        color_cabello_otros.focus();
        form.senas_particulares.color_cabello = null;
    })

    const flexRadioDefault115 = document.querySelector('#flexRadioDefault115');
    flexRadioDefault115.addEventListener('click', () => {
        const discapacidad_otros = document.querySelector('#discapacidad_otros');
        discapacidad_otros.focus();
        form.discapacidades.discapacidad = null;
    })

    const flexCheckDefault11 = document.querySelector('#flexCheckDefault11');
    flexCheckDefault11.addEventListener('click', () => {
        const discapacidad_visual_otros_input = document.querySelector('#discapacidad_visual_otros');
        discapacidad_visual_otros_input.focus();
        form.discapacidades.discapacidad_visual = form.discapacidades.discapacidad_visual.filter(dis => dis !== discapacidad_visual_otros.value)
        discapacidad_visual_otros.value = null;
    })

})

onUnmounted(()=>{
    modal_politica.value.hide()
})

const validationMessage = (msg) => {
    Swal.fire({
        icon: 'warning',
        title: 'Validación de Formulario',
        text: msg
    })
    return false;
}

const validarEtapa = (etapa) =>{
    if(etapa === 1) return true;
    if(etapa === 2){
        if(form.signos_vitales.peso === null || form.signos_vitales.peso === '') return validationMessage('El peso es un campo requerido')
        if(form.signos_vitales.estatura === null || form.signos_vitales.estatura === '') return validationMessage('La estatura es un campo requerido');
        if(form.signos_vitales.p_sistolica === null || form.signos_vitales.p_sistolica === '') return validationMessage('La presión sistólica es un campo requerido');
        if(form.signos_vitales.p_diastolica === null || form.signos_vitales.p_diastolica === '') return validationMessage('La presión diastólica es un campo requerido');
        if(form.signos_vitales.pulso === null || form.signos_vitales.pulso === '') return validationMessage('El pulso es un campo requerido');
        if(form.signos_vitales.temperatura === null || form.signos_vitales.temperatura === '') return validationMessage('La temperatura es un campo requerido');
        return true
    }
    if(etapa === 3){
        if(form.medidas.cuello === null || form.medidas.cuello === '') return validationMessage('El cuello es un campo requerido')
        if(form.medidas.pecho === null || form.medidas.pecho === '') return validationMessage('El pecho es un campo requerido');
        if(form.medidas.cintura === null || form.medidas.cintura === '') return validationMessage('La cintura es un campo requerido');
        if(form.medidas.caderas === null || form.medidas.caderas === '') return validationMessage('La cadera es un campo requerido');
        return true
    }
    if(etapa === 4){
        if(form.datos_generales.empresa === null || form.datos_generales.empresa === '') return validationMessage('La empresa es un campo requerido')
        if(form.datos_generales.nombre === null || form.datos_generales.nombre === '') return validationMessage('El nombre es un campo requerido');
        if(form.datos_generales.avatar === null || form.datos_generales.avatar === '') return validationMessage('La imágen de perfil es un campo requerido');
        if(form.datos_generales.nacimiento === null || form.datos_generales.nacimiento === '') return validationMessage('La fecha de nacimiento es un campo requerido');
        if(form.datos_generales.edad === null || form.datos_generales.edad === '') return validationMessage('La edad es un campo requerido');
        if(form.datos_generales.sexo === null || form.datos_generales.sexo === '') return validationMessage('El sexo es un campo requerido');
        if(form.datos_generales.ciudad_origen === null || form.datos_generales.ciudad_origen === '') return validationMessage('La ciudad de origen es un campo requerido');
        return true
    }
    if(etapa === 5){
        if(form.info_contacto.telefono === null || form.info_contacto.telefono === '') return validationMessage('El teléfono es un campo requerido')
        if(form.info_contacto.correo === null || form.info_contacto.correo === '') return validationMessage('El correo es un campo requerido');
        if(form.info_contacto.direccion === null || form.info_contacto.direccion === '') return validationMessage('La dirección es un campo requerido');
        if(form.info_contacto.desde_cuando === null || form.info_contacto.desde_cuando === '') return validationMessage('La fecha desde cuando reside en su dirección actual es un campo requerido');
        if(form.info_contacto.lugar_crianza === null || form.info_contacto.lugar_crianza === '') return validationMessage('El lugar de crianza es un campo requerido');
        return true
    }
    if(etapa === 6){
        if(form.estado_civil.estado === null || form.estado_civil.estado === '') return validationMessage('El estado civil es un campo requerido')
        if(form.estado_civil.desde_cuando === null || form.estado_civil.desde_cuando === '') return validationMessage('Desde cuando es un campo requerido');
        if(form.estado_civil.hijos === null || form.estado_civil.hijos === '') return validationMessage('Tiene usted hijos es un campo requerido');
        if((form.estado_civil.edades_hijos === null || form.estado_civil.edades_hijos === '') && form.estado_civil.hijos !== 'Sin hijos') return validationMessage('Las edades de sus hijos es un campo requerido, separe las edades con una coma, ejemplo: caso de 3 hijos ( 20, 25, 28) ');
        return true
    }
    if(etapa === 7){
        if(form.escolaridad.grado_estudios === null || form.info_contacto.telefono === '') return validationMessage('El grado de escolaridad es un campo requerido')
        return true
    }
    if(etapa === 8){
        if(form.oficio_profesion.oficio === null || form.oficio_profesion.oficio === '') return validationMessage('El oficio es un campo requerido')
        if(form.oficio_profesion.profesion === null || form.oficio_profesion.profesion === '') return validationMessage('La profesión es un campo requerido');
        if(form.oficio_profesion.ultimo_trabajo === null || form.oficio_profesion.ultimo_trabajo === '') return validationMessage('El ultimo trabajo es un campo requerido');
        if(form.oficio_profesion.hasta_cuando === null || form.oficio_profesion.hasta_cuando === '') return validationMessage('Hasta cuando es un campo requerido');
        return true
    }
    if(etapa === 9){
        if(form.toxicomanias.fuma === null || form.toxicomanias.fuma === '') return validationMessage('Marcar si usted fuma es un campo requerido')
        if((form.toxicomanias.cuantos_cigarillos === null || form.toxicomanias.cuantos_cigarillos === '') && form.toxicomanias.fuma === 'positivo') return validationMessage('Ingrese la cantidad de cigarrillos que fuma en la semana');
        if(form.toxicomanias.bebe === null || form.toxicomanias.bebe === '') return validationMessage('Marcar si usted bebe es un campo requerido');
        return true
    }

    if(etapa === 10){
        if(form.vivienda.personas_vivienda === null || form.vivienda.personas_vivienda === '') return validationMessage('Marcar las personas con las q convive es un campo requerido')
        if((form.vivienda.cantidad_personas === null || form.vivienda.cantidad_personas === '') && form.toxicomanias.fuma === 'positivo') return validationMessage('Ingrese la cantidad de personas con las q convive');
        if(form.vivienda.estado_vivienda === null || form.vivienda.estado_vivienda === '') return validationMessage('El estado de la vivienda es un campo requerido');
        if(form.vivienda.propietario_vivienda === null || form.vivienda.propietario_vivienda === '') return validationMessage('El propietario de la vivienda donde vive es un campo requerido');
        if(form.vivienda.recamaras === null || form.vivienda.recamaras === '') return validationMessage('La cantidad de recámaras es un campo requerido');
        if(form.vivienda.banos === null || form.vivienda.banos === '') return validationMessage('La cantidad de baños es un campo requerido');
        if(form.vivienda.cuartos === null || form.vivienda.cuartos === '') return validationMessage('La cantidad de cuartos es un campo requerido');
        if(form.vivienda.material_vivienda === null || form.vivienda.material_vivienda === '') return validationMessage('El material de construcción de la vivienda es un campo requerido');
        return true
    }

    if(etapa === 11){
        if(form.estado_salud.vacuna_influenza === null || form.estado_salud.vacuna_influenza === '') return validationMessage('Marcar si ha recibido la vacuna de influenza es un campo requerido')
        if((form.estado_salud.vacuna_covid === null || form.estado_salud.vacuna_covid === '') && form.toxicomanias.fuma === 'positivo') return validationMessage('Marcar si ha recibido la vacuna de covid es un campo requerido');
        if(form.estado_salud.ejercicio_semana === null || form.estado_salud.ejercicio_semana === '') return validationMessage('Marcar si hace ejercicios en la semana es un campo requerido');
        return true
    }

    if(etapa === 12){
        if(form.habitos_sueno.ronca === null || form.habitos_sueno.ronca === '') return validationMessage('Marcar si usted ronca es un campo requerido')
        if((form.habitos_sueno.deja_respirar === null || form.habitos_sueno.deja_respirar === '') && form.toxicomanias.fuma === 'positivo') return validationMessage('Marcar si deja de respirar mientras duerme es un campo requerido');
        if(form.habitos_sueno.adormilado === null || form.habitos_sueno.adormilado === '') return validationMessage('Marcar si se ha sentido adormilado frecuentemente es un campo requerido');
        return true
    }

    if(etapa === 13){
        if(form.senas_particulares.tono_piel === null || form.senas_particulares.tono_piel === '') return validationMessage('El tono de la piel es un campo requerido')
        if(form.senas_particulares.color_cabello === null || form.senas_particulares.color_cabello === '') return validationMessage('El color del cabello es un campo requerido');
        if(form.senas_particulares.pelo_tenido === null || form.senas_particulares.pelo_tenido === '') return validationMessage('Marcar si posee el pelo teñido es un campo requerido');
        if(form.senas_particulares.tipo_cabello === null || form.senas_particulares.tipo_cabello === '') return validationMessage('El tipo de cabello es un campo requerido');
        if(form.senas_particulares.longitud_cabello === null || form.senas_particulares.longitud_cabello === '') return validationMessage('La longitud del cabello es un campo requerido');
        if(form.senas_particulares.complexion_fisica === null || form.senas_particulares.complexion_fisica === '') return validationMessage('La complexión física es un campo requerido');
        if(form.senas_particulares.forma_nariz === null || form.senas_particulares.forma_nariz === '') return validationMessage('La forma de la nariz es un campo requerido');
        if(form.senas_particulares.color_ojos === null || form.senas_particulares.color_ojos === '') return validationMessage('El color de los ojos es un campo requerido');
        if(form.senas_particulares.lunar === null || form.senas_particulares.lunar === '') return validationMessage('Marcar si posee lunares es un campo requerido');
        if((form.senas_particulares.lunar_descripcion === null || form.senas_particulares.lunar_descripcion === '') && form.senas_particulares.lunar === 'Con lunares visibles') return validationMessage('La descripción de los lunares es un campo requerido');
        if(form.senas_particulares.tatuaje === null || form.senas_particulares.tatuaje === '') return validationMessage('Marcar si posee tatuajes es un campo requerido');
        if((form.senas_particulares.tatuaje_descripcion === null || form.senas_particulares.tatuaje_descripcion === '') && form.senas_particulares.tatuaje === 'Con tatuajes') return validationMessage('La descripción de los tatuajes es un campo requerido');
        if(form.senas_particulares.cicatriz === null || form.senas_particulares.cicatriz === '') return validationMessage('Marcar si posee cicatrices es un campo requerido');
        if((form.senas_particulares.cicatriz_descripcion === null || form.senas_particulares.cicatriz_descripcion === '') && form.senas_particulares.cicatriz === 'Con cicatrices') return validationMessage('La descricpción de las cicatrices es un campo requerido');
        return true
    }

    if(etapa === 14){
        if(form.discapacidades.discapacidad === null || form.discapacidades.discapacidad === '') return validationMessage('Marcar si posee algunas discapacidad es un campo requerido');
        if(form.discapacidades.protesis === null || form.discapacidades.protesis === '') return validationMessage('Marcar si posee prótesis es un campo requerido');
        if((form.discapacidades.funcion_protesis === null || form.discapacidades.funcion_protesis === '') && form.discapacidades.protesis === 'Si') return validationMessage('La función de la prótesis es un campo requerido');
        if(form.discapacidades.claudica === null || form.discapacidades.claudica === '') return validationMessage('Marcar si claudica al caminar es un campo requerido');
        if(form.discapacidades.discapacidad_visual.length === 0) return validationMessage('Debe marcar si posee alguna disacapacidad visual, sino marque ninguna');
        if(form.discapacidades.lentes_pupilentes === null || form.discapacidades.lentes_pupilentes === '') return validationMessage('Marcar si usa lentes o pupilentes es un campo requerido');
        if(form.discapacidades.falta_pieza_dental === null || form.discapacidades.falta_pieza_dental === '') return validationMessage('Marcar si le falta alguna pieza dental es un campo requerido');
        if(form.discapacidades.empastes === null || form.discapacidades.empastes === '') return validationMessage('Marcar si posee algun empaste es un campo requerido');
        return true
    }
}

const validaPersonasVivienda = (persona) => {
    persona === 'solo' ? form.vivienda.cantidad_personas = 1 : form.vivienda.cantidad_personas = null;
    form.vivienda.personas_vivienda.includes(persona) ? form.vivienda.personas_vivienda = form.vivienda.personas_vivienda.filter(per => per !== persona) : form.vivienda.personas_vivienda.push(persona);
}

const validaDiscapacidadVisual = (discapacidad, otro = false) => {
    otro ? discapacidad_visual_otros.value = null : null;
    form.discapacidades.discapacidad_visual.includes(discapacidad) ? form.discapacidades.discapacidad_visual = form.discapacidades.discapacidad_visual.filter(dis => dis !== discapacidad) : form.discapacidades.discapacidad_visual.push(discapacidad);
}

const validaDiscapacidadVisualOtros = (discapacidad) => {
    form.discapacidades.discapacidad_visual = form.discapacidades.discapacidad_visual.filter(dis => dis !== discapacidad);
    discapacidad_visual_otros.value = null;
}


const options = {
    preserveScroll: true,
    onError: errors => {
        Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: errors.validacion
        })
    },
    onSuccess: page => {
        Swal.fire({
            icon: 'success',
            title: 'Operacion Exitosa',
            text: page.props.flash.message
        })
        localStorage.clear();
    }
}

const submit = async() =>{
    const base64 = await fetch(form.datos_generales.avatar);
    form.avatar = await base64.blob();
    await form.post(`/cuestionarios`, options)
}

const redirigeLogin = () => {
    aceptar_politica.value = 'cancel';
    modal_politica.value.hide();
    router.get('/login');
}

const handleChange = async (uploadFile) => {
    await axios({
        url: uploadFile.url,
        method: "GET",
        responseType: "blob", // importante
        onDownloadProgress: (progressEvent) => {
            var percentCompleted = Math.round((progressEvent.loaded * 100) /  progressEvent.total);
            console.log(percentCompleted)
        },
    }).then((response) => {
        const blob = new Blob([response.data])
        const reader = new FileReader();
        reader.onload = (event) => {
            form.datos_generales.avatar = event.target.result;
        }
        reader.readAsDataURL(blob);
        prevImageHeight.value = 310;
    });
}

const handlePictureCardPreview = (uploadFile) => {
    dialogImageUrl.value = uploadFile.url;
    dialogVisible.value = true;
}

const handleExceed = (files) => {
    upload.value.clearFiles()
    const file = files[0];
    file.uid = genFileId()
    upload.value.handleStart(file)
}

const handleRemove = () => {
    prevImageHeight.value = 210;
}
</script>

<template>
    <body class="sb-nav-fixed">
    <Navbar :screen="fullScreen" />
    <div id="layoutSidenav" class="vh-100">
        <Sidenav />
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><i class="fa fa-clipboard-question"></i> Cuestionario</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active fw-bold"><i class="fa fa-book-medical"></i> Reclutamiento - Exámenes Médicos</li>
                            </ol>
                        </div>
                        <div class="card-body table-responsive">

                            <div class="bs-stepper">
                                <div class="bs-stepper-header table-responsive" role="tablist">
                                    <!-- your steps here -->
                                    <div class="step" data-target="#information-part1">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part1" id="information-part1-trigger">
                                            <span class="bs-stepper-circle">1</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part2">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part2" id="information-part2-trigger">
                                            <span class="bs-stepper-circle">2</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part3">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part3" id="information-part3-trigger">
                                            <span class="bs-stepper-circle">3</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part4">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part4" id="information-part4-trigger">
                                            <span class="bs-stepper-circle">4</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part5">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part5" id="information-part5-trigger">
                                            <span class="bs-stepper-circle">5</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part6">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part6" id="information-part6-trigger">
                                            <span class="bs-stepper-circle">6</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part7">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part7" id="information-part7-trigger">
                                            <span class="bs-stepper-circle">7</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part8">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part8" id="information-part8-trigger">
                                            <span class="bs-stepper-circle">8</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div disabled="false" class="step" data-target="#information-part9">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part9" id="information-part9-trigger">
                                            <span class="bs-stepper-circle">9</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part10">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part10" id="information-part10-trigger">
                                            <span class="bs-stepper-circle">10</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part11">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part11" id="information-part11-trigger">
                                            <span class="bs-stepper-circle">11</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part12">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part12" id="information-part12-trigger">
                                            <span class="bs-stepper-circle">12</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part13">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part13" id="information-part13-trigger">
                                            <span class="bs-stepper-circle">13</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part14">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part14" id="information-part14-trigger">
                                            <span class="bs-stepper-circle">14</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#information-part15">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part15" id="information-part15-trigger">
                                            <span class="bs-stepper-circle">15</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="bs-stepper-content">
                                    <!--Etapa 1-->
                                    <div id="information-part1" class="content" role="tabpanel" aria-labelledby="logins-part1-trigger">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="form-floating col-md-12 my-4">
                                                <p style="text-align: justify !important;">Por favor, dedique unos minutos a completar esta pequeña encuesta, la información que nos proporcione será muy útil para analizar su <span class="fst fw-bold">estado de salud</span>.
                                                Sus respuestas serán tratadas de forma confidencial y no serán utilizadas para ningún propósito distinto a la investigación llevada a cabo por <span class="fst-italic fw-bold">Laboratorio Clínico y Patológico</span>.
                                                Esta encuesta dura aproximadamente <span class="fst-italic fw-bold">5 minutos</span>.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 2-->
                                    <div id="information-part2" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="col-md-12 my-4">
                                            <h5 class="text-center"><span>Signos Vitales <span class="fst-italic">(Pregunte esta información en recepción)</span>.</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class=" col-md-4 mb-4">
                                                <span v-if="form.signos_vitales.peso !== null && form.signos_vitales.peso !== ''">Peso (Kgs)</span>
                                                <el-input v-model="form.signos_vitales.peso" size="large" class="extra-large" type="text" id="floatingInput1" placeholder="Peso (Kgs)"/>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.signos_vitales.estatura !== null && form.signos_vitales.estatura !== ''">Estatura (Mts)</span>
                                                <el-select v-model="form.signos_vitales.estatura" size="large" class="extra-large" type="text" id="floatingInput2" placeholder="Estatura (Mts)">
                                                    <el-option value="Estatura baja">Estatura baja (Femenino: menos de 1.53 m) - (Masculino: de menos de 1.65 m)</el-option>
                                                    <el-option value="Estatura media">Estatura media (Femenino: 1.53 m a 1.63 m) - (Masculino: 1.65 m - 1.75 m)</el-option>
                                                    <el-option value="Estatura alta">Estatura alta (Femenino: más de 1.63 m) - (Masculino: más de 1.75 m)</el-option>
                                                </el-select>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.signos_vitales.p_sistolica !== null && form.signos_vitales.p_sistolica !== ''">Presión Sistólica</span>
                                                <el-input v-model="form.signos_vitales.p_sistolica" size="large" class="extra-large" type="text" id="floatingInput3" placeholder="Presión Sistólica"/>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.signos_vitales.p_diastolica !== null && form.signos_vitales.p_diastolica !== ''">Presión Diastólica</span>
                                                <el-input v-model="form.signos_vitales.p_diastolica" size="large" class="extra-large" type="text" id="floatingInput4" placeholder="Presión Diastólica"/>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.signos_vitales.pulso !== null && form.signos_vitales.pulso !== ''">Pulso</span>
                                                <el-input v-model="form.signos_vitales.pulso" type="text" size="large" class="extra-large" id="floatingInput5" placeholder="Pulso"/>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.signos_vitales.temperatura !== null && form.signos_vitales.temperatura !== ''">Temperatura</span>
                                                <el-input v-model="form.signos_vitales.temperatura" size="large" class="extra-large" type="text" id="floatingInput6" placeholder="Temperatura"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 3-->
                                    <div id="information-part3" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="col-md-12 my-4">
                                            <h5 class="text-center"><span>Medidas <span class="fst-italic">(Pregunte esta información en recepción)</span>.</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-3 mb-4">
                                                <span v-if="form.medidas.cuello !== null && form.medidas.cuello !== ''">Cuello (Cm)</span>
                                                <el-input v-model="form.medidas.cuello" size="large" class="extra-large" type="text" id="floatingInput7" placeholder="Cuello (Cm)"/>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <span v-if="form.medidas.pecho !== null && form.medidas.pecho !== ''">Pecho (Cm)</span>
                                                <el-input v-model="form.medidas.pecho" size="large" class="extra-large" type="text" id="floatingInput8" placeholder="Pecho (Cm)"/>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <span v-if="form.medidas.cintura !== null && form.medidas.cintura !== ''">Cintura (Cm)</span>
                                                <el-input v-model="form.medidas.cintura" size="large" class="extra-large" type="text" id="floatingInput9" placeholder="Cintura (Cm)"/>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <span v-if="form.medidas.caderas !== null && form.medidas.caderas !== ''">Cadera (Cm)</span>
                                                <el-input v-model="form.medidas.caderas" size="large" class="extra-large" type="text" id="floatingInput10" placeholder="Cadera (Cm)"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 4-->
                                    <div id="information-part4" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="col-md-12 my-4">
                                            <h5 class="text-center"><span>Datos generales.</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div  class="form-floating b-4" :class="form.datos_generales.avatar === null ? 'col-md-12' : 'col-md-8'">
                                                <el-upload
                                                    id="avatar"
                                                    ref="upload"
                                                    class="upload-demo"
                                                    drag
                                                    :limit="1"
                                                    :auto-upload="false"
                                                    list-type="picture"
                                                    :on-change="handleChange"
                                                    :on-preview="handlePictureCardPreview"
                                                    :on-exceed="handleExceed"
                                                    :on-remove="handleRemove"
                                                >
                                                    <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                                                    <div class="el-upload__text">
                                                        Arrastre una imágen de perfil aquí <em>o haga click para subir</em>
                                                    </div>
                                                    <template #tip>
                                                        <div class="el-upload__tip">
                                                            jpg/png ficheros con un tamaño máximo de 5 Mb
                                                        </div>
                                                    </template>
                                                </el-upload>
                                                <el-dialog v-model="dialogVisible">
                                                    <p class="text-center fw-bold"> Vista Previa</p><img class="w-100" :src="dialogImageUrl" alt="Preview Image" />
                                                </el-dialog>
                                            </div>
                                            <div v-if="form.datos_generales.avatar !== null" class="col-md-4 mb-4">
                                                <img class="w-100 rounded mt-3 border border-2 border-primary" :style="`height: ${prevImageHeight}px`" :src="form.datos_generales.avatar" alt="">
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <span v-if="form.datos_generales.empresa !== null && form.datos_generales.empresa !== ''">Seleccionar Empresa</span>
                                                <el-select v-model="form.datos_generales.empresa" size="large" placeholder="Seleccionar Empresa" class="w-100 extra-large" id="floatingSelect1">
                                                    <el-option v-for="empresa in empresas" :value="empresa.nombre">{{empresa.nombre}}</el-option>
                                                </el-select>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <span v-if="form.datos_generales.nombre !== null && form.datos_generales.nombre !== ''">Nombre Completo</span>
                                                <el-input v-model="form.datos_generales.nombre" size="large" class="extra-large" type="text" id="floatingInput11" placeholder="Nombre Completo"/>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <span v-if="form.datos_generales.nacimiento !== null && form.datos_generales.nacimiento !== ''">Fecha de Nacimiento</span>
                                                <el-date-picker v-model="form.datos_generales.nacimiento" format="DD/MM/YYYY" value-format="DD/MM/YYYY" size="large" class="extra-large" type="date" id="floatingInput12" placeholder="Fecha de Nacimiento"/>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <span v-if="form.datos_generales.edad !== null && form.datos_generales.edad !== ''">Edad</span>
                                                <el-input-number v-model="form.datos_generales.edad" :min="18" :max="80" size="large" class="extra-large" type="number" id="floatingInput13" placeholder="Edad"/>
                                            </div>
                                            <div class="col-md-2 mb-4">
                                                <label class="mx-2"><i class="bi bi-gender-ambiguous"></i> Sexo</label>
                                                <div class="form-check">
                                                    <input v-model="form.datos_generales.sexo" value="Masculino" class="form-check-input" type="radio" name="sexo" id="flexRadioDefault1"/>
                                                    <label :class="form.datos_generales.sexo === 'Masculino' ? 'text-primary': ''" class="form-check-label" for="flexRadioDefault1"> Masculino</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.datos_generales.sexo" value="Femenino" class="form-check-input" type="radio" name="sexo" id="flexRadioDefault2"/>
                                                    <label :class="form.datos_generales.sexo === 'Femenino' ? 'text-primary': ''" class="form-check-label" for="flexRadioDefault2"> Femenino</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label class="mx-2"><i class="fa fa-city"></i> Ciudad de Orígen</label>
                                                <div class="form-check">
                                                    <input v-model="form.datos_generales.ciudad_origen" value="H. Matamoros, Tamaulipas" class="form-check-input" type="radio" name="ciudad" id="flexRadioDefault3"/>
                                                    <label class="form-check-label" for="flexRadioDefault3"> H. Matamoros, Tamaulipas</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ciudad" id="flexRadioDefault4" :checked="form.datos_generales.ciudad_origen !== 'H. Matamoros, Tamaulipas' && form.datos_generales.ciudad_origen !== null"/>
                                                    <label class="form-check-label" for="flexRadioDefault4"> Otra: <el-input v-model="form.datos_generales.ciudad_origen" size="large" id="ciudad_otros" type="text" /></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 5-->
                                    <div id="information-part5" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class=" col-md-12 my-4">
                                            <h5 class="text-center"><span>Información de Contacto.</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-6 mb-4">
                                                <span v-if="form.info_contacto.telefono !== null && form.info_contacto.telefono !== ''">Teléfono</span>
                                                <el-input v-model="form.info_contacto.telefono" type="number" size="large" class="extra-large" id="floatingInput14" placeholder="Teléfono"/>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <span v-if="form.info_contacto.correo !== null && form.info_contacto.correo !== ''">Correo Electrónico</span>
                                                <el-input v-model="form.info_contacto.correo" type="email" size="large" class="extra-large" id="floatingInput15" placeholder="Correo Electrónico"/>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.info_contacto.direccion !== null && form.info_contacto.direccion !== ''">Dirección</span>
                                                <el-input v-model="form.info_contacto.direccion" type="text" size="large" class="extra-large" id="floatingInput16" placeholder="Dirección"/>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.info_contacto.desde_cuando !== null && form.info_contacto.desde_cuando !== ''">¿Desde Cuándo?</span>
                                                <el-date-picker v-model="form.info_contacto.desde_cuando" format="DD/MM/YYYY" value-format="DD/MM/YYYY" size="large" class="extra-large" id="floatingInput16.1" placeholder="¿Desde Cuándo?"/>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.info_contacto.lugar_crianza !== null && form.info_contacto.lugar_crianza !== ''">Lugar de Crianza</span>
                                                <el-input v-model="form.info_contacto.lugar_crianza" type="text" size="large" class="extra-large" id="floatingInput16.2" placeholder="Lugar de Crianza"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 6-->
                                    <div id="information-part6" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="col-md-12 my-4">
                                            <h5 class="text-center"><span>Estado Civil.</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-4 mb-4">
                                                <label class="mx-2"><i class="bi bi-person-gear"></i> Estado Civil</label>
                                                <div class="form-check">
                                                    <input v-model="form.estado_civil.estado" class="form-check-input" type="radio" name="estado_civil" value="Soltero" id="flexRadioDefault5"/>
                                                    <label class="form-check-label" for="flexRadioDefault5"> Soltero</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.estado_civil.estado" class="form-check-input" type="radio" name="estado_civil" value="Casado" id="flexRadioDefault6"/>
                                                    <label class="form-check-label" for="flexRadioDefault6"> Casado</label>
                                                </div>
                                                <div class="form-check">
                                                    <input :checked="form.estado_civil.estado !== null && form.estado_civil.estado !== '' && form.estado_civil.estado !== 'Soltero' && form.estado_civil.estado !== 'Casado'" class="form-check-input" type="radio" name="estado_civil" id="flexRadioDefault7"/>
                                                    <label class="form-check-label" for="flexRadioDefault7"> Otro: <el-input v-model="form.estado_civil.estado" type="text" size="large" id="estado_civil_otros"/></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <span v-if="form.estado_civil.desde_cuando !== null && form.estado_civil.desde_cuando !== ''">¿Desde Cuándo?</span>
                                                <el-date-picker v-model="form.estado_civil.desde_cuando" type="date" format="DD/MM/YYYY" value-format="DD/MM/YYYY" size="large" class="extra-large" id="floatingInput18" placeholder="¿Desde Cuándo?"/>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label class="mx-2"><i class="bi bi-person-gear"></i> Tiene usted hijos</label>
                                                <div class="form-check">
                                                    <input v-model="form.estado_civil.hijos" value="Con hijos" class="form-check-input" type="radio" name="hijos" id="flexRadioDefault8"/>
                                                    <label class="form-check-label" for="flexRadioDefault8"> Con hijos</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="form.estado_civil.edades_hijos = null" v-model="form.estado_civil.hijos" value="Sin hijos" class="form-check-input" type="radio" name="hijos" id="flexRadioDefault9"/>
                                                    <label class="form-check-label" for="flexRadioDefault9"> Sin hijos</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <span v-if="form.estado_civil.edades_hijos !== null && form.estado_civil.edades_hijos !== ''">En caso de tener hijos (Mencione sus edades, separadas por una coma si es más de uno, ejemplo: 20, 25, 28)</span>
                                                <el-input v-model="form.estado_civil.edades_hijos" :disabled="form.estado_civil.hijos === 'Sin hijos'" type="text" size="large" class="extra-large" id="floatingInput19" placeholder="En caso de tener hijos (Mencione sus edades, separadas por una coma si es más de uno, ejemplo: 20, 25, 28)" :class="form.estado_civil.hijos === 'Sin hijos' ? 'text-decoration-line-through': ''" />
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 7-->
                                    <div id="information-part7" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="form-floating col-md-12 my-4">
                                            <h5 class="text-center"><span>Escolaridad.</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-6 mb-4">
                                                <label class="mx-2"><i class="fa fa-school-circle-exclamation"></i> Último grado de estudios</label>
                                                <div class="form-check">
                                                    <input v-model="form.escolaridad.grado_estudios" value="Primaria" class="form-check-input" type="radio" name="grado_estudios" id="flexRadioDefault10"/>
                                                    <label class="form-check-label" for="flexRadioDefault10"> Primaria</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.escolaridad.grado_estudios" value="Secundaria" class="form-check-input" type="radio" name="grado_estudios" id="flexRadioDefault11"/>
                                                    <label class="form-check-label" for="flexRadioDefault11"> Secundaria</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.escolaridad.grado_estudios" value="Preparatoria" class="form-check-input" type="radio" name="grado_estudios" id="flexRadioDefault12"/>
                                                    <label class="form-check-label" for="flexRadioDefault12"> Preparatoria</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.escolaridad.grado_estudios" value="Carrera Técnica" class="form-check-input" type="radio" name="grado_estudios" id="flexRadioDefault13"/>
                                                    <label class="form-check-label" for="flexRadioDefault13"> Carrera Técnica</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.escolaridad.grado_estudios" value="Universidad" class="form-check-input" type="radio" name="grado_estudios" id="flexRadioDefault14"/>
                                                    <label class="form-check-label" for="flexRadioDefault14"> Universidad</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <span v-if="form.escolaridad.carrera !== null && form.escolaridad.carrera !== ''">Carrera Cursada</span>
                                                <el-input :disabled="form.escolaridad.grado_estudios !== 'Universidad' && form.escolaridad.grado_estudios !== 'Carrera Técnica'" v-model="form.escolaridad.carrera" type="text" size="large" class="extra-large" id="floatingInput200" placeholder="Carrera Cursada"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 8-->
                                    <div id="information-part8" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="form-floating col-md-12 my-4">
                                            <h5 class="text-center"><span>Oficio / Profesión</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-4 mb-4 border border-2 rounded">
                                                <label class="form-check-label fst-italic" for="oficio_profesion"> Lea cuidadosamente la siguiente información</label>
                                                <img class="w-100" src="/img/oficio_profesion.png" id="oficio_profesion" alt="">
                                            </div>
                                            <div class="col-md-8 mb-4 row align-items-center justify-content-center">
                                                <span class="fst-italic">Con base en la información que viene en la imagen. Por favor conteste las siguientes preguntas.</span>
                                                <div class="col-md-6 mb-4">
                                                    <label class="mx-2"><i class="bi bi-hammer"></i> Que OFICIO tiene y desde hace cuanto tiempo (Ya sea que lo desempeñe o no)</label>
                                                    <div class="form-check">
                                                        <input v-model="form.oficio_profesion.oficio" value="Sin oficio" class="form-check-input" type="radio" name="oficio" id="flexRadioDefault15"/>
                                                        <label class="form-check-label" for="flexRadioDefault15"> Sin oficio</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="oficio" id="flexRadioDefault16" :checked="form.oficio_profesion.oficio !== 'Sin oficio' && form.oficio_profesion.oficio !== null"/>
                                                        <label class="form-check-label" for="flexRadioDefault16"> Otro: <el-input v-model="form.oficio_profesion.oficio" type="text" size="large" id="oficio_otros"/></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="mx-2"><i class="bi bi-person-workspace"></i> Que PROFESIÓN tiene y desde hace cuanto tiempo (Ya sea que lo desempeñe o no)</label>
                                                    <div class="form-check">
                                                        <input v-model="form.oficio_profesion.profesion" value="Sin profesión" class="form-check-input" type="radio" name="profesion" id="flexRadioDefault17"/>
                                                        <label class="form-check-label" for="flexRadioDefault17"> Sin profesión</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="profesion" id="flexRadioDefault18" :checked="form.oficio_profesion.profesion !== 'Sin profesión' && form.oficio_profesion.profesion !== null"/>
                                                        <label class="form-check-label" for="flexRadioDefault18"> Otro: <el-input v-model="form.oficio_profesion.profesion" type="text" size="large" id="profesion_otros"/></label>
                                                    </div>
                                                </div>
                                                <div class="form-floating col-md-6 mb-4">
                                                    <span v-if="form.oficio_profesion.ultimo_trabajo !== null && form.oficio_profesion.ultimo_trabajo !== ''">Último lugar donde trabajó</span>
                                                    <el-input v-model="form.oficio_profesion.ultimo_trabajo" type="text" size="large" class="extra-large" id="floatingInput20" placeholder="Último lugar donde trabajó"/>
                                                </div>
                                                <div class="form-floating col-md-6 mb-4">
                                                    <span v-if="form.oficio_profesion.hasta_cuando !== null && form.oficio_profesion.hasta_cuando !== ''">¿Hasta cuándo trabajo ahí?</span>
                                                    <el-date-picker v-model="form.oficio_profesion.hasta_cuando" format="DD/MM/YYYY" value-format="DD/MM/YYYY" type="date" size="large" class="extra-large" id="floatingInput21" placeholder="¿Hasta cuándo trabajo ahí?"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 9-->
                                    <div id="information-part9" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="form-floating col-md-12 my-4">
                                            <h5 class="text-center"><span>TOXICOMANÍAS</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-2 mb-4">
                                                <label class="mx-2"><i class="fa fa-smoking"></i> ¿Usted fuma?</label>
                                                <div class="form-check">
                                                    <input v-model="form.toxicomanias.fuma" value="positivo" :checked="form.toxicomanias.cuantos_cigarillos !== null" class="form-check-input" type="radio" name="fuma" id="flexRadioDefault19"/>
                                                    <label class="form-check-label" for="flexRadioDefault19"> POSITIVO</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="form.toxicomanias.cuantos_cigarillos = null" v-model="form.toxicomanias.fuma" value="negativo" class="form-check-input" type="radio" name="fuma" id="flexRadioDefault20"/>
                                                    <label class="form-check-label" for="flexRadioDefault20"> NEGATIVO</label>
                                                </div>
                                            </div>
                                            <div class="form-floating col-md-4 mb-4">
                                                <span v-if="form.toxicomanias.cuantos_cigarillos !== null && form.toxicomanias.cuantos_cigarillos !== ''">¿Cuántos cigarrillos consume a la semana?</span>
                                                <el-input v-model="form.toxicomanias.cuantos_cigarillos" min="1" :disabled="form.toxicomanias.fuma === 'negativo'" type="text" size="large" :class="form.toxicomanias.fuma === 'negativo' ? 'text-decoration-line-through': ''" class="extra-large" id="floatingInput22" placeholder="¿Cuántos cigarrillos consume a la semana?"/>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="mx-2"><i class="fa fa-wine-bottle"></i> ¿Bebidas alcohólicas?</label>
                                                <div class="form-check">
                                                    <input v-model="form.toxicomanias.bebe" value="positivo" class="form-check-input" type="radio" name="bebidas" id="flexRadioDefault21"/>
                                                    <label class="form-check-label" for="flexRadioDefault21"> POSITIVO</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.toxicomanias.bebe" value="negativo" class="form-check-input" type="radio" name="bebidas" id="flexRadioDefault22"/>
                                                    <label class="form-check-label" for="flexRadioDefault22"> NEGATIVO</label>
                                                </div>
                                            </div>
                                            <div class="form-floating col-md-4 mb-4">
                                                <span v-if="form.toxicomanias.cuantos_cigarillos !== null && form.toxicomanias.cuantos_cigarillos !== ''">¿Cuánta bebida consume a la semana?</span>
                                                <el-input v-model="form.toxicomanias.cuantos_cigarillos" min="1" :disabled="form.toxicomanias.fuma === 'negativo'" type="text" size="large" :class="form.toxicomanias.fuma === 'negativo' ? 'text-decoration-line-through': ''" class="extra-large" id="floatingInput22" placeholder="¿Cuánta bebida consume a la semana?"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 10-->
                                    <div id="information-part10" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="form-floating col-md-12 my-4">
                                            <h5 class="text-center"><span>Vivienda.</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-2 mb-4">
                                                <label class="mx-2"><i class="fa fa-users"></i> ¿Con qué personas vive?</label>
                                                <div class="form-check">
                                                    <input @click="validaPersonasVivienda($event.target.value)" :checked="form.vivienda.personas_vivienda.includes('solo')" :disabled="form.vivienda.personas_vivienda.includes('cónyuge') || form.vivienda.personas_vivienda.includes('hijos') || form.vivienda.personas_vivienda.includes('padres') || form.vivienda.personas_vivienda.includes('suegros')" value="solo" class="form-check-input" type="checkbox" name="con_quien_vive" id="flexCheckDefault1"/>
                                                    <label :class="form.vivienda.personas_vivienda.includes('cónyuge') || form.vivienda.personas_vivienda.includes('hijos') || form.vivienda.personas_vivienda.includes('padres') || form.vivienda.personas_vivienda.includes('suegros') ? 'text-decoration-line-through': ''" class="form-check-label" for="flexCheckDefault1"> Solo</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="validaPersonasVivienda($event.target.value)" :checked="form.vivienda.personas_vivienda.includes('cónyuge')" :disabled="form.vivienda.personas_vivienda.includes('solo')" value="cónyuge" class="form-check-input" type="checkbox" name="con_quien_vive" id="flexCheckDefault2"/>
                                                    <label :class="form.vivienda.personas_vivienda.includes('solo') ? 'text-decoration-line-through': ''" class="form-check-label" for="flexCheckDefault2"> Cónyuge</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="validaPersonasVivienda($event.target.value)" :checked="form.vivienda.personas_vivienda.includes('hijos')" :disabled="form.vivienda.personas_vivienda.includes('solo')" value="hijos" class="form-check-input" type="checkbox" name="con_quien_vive" id="flexCheckDefault3"/>
                                                    <label :class="form.vivienda.personas_vivienda.includes('solo') ? 'text-decoration-line-through': ''" class="form-check-label" for="flexCheckDefault3"> Hijos</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="validaPersonasVivienda($event.target.value)" :checked="form.vivienda.personas_vivienda.includes('padres')" :disabled="form.vivienda.personas_vivienda.includes('solo')" value="padres" class="form-check-input" type="checkbox" name="con_quien_vive" id="flexCheckDefault4"/>
                                                    <label :class="form.vivienda.personas_vivienda.includes('solo') ? 'text-decoration-line-through': ''" class="form-check-label" for="flexCheckDefault4"> Padres</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="validaPersonasVivienda($event.target.value)" :checked="form.vivienda.personas_vivienda.includes('suegros')" :disabled="form.vivienda.personas_vivienda.includes('solo')" value="suegros" class="form-check-input" type="checkbox" name="con_quien_vive" id="flexCheckDefault5"/>
                                                    <label :class="form.vivienda.personas_vivienda.includes('solo') ? 'text-decoration-line-through': ''" class="form-check-label" for="flexCheckDefault5"> Suegros</label>
                                                </div>
                                            </div>
                                            <div class="form-floating col-md-4 mb-4">
                                                <span v-if="form.vivienda.cantidad_personas !== null && form.vivienda.cantidad_personas !== ''">¿Cuántas personas viven en su casa?</span>
                                                <el-input-number min="1" v-model="form.vivienda.cantidad_personas" :disabled="form.vivienda.personas_vivienda.length === 0" :readonly="form.vivienda.personas_vivienda.includes('solo')" size="large" class="extra-large" id="floatingInput23" placeholder="¿Cuántas personas viven en su casa?"/>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label class="mx-2"><i class="fa fa-house"></i> Mencione el estado actual de casa</label>
                                                <div class="form-check">
                                                    <input v-model="form.vivienda.estado_vivienda" value="Casa pagada" class="form-check-input" type="radio" name="estado_casa" id="flexRadioDefault23"/>
                                                    <label class="form-check-label" for="flexRadioDefault23"> Casa pagada</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.vivienda.estado_vivienda" value="En proceso de adquisición" class="form-check-input" type="radio" name="estado_casa" id="flexRadioDefault24"/>
                                                    <label class="form-check-label" for="flexRadioDefault24"> En proceso de adquisición</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.vivienda.estado_vivienda" value="Renta" class="form-check-input" type="radio" name="estado_casa" id="flexRadioDefault25"/>
                                                    <label class="form-check-label" for="flexRadioDefault25"> Renta</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.vivienda.estado_vivienda" value="Casa prestada" class="form-check-input" type="radio" name="estado_casa" id="flexRadioDefault26"/>
                                                    <label class="form-check-label" for="flexRadioDefault26"> Casa prestada</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label class="mx-2"><i class="fa fa-house-circle-exclamation"></i> ¿De quién es  propiedad el domicilio en donde vive?</label>
                                                <div class="form-check">
                                                    <input v-model="form.vivienda.propietario_vivienda" value="Propia" class="form-check-input" type="radio" name="propietario_domicilio" id="flexRadioDefault27" />
                                                    <label class="form-check-label" for="flexRadioDefault27"> Propia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.vivienda.propietario_vivienda" value="Padres" class="form-check-input" type="radio" name="propietario_domicilio" id="flexRadioDefault28"/>
                                                    <label class="form-check-label" for="flexRadioDefault28"> Padres</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.vivienda.propietario_vivienda" value="Cónyuge" class="form-check-input" type="radio" name="propietario_domicilio" id="flexRadioDefault29"/>
                                                    <label class="form-check-label" for="flexRadioDefault29"> Cónyuge</label>
                                                </div>
                                                <div class="form-check">
                                                    <input :checked="form.vivienda.propietario_vivienda !== null && form.vivienda.propietario_vivienda !== 'Propia' && form.vivienda.propietario_vivienda !== 'Padres' && form.vivienda.propietario_vivienda !== 'Cónyuge'"  class="form-check-input" type="radio" name="propietario_domicilio" id="flexRadioDefault30"/>
                                                    <label class="form-check-label" for="flexRadioDefault30"> Otro: <el-input v-model="form.vivienda.propietario_vivienda" type="text" size="large" id="propietario_vivienda"/></label>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center align-items-center col-md-8">
                                                <div class="col-md-12">
                                                    <label><i class="bi bi-123"></i> Indique el número de lo siguiente</label>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label class="mx-2"><i class="fa fa-house-circle-exclamation"></i> Recamaras (Donde usted duerme)</label>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.recamaras" value="1" class="form-check-input" type="radio" name="recamaras" id="flexRadioDefault31"/>
                                                        <label class="form-check-label" for="flexRadioDefault31"> 1</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.recamaras" value="2" class="form-check-input" type="radio" name="recamaras" id="flexRadioDefault32"/>
                                                        <label class="form-check-label" for="flexRadioDefault32"> 2</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.recamaras" value="3" class="form-check-input" type="radio" name="recamaras" id="flexRadioDefault33"/>
                                                        <label class="form-check-label" for="flexRadioDefault33"> 3</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.recamaras" value="4" class="form-check-input" type="radio" name="recamaras" id="flexRadioDefault34"/>
                                                        <label class="form-check-label" for="flexRadioDefault34"> 4</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.recamaras" value="5" class="form-check-input" type="radio" name="recamaras" id="flexRadioDefault35"/>
                                                        <label class="form-check-label" for="flexRadioDefault35"> 5</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.recamaras" value="6" class="form-check-input" type="radio" name="recamaras" id="flexRadioDefault36"/>
                                                        <label class="form-check-label" for="flexRadioDefault36"> 6</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.recamaras" value="7" class="form-check-input" type="radio" name="recamaras" id="flexRadioDefault37"/>
                                                        <label class="form-check-label" for="flexRadioDefault37"> 7</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label class="mx-2"><i class="fa fa-house-flood-water-circle-arrow-right"></i> Baños (Lugar de aseo personal)</label>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.banos" value="1" class="form-check-input" type="radio" name="baños" id="flexRadioDefault38"/>
                                                        <label class="form-check-label" for="flexRadioDefault38"> 1</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.banos" value="2" class="form-check-input" type="radio" name="baños" id="flexRadioDefault39"/>
                                                        <label class="form-check-label" for="flexRadioDefault39"> 2</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.banos" value="3" class="form-check-input" type="radio" name="baños" id="flexRadioDefault40"/>
                                                        <label class="form-check-label" for="flexRadioDefault40"> 3</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.banos" value="4" class="form-check-input" type="radio" name="baños" id="flexRadioDefault41"/>
                                                        <label class="form-check-label" for="flexRadioDefault41"> 4</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.banos" value="5" class="form-check-input" type="radio" name="baños" id="flexRadioDefault42"/>
                                                        <label class="form-check-label" for="flexRadioDefault42"> 5</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.banos" value="6" class="form-check-input" type="radio" name="baños" id="flexRadioDefault43"/>
                                                        <label class="form-check-label" for="flexRadioDefault43"> 6</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.banos" value="7" class="form-check-input" type="radio" name="baños" id="flexRadioDefault44"/>
                                                        <label class="form-check-label" for="flexRadioDefault44"> 7</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label class="mx-2"><i class="fa fa-restroom"></i> Cuartos (Otras habitaciones de cuatro paredes)</label>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.cuartos" value="1" class="form-check-input" type="radio" name="cuartos" id="flexRadioDefault45"/>
                                                        <label class="form-check-label" for="flexRadioDefault45"> 1</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.cuartos" value="2" class="form-check-input" type="radio" name="cuartos" id="flexRadioDefault46"/>
                                                        <label class="form-check-label" for="flexRadioDefault46"> 2</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.cuartos" value="3" class="form-check-input" type="radio" name="cuartos" id="flexRadioDefault47"/>
                                                        <label class="form-check-label" for="flexRadioDefault47"> 3</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.cuartos" value="4" class="form-check-input" type="radio" name="cuartos" id="flexRadioDefault48"/>
                                                        <label class="form-check-label" for="flexRadioDefault48"> 4</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.cuartos" value="5" class="form-check-input" type="radio" name="cuartos" id="flexRadioDefault49"/>
                                                        <label class="form-check-label" for="flexRadioDefault49"> 5</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.cuartos" value="6" class="form-check-input" type="radio" name="cuartos" id="flexRadioDefault50"/>
                                                        <label class="form-check-label" for="flexRadioDefault50"> 6</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.cuartos" value="7" class="form-check-input" type="radio" name="cuartos" id="flexRadioDefault51"/>
                                                        <label class="form-check-label" for="flexRadioDefault51"> 7</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label class="mx-2"><i class="bi bi-bricks"></i> De qué está construida su vivienda</label>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.material_vivienda" value="Concreto" class="form-check-input" type="radio" name="material_vivienda" id="flexRadioDefault52"/>
                                                        <label class="form-check-label" for="flexRadioDefault52"> Concreto</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input v-model="form.vivienda.material_vivienda" value="Madera" class="form-check-input" type="radio" name="material_vivienda" id="flexRadioDefault53"/>
                                                        <label class="form-check-label" for="flexRadioDefault53"> Madera</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" :checked="form.vivienda.material_vivienda !== null && form.vivienda.material_vivienda !== 'Concreto' && form.vivienda.material_vivienda !== 'Madera'" type="radio" name="material_vivienda" id="flexRadioDefault54"/>
                                                        <label class="form-check-label" for="flexRadioDefault54"> Otro: <el-input v-model="form.vivienda.material_vivienda" type="text" size="large" id="material_vivienda"/></label>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 11-->
                                    <div id="information-part11" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="form-floating col-md-12 my-4">
                                            <h5 class="text-center"><span>Estado de salud</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-4 mb-4">
                                                <label class="mx-2"><i class="fa fa-briefcase-medical"></i> ¿Ya recibió su inyección anual contra la influenza?</label>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.vacuna_influenza" value="Si" class="form-check-input" type="radio" name="influenza" id="flexRadioDefault55"/>
                                                    <label class="form-check-label" for="flexRadioDefault55"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.vacuna_influenza" value="No" class="form-check-input" type="radio" name="influenza" id="flexRadioDefault56"/>
                                                    <label class="form-check-label" for="flexRadioDefault56"> No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="fa fa-mask-face"></i> Vacunas contra la COVID 19</label>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.vacuna_covid" value="Ninguna" class="form-check-input" type="radio" name="covid" id="flexRadioDefault57"/>
                                                    <label class="form-check-label" for="flexRadioDefault57"> Ninguna</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.vacuna_covid" value="1ra Dosis" class="form-check-input" type="radio" name="covid" id="flexRadioDefault58"/>
                                                    <label class="form-check-label" for="flexRadioDefault58"> 1ra Dosis</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.vacuna_covid" value="2da Dosis" class="form-check-input" type="radio" name="covid" id="flexRadioDefault59"/>
                                                    <label class="form-check-label" for="flexRadioDefault59"> 2da Dosis</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.vacuna_covid" value="3ra Dosis" class="form-check-input" type="radio" name="covid" id="flexRadioDefault60"/>
                                                    <label class="form-check-label" for="flexRadioDefault60"> 3ra Dosis</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="bi bi-universal-access"></i> Hábitos de ejercicio durante semana</label>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.ejercicio_semana" value="No hago ejercicio" class="form-check-input" type="radio" name="ejercicios" id="flexRadioDefault61"/>
                                                    <label class="form-check-label" for="flexRadioDefault61"> No hago ejercicio</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.ejercicio_semana" value="1-2 días" class="form-check-input" type="radio" name="ejercicios" id="flexRadioDefault62"/>
                                                    <label class="form-check-label" for="flexRadioDefault62"> 1-2 días</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.ejercicio_semana" value="3-4 días"  class="form-check-input" type="radio" name="ejercicios" id="flexRadioDefault63"/>
                                                    <label class="form-check-label" for="flexRadioDefault63"> 3-4 días</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.estado_salud.ejercicio_semana" value="5 ó más días" class="form-check-input" type="radio" name="ejercicios" id="flexRadioDefault64"/>
                                                    <label class="form-check-label" for="flexRadioDefault64"> 5 ó más días</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 12-->
                                    <div id="information-part12" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="form-floating col-md-12 my-4">
                                            <h5 class="text-center"><span>Hábitos de sueño</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-4 mb-4">
                                                <label class="mx-2"><i class="bi bi-person-lines-fill"></i> ¿Le han mencionado si ronca?</label>
                                                <div class="form-check">
                                                    <input v-model="form.habitos_sueno.ronca" value="Si" class="form-check-input" type="radio" name="ronca" id="flexRadioDefault65"/>
                                                    <label class="form-check-label" for="flexRadioDefault65"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.habitos_sueno.ronca" value="No" class="form-check-input" type="radio" name="ronca" id="flexRadioDefault66"/>
                                                    <label class="form-check-label" for="flexRadioDefault66"> No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="bi bi-person-slash"></i> ¿Le han mencionado si deja de respirar mientras duerme?</label>
                                                <div class="form-check">
                                                    <input v-model="form.habitos_sueno.deja_respirar" value="Si" class="form-check-input" type="radio" name="respira" id="flexRadioDefault67"/>
                                                    <label class="form-check-label" for="flexRadioDefault67"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.habitos_sueno.deja_respirar" value="No" class="form-check-input" type="radio" name="respira" id="flexRadioDefault68"/>
                                                    <label class="form-check-label" for="flexRadioDefault68"> No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="fa fa-bed"></i> ¿Se siente cansado o adormilado frecuentemente?</label>
                                                <div class="form-check">
                                                    <input v-model="form.habitos_sueno.adormilado" value="Si" class="form-check-input" type="radio" name="bebidas" id="flexRadioDefault69"/>
                                                    <label class="form-check-label" for="flexRadioDefault69"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.habitos_sueno.adormilado" value="No" class="form-check-input" type="radio" name="bebidas" id="flexRadioDefault70"/>
                                                    <label class="form-check-label" for="flexRadioDefault70"> No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 13-->
                                    <div id="information-part13" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="form-floating col-md-12 my-4">
                                            <h5 class="text-center"><span>Señas particulares</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-4 mb-4">
                                                <label class="mx-2"><i class="bi bi-person-fill"></i> Tono de piel</label>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.tono_piel" value="Morena" class="form-check-input" type="radio" name="piel" id="flexRadioDefault71"/>
                                                    <label class="form-check-label" for="flexRadioDefault71"> Morena</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.tono_piel" value="Aperlada" class="form-check-input" type="radio" name="piel" id="flexRadioDefault72"/>
                                                    <label class="form-check-label" for="flexRadioDefault72"> Aperlada</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.tono_piel" value="Clara" class="form-check-input" type="radio" name="piel" id="flexRadioDefault73"/>
                                                    <label class="form-check-label" for="flexRadioDefault73"> Clara</label>
                                                </div>
                                                <div class="form-check">
                                                    <input :checked="form.senas_particulares.tono_piel != null && form.senas_particulares.tono_piel !== '' && form.senas_particulares.tono_piel !== 'Morena' && form.senas_particulares.tono_piel !== 'Aperlada' && form.senas_particulares.tono_piel !== 'Clara'" class="form-check-input" type="radio" name="piel" id="flexRadioDefault74"/>
                                                    <label class="form-check-label" for="flexRadioDefault74"> Otro: <el-input v-model="form.senas_particulares.tono_piel" type="text" size="large" id="piel_otras"/></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="bi bi-person-fill-up"></i> Color de cabello</label>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.color_cabello" value="Negro" class="form-check-input" type="radio" name="color_cabello" id="flexRadioDefault75"/>
                                                    <label class="form-check-label" for="flexRadioDefault75"> Negro</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.color_cabello" value="Café" class="form-check-input" type="radio" name="color_cabello" id="flexRadioDefault76"/>
                                                    <label class="form-check-label" for="flexRadioDefault76"> Café</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.color_cabello" value="Rubio" class="form-check-input" type="radio" name="color_cabello" id="flexRadioDefault77"/>
                                                    <label class="form-check-label" for="flexRadioDefault77"> Rubio</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.color_cabello" value="Pelirrojo" class="form-check-input" type="radio" name="color_cabello" id="flexRadioDefault78"/>
                                                    <label class="form-check-label" for="flexRadioDefault78"> Pelirrojo</label>
                                                </div>
                                                <div class="form-check">
                                                    <input :checked="form.senas_particulares.color_cabello != null && form.senas_particulares.color_cabello !== '' && form.senas_particulares.color_cabello !== 'Negro' && form.senas_particulares.color_cabello !== 'Café' && form.senas_particulares.color_cabello !== 'Rubio' && form.senas_particulares.color_cabello !== 'Pelirrojo'" class="form-check-input" type="radio" name="color_cabello" id="flexRadioDefault79"/>
                                                    <label class="form-check-label" for="flexRadioDefault79"> Otro: <el-input v-model="form.senas_particulares.color_cabello" type="text" size="large" id="color_cabello_otros"/></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="fa fa-question"></i> ¿Su pelo está teñido?</label>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.pelo_tenido" value="Pelo teñido" class="form-check-input" type="radio" name="pelo_tenido" id="flexRadioDefault80"/>
                                                    <label class="form-check-label" for="flexRadioDefault80"> Pelo teñido</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.pelo_tenido" value="Sin teñir" class="form-check-input" type="radio" name="pelo_tenido" id="flexRadioDefault81"/>
                                                    <label class="form-check-label" for="flexRadioDefault81"> Sin teñir</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="bi bi-subtract"></i> Tipo de cabello</label>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.tipo_cabello" value="Ondulado" class="form-check-input" type="radio" name="tipo_cabello" id="flexRadioDefault82"/>
                                                    <label class="form-check-label" for="flexRadioDefault82"> Ondulado</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.tipo_cabello" value="Rizado" class="form-check-input" type="radio" name="tipo_cabello" id="flexRadioDefault83"/>
                                                    <label class="form-check-label" for="flexRadioDefault83"> Rizado</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.tipo_cabello" value="Lacio" class="form-check-input" type="radio" name="tipo_cabello" id="flexRadioDefault84"/>
                                                    <label class="form-check-label" for="flexRadioDefault84"> Lacio</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="fa fa-ruler"></i> Longitud de cabello (Sexo {{form.datos_generales.sexo}})</label>
                                                <div v-if="form.datos_generales.sexo === 'Femenino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Muy corto" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault85"/>
                                                    <label class="form-check-label" for="flexRadioDefault85">Muy corto (Pelo no rebasa la oreja)</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Femenino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Corto" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault86"/>
                                                    <label class="form-check-label" for="flexRadioDefault86"> Corto (Pelo llega a la mandíbula)</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Femenino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Mediano" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault87"/>
                                                    <label class="form-check-label" for="flexRadioDefault87"> Mediano (Pelo llega a los hombros)</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Femenino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Largo" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault88"/>
                                                    <label class="form-check-label" for="flexRadioDefault88"> Largo (Pelo llega al pecho)</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Femenino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Muy largo" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault88.1"/>
                                                    <label class="form-check-label" for="flexRadioDefault88.1">Muy largo (Pelo llega al estómago</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Masculino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Rapado" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault88.2"/>
                                                    <label class="form-check-label" for="flexRadioDefault88.2">Rapado (No tiene pelo)</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Masculino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Corto" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault88.3"/>
                                                    <label class="form-check-label" for="flexRadioDefault88.3">Corto (Pelo mide menos de una pulgada de longitud)</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Masculino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Mediano" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault88.4"/>
                                                    <label class="form-check-label" for="flexRadioDefault88.4">Mediano (Si el pelo supera una pulgada de longitud)</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Masculino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Largo" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault88.5"/>
                                                    <label class="form-check-label" for="flexRadioDefault88.5">Largo (Si el pelo supera la oreja)</label>
                                                </div>
                                                <div v-if="form.datos_generales.sexo === 'Masculino'" class="form-check">
                                                    <input v-model="form.senas_particulares.longitud_cabello" value="Muy largo" class="form-check-input" type="radio" name="longitud_cabello" id="flexRadioDefault88.6"/>
                                                    <label class="form-check-label" for="flexRadioDefault88.6">Muy largo (Si el pelo llega a los hombros)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="mx-2"><i class="fa fa-person-breastfeeding"></i> Complexión física</label>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.complexion_fisica" value="Delgada" class="form-check-input" type="radio" name="complexion_fisica" id="flexRadioDefault89"/>
                                                    <label class="form-check-label" for="flexRadioDefault89"> Delgada</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.complexion_fisica" value="Media" class="form-check-input" type="radio" name="complexion_fisica" id="flexRadioDefault90"/>
                                                    <label class="form-check-label" for="flexRadioDefault90"> Media</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.complexion_fisica" value="Corpulenta" class="form-check-input" type="radio" name="complexion_fisica" id="flexRadioDefault91"/>
                                                    <label class="form-check-label" for="flexRadioDefault91"> Corpulenta</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.complexion_fisica" value="Obesa" class="form-check-input" type="radio" name="complexion_fisica" id="flexRadioDefault92"/>
                                                    <label class="form-check-label" for="flexRadioDefault92"> Obesa</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3 row align-items-center justify-content-center border rounded rounded-2">
                                                <label class="mx-2 col-12"><i class="fa fa-person-circle-check"></i> Forma de nariz</label>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Romana" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault93"/>
                                                    <label class="form-check-label" for="flexRadioDefault93"> Romana: <img style="width: 100px; height: 100px;" src="/img/nariz/romana.jpg" alt="romana"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Corta" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault94"/>
                                                    <label class="form-check-label" for="flexRadioDefault94"> Corta: <img style="width: 100px; height: 100px;" src="/img/nariz/corta.jpg" alt="corta"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Aguileña" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault95"/>
                                                    <label class="form-check-label" for="flexRadioDefault95"> Aguileña: <img style="width: 100px; height: 100px;" src="/img/nariz/aguileña.jpg" alt="aguileña"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Chata" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault96"/>
                                                    <label class="form-check-label" for="flexRadioDefault96"> Chata: <img style="width: 100px; height: 100px;" src="/img/nariz/chata.jpg" alt="chata"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Respingada" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault97"/>
                                                    <label class="form-check-label" for="flexRadioDefault97"> Respingada: <img style="width: 100px; height: 100px;" src="/img/nariz/respingada.jpg" alt="respingada"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Griega" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault98"/>
                                                    <label class="form-check-label" for="flexRadioDefault98"> Griega (Recta): <img style="width: 100px; height: 100px;" src="/img/nariz/griega(recta).jpg" alt="griega(recta)"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Ganchuda" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault99"/>
                                                    <label class="form-check-label" for="flexRadioDefault99"> Ganchuda: <img style="width: 100px; height: 100px;" src="/img/nariz/ganchuda.jpg" alt="ganchuda"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Irregular" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault100"/>
                                                    <label class="form-check-label" for="flexRadioDefault100"> Irregular: <img style="width: 100px; height: 100px;" src="/img/nariz/irregular.jpg" alt="irregular"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Plana" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault101"/>
                                                    <label class="form-check-label" for="flexRadioDefault101"> Plana: <img style="width: 100px; height: 100px;" src="/img/nariz/plana.jpg" alt="plana"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Angosta" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault102"/>
                                                    <label class="form-check-label" for="flexRadioDefault102"> Angosta: <img style="width: 100px; height: 100px;" src="/img/nariz/angosta.jpg" alt="angosta"></label>
                                                </div>
                                                <div class="form-check col-md-2 col-6">
                                                    <input v-model="form.senas_particulares.forma_nariz" value="Alta" class="form-check-input" type="radio" name="forma_nariz" id="flexRadioDefault103"/>
                                                    <label class="form-check-label" for="flexRadioDefault103"> Alta: <img style="width: 100px; height: 100px;" src="/img/nariz/alta.jpg" alt="alta"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="mx-2"><i class="fa fa-arrows-to-eye"></i> Color de ojos</label>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.color_ojos" value="Café claro" class="form-check-input" type="radio" name="color_ojos" id="flexRadioDefault104"/>
                                                    <label class="form-check-label" for="flexRadioDefault104"> Café claro</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.color_ojos" value="Café Oscuro" class="form-check-input" type="radio" name="color_ojos" id="flexRadioDefault105"/>
                                                    <label class="form-check-label" for="flexRadioDefault105"> Café Oscuro</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.color_ojos" value="Azul" class="form-check-input" type="radio" name="color_ojos" id="flexRadioDefault106"/>
                                                    <label class="form-check-label" for="flexRadioDefault106"> Azul</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.color_ojos" value="Verde" class="form-check-input" type="radio" name="color_ojos" id="flexRadioDefault107"/>
                                                    <label class="form-check-label" for="flexRadioDefault107"> Verde</label>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-3 row align-items-center justify-content-center">
                                                <label class="mx-2 col-12"><i class="fa fa-person-circle-exclamation"></i> ¿Tiene algún lunar que destaque?</label>
                                                <div class="form-check col-5 col-md-4">
                                                    <img style="width: 90px; height: 100px;" src="/img/lunares/lunares.jpg" alt="lunares">
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="form-check">
                                                        <input v-model="form.senas_particulares.lunar" value="Con lunares visibles" class="form-check-input" type="radio" name="lunar" id="flexRadioDefault108"/>
                                                        <label class="form-check-label" for="flexRadioDefault108"> Con lunares visibles</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input @click="form.senas_particulares.lunar_descripcion = null" v-model="form.senas_particulares.lunar" value="Sin lunares visibles" class="form-check-input" type="radio" name="lunar" id="flexRadioDefault109"/>
                                                        <label class="form-check-label" for="flexRadioDefault109"> Sin lunares visibles</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <div class="form-floating mb-4">
                                                    <span v-if="form.senas_particulares.lunar_descripcion !== null && form.senas_particulares.lunar_descripcion !== ''">(Lunares) Mencione su ubicación, tamaño y forma</span>
                                                    <el-input v-model="form.senas_particulares.lunar_descripcion" :disabled="form.senas_particulares.lunar === 'Sin lunares visibles'" :class="form.senas_particulares.lunar === 'Sin lunares visibles' ? 'text-decoration-line-through': ''"  type="textarea" :rows="4" name="lunar_descripcion" id="textArea1" style="height: 100px;" placeholder="(Lunares) Mencione su ubicación, tamaño y forma"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="mx-2"><i class="bi bi-question-circle"></i> ¿Tiene algún tatuaje?</label>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.tatuaje" value="Con tatuajes" class="form-check-input" type="radio" name="tatuaje" id="flexRadioDefault110"/>
                                                    <label class="form-check-label" for="flexRadioDefault110"> Con tatuajes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="form.senas_particulares.tatuaje_descripcion = null" v-model="form.senas_particulares.tatuaje" value="Sin tatuajes" class="form-check-input" type="radio" name="tatuaje" id="flexRadioDefault111"/>
                                                    <label class="form-check-label" for="flexRadioDefault111"> Sin tatuajes</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating mb-4">
                                                    <span v-if="form.senas_particulares.tatuaje_descripcion !== null && form.senas_particulares.tatuaje_descripcion !== ''">(Tatuaje) Describa la ubicación, tamaño y figura del tatuaje</span>
                                                    <el-input v-model="form.senas_particulares.tatuaje_descripcion" :disabled="form.senas_particulares.tatuaje === 'Sin tatuajes'" :class="form.senas_particulares.tatuaje === 'Sin tatuajes' ? 'text-decoration-line-through': ''" type="textarea" :rows="4" name="tatuaje_descripcion" id="textArea2" style="height: 100px;" placeholder="(Tatuaje) Describa la ubicación, tamaño y figura del tatuaje"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="mx-2"><i class="fa fa-question-circle"></i> ¿Tiene alguna cicatriz?</label>
                                                <div class="form-check">
                                                    <input v-model="form.senas_particulares.cicatriz" value="Con cicatrices" class="form-check-input" type="radio" name="cicatriz" id="flexRadioDefault112"/>
                                                    <label class="form-check-label" for="flexRadioDefault112"> Con cicatrices</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="form.senas_particulares.cicatriz_descripcion = null" v-model="form.senas_particulares.cicatriz" value="Sin cicatrices" class="form-check-input" type="radio" name="cicatriz" id="flexRadioDefault113"/>
                                                    <label class="form-check-label" for="flexRadioDefault113"> Sin cicatrices</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating mb-4">
                                                    <span v-if="form.senas_particulares.cicatriz_descripcion !== null && form.senas_particulares.cicatriz_descripcion !== ''">(Cicatrices) Describa la ubicación, tamaño y forma de la cicatriz</span>
                                                    <el-input v-model="form.senas_particulares.cicatriz_descripcion" :disabled="form.senas_particulares.cicatriz === 'Sin cicatrices'" :class="form.senas_particulares.cicatriz === 'Sin cicatrices' ? 'text-decoration-line-through': ''" type="textarea" :rows="4" name="cicatriz_descripcion" id="textArea3" style="height: 100px;" placeholder="(Cicatrices) Describa la ubicación, tamaño y forma de la cicatriz"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 14-->
                                    <div id="information-part14" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        <div class="form-floating col-md-12 my-4">
                                            <h5 class="text-center"><span>Antecedentes Personales Patológicos</span></h5>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-3 mb-4">
                                                <label class="mx-2"><i class="bi bi-person-lines-fill"></i> ¿Tiene alguna discapacidad?</label>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.discapacidad" value="Sin descapacidad" class="form-check-input" type="radio" name="discapacidad" id="flexRadioDefault114"/>
                                                    <label class="form-check-label" for="flexRadioDefault114"> Sin descapacidad</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="discapacidad" id="flexRadioDefault115"/>
                                                    <label class="form-check-label" for="flexRadioDefault115"> Otro: <el-input v-model="form.discapacidades.discapacidad" type="text" size="large" id="discapacidad_otros"/></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="mx-2"><i class="bi bi-person-slash"></i> ¿Tiene alguna prótesis?</label>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.protesis" value="Si" class="form-check-input" type="radio" name="protesis" id="flexRadioDefault116"/>
                                                    <label class="form-check-label" for="flexRadioDefault116"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="form.discapacidades.funcion_protesis = null" v-model="form.discapacidades.protesis" value="No" class="form-check-input" type="radio" name="protesis" id="flexRadioDefault117"/>
                                                    <label class="form-check-label" for="flexRadioDefault117"> No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating mb-4">
                                                    <span v-if="form.discapacidades.funcion_protesis !== null && form.discapacidades.funcion_protesis !== ''">Mencione la función de la prótesis</span>
                                                    <el-input v-model="form.discapacidades.funcion_protesis" :disabled="form.discapacidades.protesis === 'No'" type="textarea" :rows="4" :class="form.discapacidades.protesis === 'No' ? 'text-decoration-line-through': ''" name="funcion_protesis" id="textArea4" style="height: 100px;" placeholder="Mencione la función de la prótesis"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="mx-2"><i class="bi bi-person-slash"></i> ¿Claudica al caminar?</label>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.claudica" value="Si" class="form-check-input" type="radio" name="claudica" id="flexRadioDefault118"/>
                                                    <label class="form-check-label" for="flexRadioDefault118"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.claudica" value="No" class="form-check-input" type="radio" name="claudica" id="flexRadioDefault119"/>
                                                    <label class="form-check-label" for="flexRadioDefault119"> No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label class="mx-2"><i class="fa fa-users"></i> Discapacidad Visual que padezca</label>
                                                <div class="form-check">
                                                    <input @click="validaDiscapacidadVisual($event.target.value)" :disabled="form.discapacidades.discapacidad_visual.length > 0 && !form.discapacidades.discapacidad_visual.includes('Ninguna')" value="Ninguna" class="form-check-input" type="checkbox" name="discapacidad_visual" id="flexCheckDefault6"/>
                                                    <label class="form-check-label" :class="form.discapacidades.discapacidad_visual.length > 0 && !form.discapacidades.discapacidad_visual.includes('Ninguna') ? 'text-decoration-line-through': ''" for="flexCheckDefault6"> Ninguna</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="validaDiscapacidadVisual($event.target.value)" value="Miopia" class="form-check-input" :disabled="form.discapacidades.discapacidad_visual.includes('Ninguna')" type="checkbox" name="discapacidad_visual" id="flexCheckDefault7"/>
                                                    <label class="form-check-label" :class="form.discapacidades.discapacidad_visual.includes('Ninguna') ? 'text-decoration-line-through': ''" for="flexCheckDefault7"> Miopia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="validaDiscapacidadVisual($event.target.value)" value="Hipermetropía" class="form-check-input" :disabled="form.discapacidades.discapacidad_visual.includes('Ninguna')" type="checkbox" name="discapacidad_visual" id="flexCheckDefault8"/>
                                                    <label class="form-check-label" :class="form.discapacidades.discapacidad_visual.includes('Ninguna') ? 'text-decoration-line-through': ''" for="flexCheckDefault8"> Hipermetropía</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="validaDiscapacidadVisual($event.target.value)" value="Astigmatismo" class="form-check-input" :disabled="form.discapacidades.discapacidad_visual.includes('Ninguna')" type="checkbox" name="discapacidad_visual" id="flexCheckDefault9"/>
                                                    <label class="form-check-label" :class="form.discapacidades.discapacidad_visual.includes('Ninguna') ? 'text-decoration-line-through': ''" for="flexCheckDefault9"> Astigmatismo</label>
                                                </div>
                                                <div class="form-check">
                                                    <input @click="validaDiscapacidadVisual($event.target.value)" value="Dislexia" class="form-check-input" :disabled="form.discapacidades.discapacidad_visual.includes('Ninguna')" type="checkbox" name="discapacidad_visual" id="flexCheckDefault10"/>
                                                    <label class="form-check-label" :class="form.discapacidades.discapacidad_visual.includes('Ninguna') ? 'text-decoration-line-through': ''" for="flexCheckDefault10"> Dislexia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" :checked="discapacidad_visual_otros !== null && discapacidad_visual_otros !== ''" :disabled="form.discapacidades.discapacidad_visual.includes('Ninguna')" type="checkbox" name="discapacidad_visual" id="flexCheckDefault11"/>
                                                    <label class="form-check-label" :class="form.discapacidades.discapacidad_visual.includes('Ninguna') ? 'text-decoration-line-through': ''" for="flexCheckDefault11"> Otro: <el-input @click="validaDiscapacidadVisualOtros($event.target.value)" v-model="discapacidad_visual_otros" @focusout="$event.target.value !== '' ? validaDiscapacidadVisual($event.target.value) : null" type="text" :disabled="form.discapacidades.discapacidad_visual.includes('Ninguna')" size="large" id="discapacidad_visual_otros"/></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="mx-2"><i class="bi bi-person-slash"></i> ¿Utiliza lentes o pupilentes para ver?</label>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.lentes_pupilentes" value="Si" class="form-check-input" type="radio" name="lentes" id="flexRadioDefault120"/>
                                                    <label class="form-check-label" for="flexRadioDefault120"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.lentes_pupilentes" value="No" class="form-check-input" type="radio" name="lentes" id="flexRadioDefault121"/>
                                                    <label class="form-check-label" for="flexRadioDefault121"> No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="mx-2"><i class="bi bi-person-slash"></i> ¿Le hace falta alguna pieza dental?</label>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.falta_pieza_dental" value="Si" class="form-check-input" type="radio" name="pieza_dental" id="flexRadioDefault122"/>
                                                    <label class="form-check-label" for="flexRadioDefault122"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.falta_pieza_dental" value="No" class="form-check-input" type="radio" name="pieza_dental" id="flexRadioDefault123"/>
                                                    <label class="form-check-label" for="flexRadioDefault123"> No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="mx-2"><i class="bi bi-person-slash"></i> ¿Tiene empastes?</label>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.empastes" value="Si" class="form-check-input" type="radio" name="empastes" id="flexRadioDefault124"/>
                                                    <label class="form-check-label" for="flexRadioDefault124"> Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input v-model="form.discapacidades.empastes" value="No" class="form-check-input" type="radio" name="empastes" id="flexRadioDefault125"/>
                                                    <label class="form-check-label" for="flexRadioDefault125"> No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <el-popover
                                                    placement="top-start"
                                                    title="Ayuda"
                                                    :width="300"
                                                    trigger="hover"
                                                    content="Puede seleccionar varias opciones en este componente, si desea agregar una opcion que no está en la lista, escriba su nueva opción y seleccionela..."
                                                >

                                                    <template #reference>
                                                        <el-select
                                                            size="large"
                                                            class="extra-large"
                                                            v-model="form.discapacidades.patologias"
                                                            multiple
                                                            filterable
                                                            allow-create
                                                            default-first-option
                                                            :reserve-keyword="false"
                                                            placeholder="Patologías que ha padecido"
                                                        >
                                                            <el-option
                                                                v-for="item in opciones"
                                                                :key="item.value"
                                                                :label="item.label"
                                                                :value="item.value"
                                                            />
                                                        </el-select>
                                                    </template>
                                                </el-popover>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <el-popover

                                                    placement="top-start"
                                                    title="Ayuda"
                                                    :width="300"
                                                    trigger="hover"
                                                    content="Puede seleccionar varias opciones en este componente, si desea agregar una opcion que no está en la lista, escriba su nueva opción y seleccionela..."
                                                >
                                                    <template #reference>
                                                        <el-select
                                                            size="large"
                                                            class="extra-large"
                                                            v-model="form.discapacidades.patologias_familia"
                                                            multiple
                                                            filterable
                                                            allow-create
                                                            default-first-option
                                                            :reserve-keyword="false"
                                                            placeholder="Patologías padecidas por familiares"
                                                        >
                                                            <el-option
                                                                v-for="item in opciones"
                                                                :key="item.value"
                                                                :label="item.label"
                                                                :value="item.value"
                                                            />
                                                        </el-select>
                                                    </template>
                                                </el-popover>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Etapa 15-->
                                    <div id="information-part15" class="content" role="tabpanel" aria-labelledby="logins-part1-trigger">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="form-floating col-md-12 my-4">
                                                <h1 class="text-center text-success"><i class="bi bi-check-circle-fill"></i> Formulario Listo</h1>
                                            </div>
                                            <div class="form-floating col-md-12 mb-4">
                                                <h5 style="text-align: justify !important;">Ha completado de forma satisfactoria todos los datos del formulario. Haga click en el botón Finalizar para guardar sus datos. Si desea modificar algún dato hágalo antes de finalizar.</h5>
                                            </div>
                                            <form @submit.prevent="submit" class="form-floating col-md-12 mb-4">
                                                <button :disabled="form.processing" type="submit" :class="form.processing ? 'btn-secondary' : 'btn-primary'" class="btn ripple w-100"><i class="fa fa-save"></i> Finalizar</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row align-items-center justify-content-center px-3">
                                        <el-button  :disabled="step === 1" type="primary" plain id="btnPrev" :class="step === 1 ? 'btn-secondary' : 'btn-primary'" class="col-2 ripple"><i class="fa fa-arrow-left"></i></el-button>
                                        <div class="col-8"><div class="progress">
                                            <div
                                                class="progress-bar progress-bar-striped progress-bar-animated fw-bold"
                                                role="progressbar"
                                                :aria-valuenow="(step-1)/14 * 100"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                                :style="`width: ${(step-1)/14 * 100}%;`"
                                            >{{ ((step-1)/14 * 100).toFixed(0)}}%</div>
                                        </div></div>
                                        <el-button :disabled="step === 15" type="primary" plain id="btnNext" :class="step === 15 ? 'btn-secondary' : 'btn-primary'" class="col-2 ripple"><i class="fa fa-arrow-right"></i></el-button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Modal Política de Privacidad-->
                <div class="modal fade" id="staticBackdropPoliticaPrivacidad" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa fa-info-circle"></i> Aviso de Privacidad para Encuesta de Certificado Médico </h1>
                                <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-floating mb-3">
                                       <p style="text-align: justify">

                                           En cumplimiento con la Ley Federal de Protección de Datos Personales en Posesión de Particulares y su Reglamento, "Laboratorio Clínico y Patológico" (en adelante, "nosotros" o "el Laboratorio") con domicilio en Av Francisco Villa #90 Col. Treviño Zapata C.P. 87450, H, Matamoros, Tamaulipas, es responsable de recabar sus datos personales, del uso que se le dé a los mismos y de su protección.

                                           <br><br><b>I. Finalidades del Tratamiento de Datos Personales</b><br>

                                           Los datos personales que recabamos serán utilizados con el propósito de llevar a cabo la encuesta de certificado médico y evaluar la calidad de nuestros servicios de laboratorio. Dichas finalidades incluyen, pero no se limitan a:

                                           1. Verificación y validación de la información proporcionada.
                                           2. Evaluación de la satisfacción del cliente.
                                           3. Mejora continua de nuestros servicios y procesos.


                                           <br><b>II. Datos Personales Recabados</b><br>

                                           Los datos personales que recabamos para llevar a cabo la encuesta de certificado médico pueden incluir, entre otros:

                                           1. Nombre completo.
                                           2. Edad.
                                           3. Género.
                                           4. Información de contacto (teléfono, correo electrónico).
                                           5. Información de salud relevante para el certificado médico.


                                           <br><b>III. Medidas de Seguridad</b><br>

                                           Nos comprometemos a implementar medidas de seguridad administrativas, técnicas y físicas para proteger sus datos personales contra daño, pérdida, alteración, destrucción o el uso, acceso o tratamiento no autorizado.


                                           <br><b>IV. Transferencia de Datos</b><br>

                                           Sus datos personales podrán ser transferidos a terceros únicamente con su consentimiento expreso y únicamente para los fines descritos en el apartado I. En el caso de requerirse una transferencia a terceros, se establecerán los mecanismos necesarios para asegurar la protección de sus datos.


                                           <br><b>V. Derechos ARCO</b><br>

                                           Usted tiene derecho a acceder, rectificar, cancelar u oponerse al tratamiento de sus datos personales (Derechos ARCO). Para ejercer dichos derechos, podrá presentar su solicitud por escrito en el domicilio señalado al inicio de este aviso, o a través del correo electrónico contacto@labclinic.mx. Su solicitud deberá contener: nombre y dirección del titular, documentos que acrediten su identidad, descripción clara y precisa de los datos a los que desea acceder, rectificar, cancelar u oponerse, y cualquier otro elemento que facilite la localización de los datos.

                                           <br><b>VI. Cambios al Aviso de Privacidad</b><br>

                                           Nos reservamos el derecho de efectuar en cualquier momento modificaciones o actualizaciones al presente aviso, para la atención de novedades legislativas, políticas internas o nuevos requerimientos para la prestación de nuestros servicios.

                                           Al proporcionar sus datos personales y participar en la encuesta de certificado médico, usted reconoce haber leído y entendido el presente Aviso de Privacidad, aceptando los términos y condiciones en él establecidos.

                                           Fecha de última actualización: 21 de Agosto de 2023

                                           Para cualquier duda o aclaración respecto a este aviso, por favor comuníquese con nuestro Departamento de Protección de Datos Personales en la dirección Av Francisco Villa #90 Col. Treviño Zapata C.P. 87450, H, Matamoros, Tamaulipas, o al correo electrónico contacto@labclinic.mx.

                                           <br><br><b>Atentamente,</b><br>

                                           QFB. MARIA GUADALUPE SÁNCHEZ ANDRADE<br>
                                           Responsable de Protección de Datos
                                       </p>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer row align-items-center justify-content-center">
                                <div class="m-2">
                                    <input v-model="aceptar_politica" :checked="aceptar_politica === true" type="checkbox" class="form-check-input shadow-3-strong" id="aceptar_politica">
                                    <label for="aceptar_politica" class="form-check-label fst-italic"> &nbsp Acepto la política de privacidad</label>
                                </div>
                                <div class="my-2 w-100 row align-items-center justify-content-center">
                                    <div class="col-6">
                                        <button :disabled="!aceptar_politica" class="btn btn-primary btn-lg form-control text-capitalize ripple" id="btn_aceptar"><i class="fa fa-check"></i> Aceptar</button>
                                    </div>
                                    <div class="col-6">
                                        <button @click="redirigeLogin" class="btn btn-danger btn-lg form-control text-capitalize ripple" id="btn_cancelar"><i class="fa fa-cancel"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Laboratorio Clínico y Patológico 2023</div>
                        <div>
                            <a id="show_politica_privacidad" href="#"><i class="bi bi-shield-fill-exclamation"></i> Política de Privacidad</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </body>
</template>

<style scoped>
:root {
    --el-component-size-large: 50px;
}

</style>
