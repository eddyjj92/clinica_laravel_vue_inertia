<script setup>
import {onMounted, ref} from "vue";
import {router, Link, useForm, usePage} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import { genFileId } from 'element-plus'

const page = usePage();

defineProps({
    usuarios: Object
})

let selectedUser = ref(page.props.auth.user);
let form = useForm({
    usuario: selectedUser.value.id,
    trabajadores: null
});

onMounted(()=>{
    toggleNavbar()
})

const options = {
    preserveScroll: true,
    onError: async errors => {
        await Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: errors.validacion
        })
    },
    onSuccess: async page2 =>{
        await Swal.fire({
            icon: 'success',
            title: 'Operación Exitosa',
            text: page2.props.flash.message
        });
    }
}

const submit = async () =>{
    await form.post(`/solicitudes`, options)
}

function toggleFullScreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        }
    }
}

const selectUser = (id) => {
    let tempUser = page.props.usuarios.filter(usr => usr.id === id)[0];
    selectedUser.value.id = tempUser.id;
    selectedUser.value.empresa = tempUser.empresa;
    selectedUser.value.cargo = tempUser.cargo;
}
</script>

<template>
    <body class="sb-nav-fixed">
        <Navbar />
        <div id="layoutSidenav" class="vh-100">
            <Sidenav />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><i class="fa fa-book-medical"></i> Solicitudes</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item fw-bold"><Link href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                    <li class="breadcrumb-item active fw-bold"><Link href="/solicitudes"> <i class="fa fa-book-medical"></i> Solicitudes </Link></li>
                                    <li class="breadcrumb-item active fw-bold"><i class="fa fa-plus-circle"></i> Registrar Solicitud</li>
                                </ol>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="row align-items-center justify-content-center mb-4">
                                        <div class="form-floating col-md-6 mb-4">
                                            <span><i class="fa fa-user-check"></i> Solicitante</span>
                                            <el-select
                                                disabled
                                                v-model="selectedUser.id"
                                                size="large"
                                                class="extra-large"
                                                id="floatingInput3"
                                                placeholder="Usuario"
                                                @change="selectUser(selectedUser.id)"
                                            >
                                                <el-option v-for="usr in usuarios" :key="usr.id" :label="usr.nombre" :value="usr.id"/>
                                            </el-select>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <span><i class="fa fa-building-circle-arrow-right"></i> Empresa</span>
                                            <el-input disabled v-model="selectedUser.empresa.nombre" type="text" size="large" class="extra-large" id="floatingInput5" placeholder="Empresa"/>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <span><i class="fa fa-user-tag"></i> Cargo</span>
                                            <el-input disabled v-model="selectedUser.cargo" type="text" size="large" class="extra-large" id="floatingInput4" placeholder="Cargo Empresa"/>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <br>
                                            <el-input-number v-model="form.trabajadores" min="1" max="100" size="large" class="extra-large" id="floatingInput5" placeholder="Cantidad de Trabajadores"/>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button :disabled="form.processing" type="submit" class="btn btn-primary btn-lg shadow-3-strong text-capitalize"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </form>
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

</style>
