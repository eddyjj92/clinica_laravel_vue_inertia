<script setup>
import Layout from '../Layouts/Navbar.vue'
import {onMounted, ref, watchEffect} from "vue";
import {router, useForm, usePage, Link} from "@inertiajs/vue3";

const page = usePage()

defineProps({
    errors: Object,
    validacion: String,
    denied: String
});

let form = useForm({
    usuario: null,
    password: null,
    database: null
});
let form2 = useForm({
    voucher: null,
});

let databases = ref([]);
let modal = ref(null);
let fullScreen = ref(false);

onMounted(()=>{
    const options = {
        backdrop: 'static'
    }
    const myModalEl = document.getElementById('staticBackdrop');
    const myModal = new bootstrap.Modal(myModalEl, options);
    modal.value = myModal;
    modal.value.show();

    myModalEl.addEventListener('hidden.bs.modal', (e) => {
        page.props.auth.user === null && !cuest.value && !autenticando.value ? myModal.show(): myModal.hide();
    })

    if(page.props.denied){
        Swal.fire({
            icon: 'error',
            title: 'Accedo Denegado',
            text: page.props.denied
        })
    }

})

const options = {
    preserveScroll: true,
    onError: errors => {
        Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: errors.validacion
        })
        cuest.value = false;
        autenticando.value = false;
        modal.value.show();
        toggleFullScreen();
    },
    onSuccess: () =>{
        autenticando.value = false;
    }
}
let autenticando = ref(false);
const submit = () =>{
    toggleFullScreen();
    autenticando.value = true;
    form.post(`/login`, options)
}

let voucher = ref(false);
const setVoucher = (value) => {
    voucher.value = value;
}

let cuest = ref(false);
const submit2 = () => {
    toggleFullScreen();
    cuest.value = true;
    $('.btn-close').click()
    form2.post('/cuestionarios/create', options);
}

function toggleFullScreen() {
    document.documentElement.requestFullscreen();
    fullScreen.value = true;
}

</script>

<template>
    <Layout :screen="fullScreen" />
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div v-if="!voucher" class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa fa-shield-alt"></i> Ingresar Credenciales</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="w-100">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" style="width: 50%">
                            <a class="nav-link active text-center bg-info" aria-current="page" href="#"><i class="fa fa-key"></i> Login</a>
                        </li>
                        <li class="nav-item" style="width: 50%">
                            <a @click="setVoucher(true)" class="nav-link text-center bg-secondary text-white" href="#"><i class="fa fa-clipboard"></i> Cuestionario</a>
                        </li>
                    </ul>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submit">
                        <div class="form-floating mb-3">
                            <input v-model="form.usuario" type="text" class="form-control shadow-3-strong" id="floatingInput1" placeholder="name@example.com">
                            <label for="floatingInput1"><i class="fa fa-person"></i> Usuario</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input ref="submitBtn" v-model="form.password" type="password" class="form-control shadow-3-strong" id="floatingInput2" placeholder="name@example.com">
                            <label for="floatingInput2"><i class="fa fa-list-1-2"></i> Contraseña</label>
                        </div>
                        <div class="mb-2">
                            <input v-model="form.remember" type="checkbox" class="form-check-input shadow-3-strong" id="recordar" placeholder="Subject">
                            <label for="recordar" class="form-check-label fst-italic">Recordar Credenciales</label>
                        </div>
                        <button :disabled="form.processing" type="submit" class="btn btn-primary btn-lg form-control text-capitalize ripple" data-bs-dismiss="modal"><i class="fa fa-key"></i> Ingresar</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        <div v-else class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa fa-shield-alt"></i> Ingresar Voucher</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="w-100">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" style="width: 50%;">
                            <a @click="setVoucher(false)" class="nav-link text-center bg-secondary text-white" aria-current="page" href="#"><i class="fa fa-key"></i> Login</a>
                        </li>
                        <li class="nav-item" style="width: 50%">
                            <a class="nav-link active text-center bg-info" href="#"><i class="fa fa-clipboard"></i> Cuestionario</a>
                        </li>
                    </ul>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submit2">
                        <div class="form-floating mb-3">
                            <input v-model="form2.voucher" type="text" class="form-control shadow-3-strong" id="floatingInput1" placeholder="Ingrese su Voucher">
                            <label for="floatingInput1"><i class="fa fa-check-circle"></i> Ingrese su Voucher</label>
                        </div>
                        <button :disabled="form.processing" type="submit" class="btn btn-primary btn-lg form-control text-capitalize ripple" data-bs-dismiss="modal"><i class="fa fa-clipboard-check"></i> Verificar</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
