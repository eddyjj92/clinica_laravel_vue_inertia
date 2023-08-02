<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ConexionController extends Controller
{
    public $config;
    public $nameConection;

    public function __construct($database, $user, $password){

        $this->config = [
            'driver' => 'sqlsrv',
            'host' => 'localhost',
            'port' => '1433',
            'database' => $database,
            'username' => $user,
            'password' => $password,
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'encrypt' => true,
            'trust_server_certificate' => true,
        ];
        $this->nameConection = uniqid();
    }

    public function dataBases(){
        Config::set('database.connections.'.$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        return $con->table('sys.databases')->select('name')->get();
    }

    public function datosEmpresa(){
        Config::set('database.connections.'.$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        return $con->table('gen_empresa')->select('*')->first();
    }

    public function unidadContable(){
        Config::set('database.connections.'.$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        $sql = 'SELECT dbo.gen_unidadcontable.idunidad, dbo.gen_unidadcontable.codigo, dbo.gen_unidadcontable.nombre, dbo.gen_unidadcontable.Direccion, dbo.gen_unidadcontable.DirCorreo, dbo.gen_nae.clave AS NAE,
                       dbo.gen_dpa.clave AS DPA, dbo.gen_reup.clave AS REUP
                       FROM dbo.gen_unidadcontable LEFT OUTER JOIN
                       dbo.gen_reup ON dbo.gen_unidadcontable.idreup = dbo.gen_reup.idreup LEFT OUTER JOIN
                       dbo.gen_dpa ON dbo.gen_unidadcontable.iddpa = dbo.gen_dpa.iddpa LEFT OUTER JOIN
                       dbo.gen_nae ON dbo.gen_unidadcontable.idnae = dbo.gen_nae.idnae';
        return $con->select($sql);
    }

    public function ejercicios(){
        Config::set('database.connections.'.$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        $sql = 'SELECT * FROM gen_ejercicio';
        return $con->select($sql);
    }

    public function periodos($idEjercicio){
        Config::set('database.connections.'.$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        $sql = 'SELECT * FROM dbo.gen_periodo WHERE idejercicio = ? AND enuso = 1';
        return $con->select($sql,[$idEjercicio]);
    }

    public function saldosApertura($idEjercicio){
        $idEjercicio = $idEjercicio - 1;
        Config::set('database.connections.'.$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        $sql = 'SELECT fin FROM dbo.gen_ejercicio WHERE idejercicio = ?';
        $fecha = $con->select($sql,[$idEjercicio]);
        $sql2 = 'SELECT dbo.gen_unidadcontable.idunidad, LEFT(dbo.con_cuenta.clave, 3) AS Cta, SUM(dbo.con_pase.importe) AS SaldoCta  FROM
                        dbo.con_comprobante INNER JOIN dbo.con_comprobanteoperacion ON dbo.con_comprobante.idcomprobante = dbo.con_comprobanteoperacion.idcomprobante INNER JOIN
                        dbo.con_pase ON dbo.con_comprobante.idcomprobante = dbo.con_pase.idcomprobante INNER JOIN dbo.con_cuenta ON dbo.con_pase.idcuenta = dbo.con_cuenta.idcuenta INNER JOIN
                        dbo.gen_unidadcontable ON dbo.con_comprobante.idunidad = dbo.gen_unidadcontable.idunidad WHERE  (dbo.con_comprobanteoperacion.fecha <= CONVERT(DATETIME, ?, 102)) GROUP BY
                        dbo.gen_unidadcontable.idunidad, LEFT(dbo.con_cuenta.clave, 3)';
        return $con->select($sql2,[$fecha[0]->fin]);
    }

    public function saldosFechaActual($idPeriodo){
        Config::set('database.connections.'.$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        $sql = 'SELECT fin FROM dbo.gen_periodo WHERE idperiodo = ?';
        $fecha = $con->select($sql,[$idPeriodo]);
        $sql2 = 'SELECT gen_unidadcontable.idunidad, LEFT(con_cuenta.clave, 3) AS Cta, SUM(con_pase.importe) * con_cuentanat.naturaleza AS SaldoCta,con_cuentanat.naturaleza
                        FROM con_comprobante INNER JOIN con_comprobanteoperacion ON con_comprobante.idcomprobante = con_comprobanteoperacion.idcomprobante INNER JOIN
                        con_pase ON con_comprobante.idcomprobante = con_pase.idcomprobante INNER JOIN con_cuenta ON con_pase.idcuenta = con_cuenta.idcuenta INNER JOIN
                        gen_unidadcontable ON con_comprobante.idunidad = gen_unidadcontable.idunidad INNER JOIN con_cuentanat ON con_cuenta.idcuenta = con_cuentanat.idcuenta
                        WHERE (con_comprobanteoperacion.fecha <= CONVERT(DATETIME, ?, 102)) GROUP BY gen_unidadcontable.idunidad, LEFT(con_cuenta.clave, 3),con_cuentanat.naturaleza
                        ORDER BY Cta';
        return $con->select($sql2,[$fecha[0]->fin]);
    }

    public function saldosPln($idEjercicio){
        Config::set('database.connections.'.$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        $sql = 'SELECT dbo.gen_ejercicio.idejercicio, dbo.pln_Planes.idunidad, dbo.pln_version.idetapa, LEFT(dbo.con_cuenta.clave, 3) AS Cuenta, dbo.pln_version.oficial, dbo.pln_FilaBalance.total
                       FROM dbo.pln_version INNER JOIN dbo.pln_Planes ON dbo.pln_version.idversion = dbo.pln_Planes.idversion INNER JOIN dbo.pln_balance ON dbo.pln_Planes.idplan = dbo.pln_balance.idplan INNER JOIN
                       dbo.pln_FilaBalance ON dbo.pln_balance.idbalance = dbo.pln_FilaBalance.idbalance INNER JOIN dbo.pln_FilaBalCta ON dbo.pln_FilaBalance.idfilabalance = dbo.pln_FilaBalCta.idfilabalance INNER JOIN
                       dbo.con_cuenta ON dbo.pln_FilaBalCta.idcuenta = dbo.con_cuenta.idcuenta INNER JOIN dbo.gen_ejercicio ON dbo.pln_version.idejercicio = dbo.gen_ejercicio.idejercicio INNER JOIN
                       dbo.gen_periodo ON dbo.gen_ejercicio.idejercicio = dbo.gen_periodo.idejercicio WHERE (dbo.gen_ejercicio.idejercicio = ?)  AND (dbo.pln_version.idetapa = 2) AND (dbo.pln_version.oficial = 1)
                       GROUP BY dbo.gen_ejercicio.idejercicio, dbo.pln_Planes.idunidad, dbo.pln_version.idetapa, LEFT(dbo.con_cuenta.clave, 3), dbo.pln_version.oficial, dbo.pln_FilaBalance.total';
        return $con->select($sql,[$idEjercicio]);
    }

    public function saldosPlnFa($idEjercicio){
        Config::set("database.connections.".$this->nameConection, $this->config);
        $con = DB::connection($this->nameConection);
        $sql = " SELECT TOP (100) PERCENT dbo.gen_ejercicio.idejercicio, dbo.pln_Planes.idunidad, dbo.pln_version.idetapa, LEFT(dbo.con_cuenta.clave, 3) AS Cuenta, SUM(DISTINCT dbo.pln_FilaBalPeriodo.valor) AS SaldoPeriodo,
                        dbo.pln_version.oficial FROM dbo.pln_version INNER JOIN dbo.pln_Planes ON dbo.pln_version.idversion = dbo.pln_Planes.idversion INNER JOIN dbo.pln_balance ON dbo.pln_Planes.idplan = dbo.pln_balance.idplan INNER JOIN
                        dbo.pln_FilaBalance ON dbo.pln_balance.idbalance = dbo.pln_FilaBalance.idbalance INNER JOIN dbo.pln_FilaBalCta ON dbo.pln_FilaBalance.idfilabalance = dbo.pln_FilaBalCta.idfilabalance INNER JOIN
                        dbo.pln_FilaBalPeriodo ON dbo.pln_FilaBalCta.idfilabalance = dbo.pln_FilaBalPeriodo.idFilaBalance INNER JOIN dbo.con_cuenta ON dbo.pln_FilaBalCta.idcuenta = dbo.con_cuenta.idcuenta INNER JOIN
                        dbo.gen_ejercicio ON dbo.pln_version.idejercicio = dbo.gen_ejercicio.idejercicio INNER JOIN dbo.gen_periodo ON dbo.pln_FilaBalPeriodo.idperiodo = dbo.gen_periodo.idperiodo AND dbo.gen_ejercicio.idejercicio = dbo.gen_periodo.idejercicio
                        WHERE (dbo.gen_ejercicio.idejercicio = ?)  AND (dbo.pln_version.idetapa = 2) AND (dbo.pln_version.oficial = 1) AND (dbo.gen_periodo.fin <= CONVERT(DATETIME, '2022-12-31 00:00:00',102)) GROUP BY dbo.gen_ejercicio.idejercicio, dbo.pln_Planes.idunidad,
                                                                                                                                                                                                             dbo.pln_version.idetapa, LEFT(dbo.con_cuenta.clave, 3), dbo.pln_version.oficial ORDER BY Cuenta";
        return $con->select($sql,[$idEjercicio]);
    }

}
