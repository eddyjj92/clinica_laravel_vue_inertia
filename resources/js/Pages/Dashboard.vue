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
        <Navbar :search="search" @search="result => buscar(result)"/>
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
                                    <div class="ripple rounded ">
                                        <div class="card-body">Primary Card</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="#">View Details</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4 ripple ripple-surface-white">
                                    <div class="card-body">Warning Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4 ripple ripple-surface-white">
                                    <div class="card-body">Success Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4 ripple ripple-surface-white">
                                    <div class="card-body">Danger Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">

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
