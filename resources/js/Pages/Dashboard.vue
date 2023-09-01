<script setup>
import {onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {toggleNavbar} from '../Helpers/index';
import Navbar from "../Layouts/Navbar.vue";
import Sidenav from "../Layouts/Sidenav.vue";
import Buscador from "@/Components/Buscador.vue";

let auth = ref(JSON.parse(localStorage.getItem('auth')));
let search = ref(null);
let result = ref({
    data: {
        usuarios: [],
        empresas: [],
        cuestionarios: [],
    }
})
let buscando = ref(false);
let fullScreen = ref(document.fullscreenElement);


onMounted(()=>{
    toggleNavbar()
})

const buscar = async(key) => {
    search.value = key;
    buscando.value = true;
    if(key !== null && key !== ''){
        await axios.get(`/buscador/${key}`).then(response => {
            result.value.data.usuarios = response.data.usuarios;
            result.value.data.empresas = response.data.empresas;
            result.value.data.cuestionarios = response.data.cuestionarios;
            buscando.value = false;
        })
    }
}

</script>

<template>
    <body class="sb-nav-fixed">
        <Navbar :screen="fullScreen" :search="search" @search="result => buscar(result)"/>
        <div id="layoutSidenav" class="vh-100">
            <Sidenav />
            <div id="layoutSidenav_content">
                <main>
                    <Buscador :buscando="buscando" :result="result" :hidden="search === null || search === ''" />
                    <div class="container-fluid px-4" :hidden="search !== null && search !== ''">
                        <h1 class="mt-4"><i class="fa fa-dashboard"></i> Dashboard</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6 rounded">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="ripple rounded">
                                        <div class="card-header fw-bold text-info bg-body-tertiary" style="font-size: 14px; background-color: #0b3d91"><i class="fa fa-network-wired"></i> {{ $page.props.auth.user.email }}</div>
                                        <div class="card-body py-0">
                                            <div class="row align-items-center justify-content-center w-100">
                                                <div class="col-4 p-1">
                                                    <img style="width: 65px; height: 65px" class="rounded rounded-2 border border-2 border-secondary" :src="`img/profile/${$page.props.auth.user.avatar}`" alt="">
                                                </div>
                                                <span style="font-size: 18px;" class="col-8 p-1 text-center text-info fw-bold"><i class="fa fa-user"></i> {{ $page.props.auth.user.nombre }}</span>
                                                <span style="font-size: 12px; color: #0b3d91" class="col-12 p-1 text-center fw-bold"><i class="fa fa-building-user"></i> {{ $page.props.auth.user.empresa.nombre }}</span>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #0b3d91">
                                            <a @click="router.get(`/usuario/perfil/${$page.props.auth.user.id}`)" class="small text-info stretched-link" href="#"><i class="fa fa-eye"></i> Ver Perfil ({{$page.props.auth.user.roles[0].name}})</a>
                                            <div class="small text-white"><i class="fas fa-angle-right text-primary"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="$page.props.auth.user.roles[0].permissions.filter(perm => perm.id === 5).length > 0" class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4 ripple ripple-surface-white">
                                    <div class="card-header fw-bold text-info bg-primary" style="font-size: 14px;"><i class="fa fa-users"></i> Usuarios Registrados - {{$page.props.cantUsers}}</div>
                                    <div class="card-body py-0">
                                        <div class="row align-items-center justify-content-center w-100">
                                            <div class="col-4 p-1 mx-2">
                                                <i style="font-size: 65px;color: #0b3d91" class="fa fa-users rounded rounded-2 w-100"></i>
                                            </div>
                                            <div class="col-8 row justify-content-center align-items-start">
                                                <span style="font-size: 12px" class="col-12 p-0 text-success fw-bold"><i class="fa fa-check"></i> Conectados: {{$page.props.conectados}}</span>
                                                <span style="font-size: 12px" class="col-12 p-0 text-danger fw-bold"><i class="fa fa-x"></i> Desconectados: {{$page.props.desconectados}}</span>
                                                <span style="font-size: 12px" class="col-12 p-0 text-secondary fw-bold"><i class="fa fa-user-slash"></i> No autenticado: {{$page.props.noAuth}}</span>
                                            </div>
                                            <span style="font-size: 12px;color: #0b3d91" class="col-12 p-1 text-center fw-bold"><i class="fa fa-clipboard-user"></i> Llenando Cuestionarios: {{$page.props.cuest}}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between bg-primary">
                                        <a @click="router.get(`/usuarios`)" class="small text-info stretched-link" href="#"><i class="fa fa-eye"></i> Ver Usuarios</a>
                                        <div class="small text-white"><i class="fas fa-angle-right text-info"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card text-white bg-info mb-4 ripple ripple-surface-white">
                                    <div class="card-header fw-bold text-info bg-primary" style="font-size: 14px;"><i class="fa fa-book-medical"></i> Solicitudes Registradas - {{$page.props.solArchivada + $page.props.solProceso}}</div>
                                    <div class="card-body py-0">
                                        <div class="row align-items-center justify-content-center w-100">
                                            <div class="col-4 p-1 mx-2">
                                                <i style="font-size: 65px;color: #0b3d91" class="fa fa-book-medical rounded rounded-2 w-100"></i>
                                            </div>
                                            <div class="col-8 row justify-content-center align-items-start">
                                                <span style="font-size: 12px" class="col-12 p-0 text-success fw-bold"><i class="fa fa-check"></i> Archivadas: {{$page.props.solArchivada}}</span>
                                                <span style="font-size: 12px" class="col-12 p-0 text-primary fw-bold"><i class="fa fa-info-circle"></i> En Proceso: {{$page.props.solProceso}}</span>
                                            </div>
                                            <span style="font-size: 12px;color: #0b3d91" class="col-12 p-1 text-center fw-bold"><i class="fa fa-clipboard-user"></i> Vouchers en Uso: {{$page.props.cuest}}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between bg-primary">
                                        <a @click="router.get(`/solicitudes`)" class="small text-info stretched-link" href="#"><i class="fa fa-eye"></i> Ver Solicitudes</a>
                                        <div class="small text-white"><i class="fas fa-angle-right text-info"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card text-white bg-info mb-4 ripple ripple-surface-white">
                                    <div class="card-header fw-bold text-info bg-primary" style="font-size: 14px;"><i class="fa fa-book-medical"></i> Cuestionarios Procesados - {{$page.props.cantUsers}}</div>
                                    <div class="card-body py-0">
                                        <div class="row align-items-center justify-content-center w-100">
                                            <div class="col-4 p-1 mx-2">
                                                <i style="font-size: 65px;color: #0b3d91" class="fa fa-clipboard-user rounded rounded-2 w-100"></i>
                                            </div>
                                            <div class="col-8 row justify-content-center align-items-start">
                                                <span style="font-size: 12px" class="col-12 p-0 text-success fw-bold"><i class="fa fa-check"></i> Aprovados: {{$page.props.cuestionariosAprob}}</span>
                                                <span style="font-size: 12px" class="col-12 p-0 text-danger fw-bold"><i class="fa fa-x"></i> Denegados: {{$page.props.cuestionariosDen}}</span>
                                            </div>
                                            <span style="font-size: 12px;color: #0b3d91" class="col-12 p-1 text-center fw-bold"><i class="fa fa-clipboard-user"></i> Pendientes a Revisión: {{$page.props.cuestionarios.length}}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between bg-primary">
                                        <a @click="router.get(`/cuestionarios`)" class="small text-info stretched-link" href="#"><i class="fa fa-eye"></i> Ver Cuestionarios</a>
                                        <div class="small text-white"><i class="fas fa-angle-right text-info"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-info">
                                        <i class="fas fa-file-medical-alt me-1"></i>
                                        Solicitudes en Proceso
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-hover table-striped table-responsive w-100">
                                            <thead>
                                            <tr>
                                                <th hidden>Id</th>
                                                <th>Empresa Solicitante</th>
                                                <th>Trabajadores</th>
                                                <th>Fecha</th>
                                                <th>Ver</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="sol in $page.props.solicitudes" :key="sol.id">
                                                <td hidden>{{ sol.id }}</td>
                                                <td style="width: 45%">
                                                    {{ sol.user.empresa.nombre }}
                                                </td>
                                                <td>
                                                    {{ sol.trabajadores }}
                                                </td>
                                                <td>
                                                    {{ sol.created_at }}
                                                </td>
                                                <td width="180px">
                                                    <button @click="router.get(`/solicitudes/${sol.id}`)" class="btn btn-info m-1 rounded-3" :id="sol.id" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Ver Solicitud ${sol.id}`"> <i  class="bi bi-eye fs-6"></i></button>
                                                </td>
                                            </tr>
                                            <tr v-if="$page.props.solicitudes.length === 0">
                                                <td colspan="4" class="text-center">No hay datos para mostrar</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-info">
                                        <i class="fas fa-clipboard-list me-1"></i>
                                        Cuestionarios Pendientes a Evaluación Médica
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-hover table-striped table-responsive w-100">
                                            <thead>
                                            <tr>
                                                <th hidden>Id</th>
                                                <th>Paciente</th>
                                                <th>Empresa</th>
                                                <th>Fecha</th>
                                                <th>Ver</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="cuest in $page.props.cuestionarios" :key="cuest.id">
                                                <td hidden>{{ cuest.id }}</td>
                                                <td style="width: 35%">
                                                    {{ cuest.data.datos_generales.nombre }}
                                                </td>
                                                <td>
                                                    {{ cuest.data.datos_generales.empresa }}
                                                </td>
                                                <td>
                                                    {{ cuest.created_at }}
                                                </td>
                                                <td>
                                                    <button v-if="$page.props.auth.user.roles[0].permissions.filter(perm => perm.id === 18).length > 0" @click="router.get(`/cuestionarios/${cuest.id}/edit`)" class="btn btn-info m-1 rounded-3" :id="cuest.id" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Evaluar Cuestionario ${cuest.id}`"> <i  class="fa fa-user-doctor fs-6"></i></button>
                                                    <button v-else @click="router.get(`/cuestionarios/${cuest.id}`)" class="btn btn-info m-1 rounded-3" :id="cuest.id" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Ver Cuestionario ${cuest.id}`"> <i  class="bi bi-eye fs-6"></i></button>
                                                </td>
                                            </tr>
                                            <tr v-if="$page.props.cuestionarios.length === 0">
                                                <td colspan="4" class="text-center">No hay datos para mostrar</td>
                                            </tr>
                                            </tbody>
                                        </table>
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

</style>
