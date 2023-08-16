<script setup>
import {onMounted, ref} from "vue";
import {router, Link, usePage} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";

const page = usePage();

defineProps({
    empresas: Object
})

let dtConfig = {
    "order": [[ 0, 'asc' ]],
    language: {
        url: `api/datatables/es`
    },
    dom: 'lBfrtip',
    select: true,
    lengthMenu: [
        [10, 25, 50, 100, -1],
        ['10 Filas', '25 Filas', '50 Filas', '100 Filas', 'Todo']
    ],
    buttons: [
        {
            text:      '<i class="fas fa-building"></i> Registrar Empresa',
            action: function ( e, dt, node, config ) {
                router.get('/empresas/create');
            },
            className: page.props.auth.user.permisos.filter(value => value.id === 5).length > 0 ? `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white` : `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white disabled`,
        },
    ],
}

onMounted(()=>{
    toggleNavbar()
    $('#empresasTable').DataTable(dtConfig);
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
    onSuccess: () =>{
        idProcessing.value = null;
        router.get('/empresas');
    },
}

const deleteEmpresa = (id) =>{
    Swal.fire({
        title: 'Eliminar Empresa',
        text: "¿Está seguro q desea eliminar este empresa?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            idProcessing.value = id;
            router.delete(`/empresas/${id}`, options)
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
                    <h1 class="mt-4"><i class="fas fa-building-columns"></i> Empresas</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                <li class="breadcrumb-item active fw-bold"><i class="fas fa-building-columns"></i> Empresas</li>
                            </ol>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-striped table-responsive w-100" id="empresasTable">
                                <thead>
                                <tr>
                                    <th hidden>Id</th>
                                    <th>Empresa</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="empresa in empresas" :key="empresa.id">
                                    <td hidden>{{ empresa.id }}</td>
                                    <td>{{ empresa.nombre }}</td>
                                    <td>{{ empresa.created_at }}</td>
                                    <td width="180px">
                                        <RouterLink :to="`/usuario/perfil/${empresa.id}`" class="btn btn-success m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Ver Empresa ${empresa.nombre}`"><i class="bi bi-eye-fill fs-6"></i></RouterLink>
                                        <Link :href="`/empresas/${empresa.id}/edit`" class="btn btn-info m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Editar Empresa ${empresa.nombre}`"><i class="bi bi-pencil-square fs-6"></i></Link>
                                        <button @click="deleteEmpresa(empresa.id)" class="btn btn-danger m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Empresa ${empresa.nombre}`"> <i :hidden="idProcessing !== null && idProcessing === empresa.id"  class="bi bi-trash fs-6"></i> <span :hidden="!(idProcessing === empresa.id)" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>
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
