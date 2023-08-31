<script setup>
import {onMounted, onUpdated, onBeforeUpdate, ref} from "vue";
import {router, Link, useForm} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import { genFileId } from 'element-plus'
import QRCodeVue3 from "qrcode-vue3";

const props = defineProps({
    solicitud: Object
});

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
let selectedQr = ref(null);
let modal = ref(null);
onMounted(()=>{
    const options = {
        backdrop: 'static'
    }
    const myModalEl = document.getElementById('staticBackdrop');
    modal.value = new bootstrap.Modal(myModalEl, options);

    toggleNavbar()
    $('#userTable').DataTable(dtConfig);

    document.addEventListener('DOMContentLoaded', ()=>{
        document.querySelectorAll('.btn-success').forEach(qr =>{
            qr.innerHTML = '<i class="bi bi-download fs-5"></i> Descargar Voucher QR';
        })
    })

});

const mostrarQr = (qr) => {
    selectedQr.value = qr;
    modal.value.show();
}

const ocultarQr = () => {
    selectedQr.value = null;
    modal.value.hide();
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
                                    <li class="breadcrumb-item active fw-bold"><Link href="/solicitudes"> <i class="fa fa-users"></i> Usuarios </Link></li>
                                    <li class="breadcrumb-item active fw-bold"><i class="fa fa-user-cog"></i>Solicitud (<Link :href="`/solicitudes/${props.solicitud.id}/edit`">Editar</Link>)</li>
                                </ol>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped w-100" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="w-25">Propiedades</th>
                                            <td class="fw-bold">Datos</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <th>Solicitante</th>
                                            <td>
                                                <div class="row justify-content-center align-items-center w-100">
                                                    <div class="col-lg-2 col-md-3">
                                                        <img class="rounded rounded-3 border border-2 border-primary w-100" :src="`/img/profile/${props.solicitud.user.avatar}`">
                                                    </div>
                                                    <div class="col-lg-10 col-md-9">
                                                        <div class="text-base fw-bold">{{ props.solicitud.user.nombre }}</div>
                                                        <div class="font-normal">{{ props.solicitud.user.email }}</div>
                                                        <div class="text-base fw-bold">{{ props.solicitud.user.empresa }}</div>
                                                        <div class="font-normal">{{ props.solicitud.user.cargo }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>2</th>
                                            <th>Trabajadores</th>
                                            <td>{{props.solicitud.trabajadores}}</td>
                                        </tr>
                                        <tr>
                                            <th>3</th>
                                            <th>Fecha Solicitud</th>
                                            <td>{{props.solicitud.created_at}}</td>
                                        </tr>
                                        <tr>
                                            <th>4</th>
                                            <th>Vouchers</th>
                                            <td>
                                                <div class="row justify-content-between align-items-center w-100">
                                                    <span v-for="voucher in props.solicitud.vouchers" @click="mostrarQr(voucher.voucher)" :class="`btn ${voucher.estado === 1 ? 'btn-outline-secondary' : ''} ${voucher.estado === 2 ? 'btn-outline-primary' : ''} ${voucher.estado === 3 ? 'btn-outline-success' : ''} rounded rounded-4 m-1 col-md-3`"  :key="voucher.id"><i :class="`fa ${voucher.estado === 1 ? 'fa-question-circle' : ''} ${voucher.estado === 2 ? 'fa-info-circle' : ''} ${voucher.estado === 3 ? 'fa-check-circle' : ''}`"></i> {{voucher.voucher}}</span>
                                                </div>
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
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa fa-qrcode"></i> Obtener Voucher QR</h1>
                    <button @click="ocultarQr" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="w-100" v-for="voucher in props.solicitud.vouchers" :hidden="voucher.voucher !== selectedQr">
                        <QRCodeVue3
                            :width="200"
                            :height="200"
                            :value="`${$page.props.appUrl}/cuestionarios/create/${voucher.voucher}`"
                            :qrOptions="{ typeNumber: 0, mode: 'Byte', errorCorrectionLevel: 'H' }"
                            :imageOptions="{ hideBackgroundDots: true, imageSize: 0.4, margin: 0 }"
                            :dotsOptions="{
                            type: 'dots',
                            color: '#26249a',
                            gradient: {
                              type: 'linear',
                              rotation: 0,
                              colorStops: [
                                { offset: 0, color: '#26249a' },
                                { offset: 1, color: '#26249a' },
                              ],
                            },
                            }"
                            :backgroundOptions="{ color: '#ffffff' }"
                            :cornersSquareOptions="{ type: 'dot', color: '#000000' }"
                            :cornersDotOptions="{ type: undefined, color: '#000000' }"
                            fileExt="png"
                            :download="true"
                            myclass="my-qur"
                            imgclass="img-qr w-100"
                            downloadButton="btn btn-success w-100"
                            :downloadOptions="{ name: voucher.voucher, extension: 'png', }"
                        />
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
