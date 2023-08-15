<script setup>
import {onMounted, ref} from "vue";
import {router, Link} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";


const props = defineProps({
    result: Object,
    buscando: Boolean
})

let dtConfig = {
    "order": [[ 0, 'asc' ]],
    language: {
        url: `api/datatables/es`
    },
    dom: 'rtip',
    select: true,
    lengthMenu: [
        [10, 25, 50, 100, -1],
        ['10 Filas', '25 Filas', '50 Filas', '100 Filas', 'Todo']
    ],
    buttons: [
        {
            text:      '<i class="fas fa-backspace"></i> Regresar',
            action: function ( e, dt, node, config ) {
                router.get('/dashboard');
            },
            className: `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white`,
        },
    ],
}

onMounted(()=>{
    $('#searchTable').DataTable(dtConfig);
})

</script>

<template>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><i class="fas fa-search"></i> Buscador</h1>
        <div class="card mb-4">
            <div class="card-header">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                    <li class="breadcrumb-item active fw-bold"><i class="fas fa-list"></i> Resultados de la Búsqueda ({{props.result.data.usuarios.length + props.result.data.empresas.length + props.result.data.cuestionarios.length}}) <span :hidden="!props.buscando" class="text-info">(<i class="fa fa-search"></i> Buscando...)</span></li>
                </ol>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-responsive w-100" id="searchTable">
                    <thead>
                        <tr class="bg-primary">
                            <th>#</th>
                            <th>Modelo de Datos</th>
                            <th class="w-75">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <th>Usuarios ({{props.result.data.usuarios.length}})</th>
                            <th>
                                <table class="w-100 table">
                                    <thead>
                                         <tr class="bg-success">
                                             <th class="w-5">Id</th>
                                             <th>Avatar</th>
                                             <th class="w-35">Nombre</th>
                                             <th>Fecha Registro</th>
                                             <th>Acciones</th>
                                         </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in props.result.data.usuarios">
                                            <td>{{user.id}}</td>
                                            <td><img class="rounded border border-2 border-primary" style="width: 50px" :src="`/img/profile/${user.avatar}`" alt=""></td>
                                            <td>{{user.nombre}}</td>
                                            <td>{{user.created_at}}</td>
                                            <td class="w-10"><Link :href="`/usuario/perfil/${user.id}`" class="btn btn-success"><i class="fa fa-eye"></i></Link></td>
                                        </tr>
                                        <tr v-if="props.result.data.usuarios.length === 0">
                                            <td colspan="5" class="text-center text-danger">No hay resultados para este modelo de datos</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </th>
                        </tr>
                        <tr>
                            <th>2</th>
                            <th>Empresas ({{props.result.data.empresas.length}})</th>
                            <th>
                                <table class="w-100 table">
                                    <thead>
                                    <tr class="bg-success">
                                        <th class="w-5">Id</th>
                                        <th class="w-35">Empresa</th>
                                        <th>Fecha Registro</th>
                                        <th class="w-10">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="empresa in props.result.data.empresas">
                                            <td>{{empresa.id}}</td>
                                            <td>{{empresa.nombre}}</td>
                                            <td>{{empresa.created_at}}</td>
                                            <td><button class="btn btn-success"><i class="fa fa-eye"></i></button></td>
                                        </tr>
                                        <tr v-if="props.result.data.empresas.length === 0">
                                            <td colspan="4" class="text-center text-danger">No hay resultados para este modelo de datos</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </th>
                        </tr>
                        <tr>
                            <th>3</th>
                            <th>Cuestionarios ({{props.result.data.cuestionarios.length}})</th>
                            <th>
                                <table class="w-100 table">
                                    <thead>
                                    <tr class="bg-success">
                                        <th class="w-5">Id</th>
                                        <th>Avatar</th>
                                        <th class="w-35">Paciente</th>
                                        <th>Fecha Registro</th>
                                        <th class="w-10">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="cuestionario in props.result.data.cuestionarios">
                                        <td>{{cuestionario.id}}</td>
                                        <td><img class="rounded border border-2 border-primary" style="width: 50px" :src="`/img/pacientes/${cuestionario.data.datos_generales.avatar}`" alt=""></td>
                                        <td>{{cuestionario.paciente}}</td>
                                        <td>{{cuestionario.created_at}}</td>
                                        <td><button class="btn btn-success"><i class="fa fa-eye"></i></button></td>
                                    </tr>
                                    <tr v-if="props.result.data.cuestionarios.length === 0">
                                        <td colspan="5" class="text-center text-danger">No hay resultados para este modelo de datos</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>
.w-35{
    width: 35%;
}
.w-10{
    width: 10%;
}
.w-5{
    width: 5%;
}
</style>
