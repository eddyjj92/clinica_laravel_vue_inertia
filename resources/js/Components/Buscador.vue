<script setup>
import {onMounted, ref} from "vue";
import {router, Link} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";

defineProps({

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
            text:      '<i class="fas fa-backspace"></i> Regresar',
            action: function ( e, dt, node, config ) {
                router.get('/empresas/create');
            },
            className: `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white`,
        },
    ],
}

onMounted(()=>{
    $('#searchTable').DataTable(dtConfig);
})

const buscar = async() => {
    await axios.get()
}

</script>

<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><i class="fas fa-search"></i> Buscador</h1>
        <div class="card mb-4">
            <div class="card-header">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                    <li class="breadcrumb-item active fw-bold"><i class="fas fa-search"></i> Resultados de la Búsqueda</li>
                </ol>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-responsive w-100" id="searchTable">
                    <thead>
                    <tr>
                        <th hidden>Id</th>
                        <th>Empresa</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--                                <tr v-for="empresa in empresas" :key="empresa.id">
                                                        <td hidden>{{ empresa.id }}</td>
                                                        <td>{{ empresa.nombre }}</td>
                                                        <td>{{ empresa.created_at }}</td>
                                                        <td width="180px">
                                                            <RouterLink :to="`/usuario/perfil/${empresa.id}`" class="btn btn-success m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Ver Empresa ${empresa.nombre}`"><i class="bi bi-eye-fill fs-6"></i></RouterLink>
                                                            <RouterLink :to="`/usuario/editar/${empresa.id}`" class="btn btn-info m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Editar Empresa ${empresa.nombre}`"><i class="bi bi-pencil-square fs-6"></i></RouterLink>
                                                            <button @click="deleteEmpresa(empresa.id)" class="btn btn-danger m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Empresa ${empresa.nombre}`"> <i :hidden="idProcessing !== null && idProcessing === empresa.id"  class="bi bi-trash fs-6"></i> <span :hidden="!(idProcessing === empresa.id)" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>
                                                        </td>
                                                    </tr>-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
