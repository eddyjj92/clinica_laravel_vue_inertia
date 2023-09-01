<script setup>
import {onMounted, ref} from "vue";
import {router, Link, usePage} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";

const page = usePage();

defineProps({
    cuestionarios: Object
})

let dtConfig = {
    "order": [[ 0, 'asc' ]],
    language: {
        url: `api/datatables/es`
    },
    dom: 'lfrtip',
    select: true,
    lengthMenu: [
        [10, 25, 50, 100, -1],
        ['10 Filas', '25 Filas', '50 Filas', '100 Filas', 'Todo']
    ],
}

onMounted(()=>{
    toggleNavbar()
    $('#cuestionariosTable').DataTable(dtConfig);
})

let idProcessing = ref(null);
const options = {
    preserveScroll: true,
    onError: errors => {
        Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: errors.validacion
        })
        idProcessing.value = null;
    },
    onSuccess: data =>{
        Swal.fire({
            icon: 'success',
            title: 'Cuestionario Eliminado',
            text: data.props.flash.message
        })
        idProcessing.value = null;
        router.get('/cuestionarios');
    },
}

const deleteCuestionario = (id) =>{
    Swal.fire({
        title: 'Eliminar Cuestionario',
        text: "¿Está seguro q desea eliminar este cuestionario?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            idProcessing.value = id;
            router.delete(`/cuestionarios/${id}`, options)
        }
    })
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
                    <h1 class="mt-4"><i class="fa fa-clipboard-check"></i> Cuestionarios</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                <li class="breadcrumb-item active fw-bold"><i class="fa fa-clipboard-check"></i> Cuestionarios</li>
                            </ol>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-striped table-responsive w-100" id="cuestionariosTable">
                                <thead>
                                <tr>
                                    <th hidden>Id</th>
                                    <th>Paciente</th>
                                    <th>Empresa</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="cuest in cuestionarios" :key="cuest.id">
                                    <td hidden>{{ cuest.id }}</td>
                                    <td style="width: 35%">
                                        <div class="row justify-content-center align-items-center w-100">
                                            <div class="col-lg-4 col-md-5">
                                                <img class="rounded rounded-3 border border-1 border-primary w-100 h-100" :src="`/img/pacientes/${cuest.data.datos_generales.avatar}`">
                                            </div>
                                            <div class="col-lg-8 col-md-7">
                                                <div class="text-base fw-bold">{{ cuest.data.datos_generales.nombre }}</div>
                                                <div class="font-normal">{{ cuest.data.info_contacto.correo }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div class="text-base fw-bold">{{ cuest.data.datos_generales.empresa }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div class="text-base fw-bold">{{ cuest.created_at }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <a :href="`/certificado/${cuest.id}`" target="_blank" class="btn btn-info m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Generar Certificado Médico ${cuest.id}`"><i class="fa fa-file-pdf fs-6 text-white"></i></a>
                                        <Link :href="`/cuestionarios/${cuest.id}`" class="btn btn-success m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Ver Cuestionario ${cuest.id}`"><i class="fa fa-eye fs-6 text-white"></i></Link>
                                        <Link :href="`/cuestionarios/${cuest.id}/edit`" class="btn btn-primary m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Revisión Cuestionario ${cuest.id}`"><i class="fa fa-user-doctor fs-6 text-white"></i></Link>
                                        <button @click="deleteCuestionario(cuest.id)" class="btn btn-danger m-1 rounded-3" :id="cuest.id" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Cuestionario ${cuest.id}`"> <i :hidden="idProcessing !== null && idProcessing === cuest.id"  class="bi bi-trash fs-6"></i> <span :hidden="!(idProcessing === cuest.id)" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
