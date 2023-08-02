<script setup>
import {onMounted, ref} from "vue";
import {router, Link, useForm} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";

defineProps({
    empresas: Object
})

let form = useForm({
    correo: null,
    nombre: null,
    empresa:null,
    cargo: null,
    password: null,
    confirmar_password: null,
});

onMounted(()=>{
    toggleNavbar()
})

const options = {
    preserveScroll: true,
    onError: errors => {
        Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: errors.validacion
        })
    },
    onSuccess: page2 =>{
        Swal.fire({
            icon: 'success',
            title: 'Operación Exitosa',
            text: page2.props.flash.message
        })
    }
}

const submit = () =>{
    form.post(`/usuario/registrar`, options)
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
                        <h1 class="mt-4"><i class="fa fa-user"></i> Usuarios</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item fw-bold"><Link href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                    <li class="breadcrumb-item active fw-bold"><Link href="/usuarios"> <i class="fa fa-users"></i> Usuarios </Link></li>
                                    <li class="breadcrumb-item active fw-bold"><i class="fa fa-user-plus"></i>Registrar Usuario</li>
                                </ol>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="form-floating col-md-6 mb-4">
                                            <input v-model="form.correo" type="email" class="form-control shadow-3-strong" id="floatingInput1" placeholder="name@example.com">
                                            <label for="floatingInput1" class="mx-2"><i class="fas fa-at"></i> Correo Electrónico</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <input v-model="form.nombre" type="text" class="form-control shadow-3-strong" id="floatingInput2" placeholder="Nombre y Apellidos">
                                            <label for="floatingInput2" class="mx-2"><i class="fas fa-person"></i> Nombre y Apellidos</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <select v-model="form.empresa" class="form-select shadow-3-strong" id="floatingInput3">
                                                <option :value="null">Seleccionar Empresa</option>
                                                <option v-for="empresa in empresas" :value="empresa.id">{{empresa.nombre}}</option>
                                            </select>
                                            <label for="floatingInput3" class="mx-2"><i class="fas fa-building"></i> Empresa</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <input v-model="form.cargo" type="text" class="form-control shadow-3-strong" id="floatingInput4" placeholder="Nombre y Apellidos">
                                            <label for="floatingInput4" class="mx-2"><i class="fas fa-person-half-dress"></i> Cargo</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <input v-model="form.password" type="password" class="form-control shadow-3-strong" id="floatingInput5" placeholder="Contraseña">
                                            <label for="floatingInput4" class="mx-2"><i class="fas fa-asterisk"></i> Contraseña</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <input v-model="form.confirmar_password" type="password" class="form-control shadow-3-strong" id="floatingInput6" placeholder="Contraseña">
                                            <label for="floatingInput4" class="mx-2"><i class="fas fa-asterisk"></i> Confirmar Contraseña</label>
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
                                <a href="#">Política de Privacidad</a>
                                &middot;
                                <a href="#">Términos &amp; Condiciones</a>
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
