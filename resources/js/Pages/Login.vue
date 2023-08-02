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
let databases = ref([]);
let modal = ref(null);

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
        autenticando.value = false;
        modal.value.show();
    },
    onSuccess: () =>{
        autenticando.value = false;
    }
}
let autenticando = ref(false);
const submit = () =>{
    autenticando.value = true;
    form.post(`/login`, options)
}

let cuest = ref(false);
const cuestionario = () => {
    cuest.value = true;
    $('.btn-close').click()
    router.get('/cuestionarios/create');
}

</script>

<template>
    <Layout />
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ingresar Credenciales</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <button :disabled="form.processing" type="submit" class="btn btn-primary btn-lg form-control text-capitalize ripple" data-bs-dismiss="modal"><i class="fa fa-key"></i> Acceder</button>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" @click="cuestionario" style="text-align: center;display: inline-block;width: 100%"><i class="fas fa-clipboard-question"></i> LLenar Cuestionario de Paciente</a>
            </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
