<script setup>
import {onMounted, ref} from "vue";
import {router, Link, usePage} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";

const page = usePage();

defineProps({
    cuestionario: Object,
    empresas: Object
})

let dtConfig = {
    "order": [[ 0, 'asc' ]],
    columnDefs: [
        {
            target: 0,
            visible: false,
        },
    ],
    language: {
        url: `/api/datatables/es`
    },
    dom: 'lfrtip',
    select: true,
    lengthMenu: [
        [-1, 10, 25, 50, 100],
        ['Todo', '10 Filas', '25 Filas', '50 Filas', '100 Filas',]
    ],
}

onMounted(()=>{
    toggleNavbar()
    $('#cuestionarioTable').DataTable(dtConfig);
})

</script>

<template>
    <body class="sb-nav-fixed">
    <Navbar />
    <div id="layoutSidenav" class="vh-100">
        <Sidenav />
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><i class="fa fa-user-doctor"></i>Revisión de  Cuestionario</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/cuestionarios"><i class="fa fa-clipboard-check"></i> Cuestionarios</Link></li>
                                <li class="breadcrumb-item active fw-bold"><i class="fa fa-user-doctor"></i>Revisión de  Cuestionario - Paciente: {{ cuestionario.data.datos_generales.nombre }}</li>
                            </ol>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table w-100" id="cuestionarioTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>No</th>
                                        <th class="w-25">Propiedades</th>
                                        <td class="fw-bold">Datos</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-primary">
                                        <th>1</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-center w-100">Datos Generales</td>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <th>1</th>
                                        <th class="w-25">Nombre</th>
                                        <td><input class="form-control" type="text" :value="cuestionario.data.datos_generales.nombre"></td>
                                    </tr>
                                    <tr>
                                        <th>3</th>
                                        <th>2</th>
                                        <th>Fecha Nacimiento</th>
                                        <td><input class="form-control" type="date" :value="cuestionario.data.datos_generales.nacimiento"></td>
                                    </tr>
                                    <tr>
                                        <th>4</th>
                                        <th>3</th>
                                        <th>Edad</th>
                                        <td><input class="form-control" type="text" :value="cuestionario.data.datos_generales.edad"></td>
                                    </tr>
                                    <tr>
                                        <th>5</th>
                                        <th>4</th>
                                        <th>Sexo</th>
                                        <td>
                                            <select v-model="cuestionario.data.datos_generales.sexo" class="form-control form-select" name="" id="">
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>6</th>
                                        <th>5</th>
                                        <th>Ciudad de Origen</th>
                                        <td><input v-model="cuestionario.data.datos_generales.ciudad_origen" class="form-control" type="text"></td>
                                    </tr>
                                    <tr>
                                        <th>7</th>
                                        <th>6</th>
                                        <th>Empresa</th>
                                        <td>
                                            <select v-model="cuestionario.data.datos_generales.empresa" class="form-control form-select" name="" id="">
                                                <option v-for="empresa in empresas" :value="empresa.id">{{empresa.nombre}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>8</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-center w-100">Información de Contacto</td>
                                    </tr>
                                    <tr>
                                        <th>9</th>
                                        <th>7</th>
                                        <th>Teléfono</th>
                                        <td>{{ cuestionario.data.info_contacto.telefono }}</td>
                                    </tr>
                                    <tr>
                                        <th>10</th>
                                        <th>8</th>
                                        <th>Correo</th>
                                        <td>{{ cuestionario.data.info_contacto.correo }}</td>
                                    </tr>
                                    <tr>
                                        <th>11</th>
                                        <th>9</th>
                                        <th>Dirección</th>
                                        <td>{{ cuestionario.data.info_contacto.direccion }}</td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>12</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-center w-100">Signos Vitales</td>
                                    </tr>
                                    <tr>
                                        <th>13</th>
                                        <th>10</th>
                                        <th>Peso</th>
                                        <td>{{ cuestionario.data.signos_vitales.peso }}</td>
                                    </tr>
                                    <tr>
                                        <th>14</th>
                                        <th>11</th>
                                        <th>Estatura</th>
                                        <td>{{ cuestionario.data.signos_vitales.estatura }}</td>
                                    </tr>
                                    <tr>
                                        <th>15</th>
                                        <th>12</th>
                                        <th>Presión Sistólica</th>
                                        <td>{{ cuestionario.data.signos_vitales.p_sistolica }}</td>
                                    </tr>
                                    <tr>
                                        <th>16</th>
                                        <th>13</th>
                                        <th>Presión Diastólica</th>
                                        <td>{{ cuestionario.data.signos_vitales.p_diastolica }}</td>
                                    </tr>
                                    <tr>
                                        <th>17</th>
                                        <th>14</th>
                                        <th>Pulso</th>
                                        <td>{{ cuestionario.data.signos_vitales.pulso }}</td>
                                    </tr>
                                    <tr>
                                        <th>18</th>
                                        <th>15</th>
                                        <th>Temperatura</th>
                                        <td>{{ cuestionario.data.signos_vitales.temperatura }}</td>
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
