<script setup>
import {onMounted, ref} from "vue";
import {router, Link, useForm, usePage} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";

const page = usePage();

defineProps({
    empresa: Object
})

let form = useForm({
    nombre: page.props.empresa.nombre,
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
    form.put(`/empresas/${page.props.empresa.id}`, options)
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
                        <h1 class="mt-4"><i class="fas fa-building"></i> Empresas</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item fw-bold"><Link href="/dashboard"><i class="fas fa-dashboard"></i> Dashboard</Link></li>
                                    <li class="breadcrumb-item active fw-bold"><Link href="/empresas"> <i class="fas fa-building-columns"></i> Empresas </Link></li>
                                    <li class="breadcrumb-item active fw-bold"><i class="fas fa-edit"></i>Editar Empresa</li>
                                </ol>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="form-floating col-md-12 mb-4">
                                            <input v-model="form.nombre" type="text" class="form-control shadow-3-strong" id="floatingInput2" placeholder="Nombre">
                                            <label for="floatingInput2" class="mx-2"><i class="fas fa-building"></i> Nombre</label>
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
