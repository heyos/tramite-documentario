<?php

require_once "conexion.php";

class TablaCustomModel{

	public static function mostrarTablaGeneralModel($where,$tabla){

		switch ($tabla) {
			case 'direccion':
				$sql = sprintf("SELECT d.id, d.cDirEnt, d.xNumDir, d.cPais,d.xTelEnt1, d.xTelEnt2, t.xvalor1 AS comuna, 
									p.xvalor1 AS pais,d.xEmail
								FROM direccion AS d
								JOIN tabla_logica t ON t.id_tbl = d.nIdComuna
								JOIN tabla_logica p ON p.id_tbl = d.cPais
								WHERE %s ",$where);
				break;
			case 'contacto_persona_juridica':
				$sql = sprintf("SELECT c.*,CONCAT(p.nRutPer,' | ',p.xNombre,' ',p.xApePat,' ',p.xApeMat) AS contacto
								FROM contacto_persona_juridica c
								JOIN persona p ON p.id = c.nIdPersona 
								WHERE %s ",$where);
				break;
			
			default:
				
				break;
		}

		$query = Conexion::conectar()->prepare($sql);

		$query -> execute();

        return $query -> fetchAll();

        $query -> close();

        $query = null;
	}

	public static function mostrarTablaFilterModel($datos,$tabla){

        $where = $datos["where"];
        $offset = $datos["offset"];
        $rowsPerPage = $datos["rowsPerPage"];

        $limit = sprintf(" LIMIT %d,%d ",$offset,$rowsPerPage);

        switch ($tabla) {
			case 'direccion':
				$sql = sprintf("SELECT d.id, d.cDirEnt, d.xNumDir, d.cPais,d.xTelEnt1, d.xTelEnt2, t.xValor1 as comuna,
								p.xValor1 AS pais,d.xEmail, d.xNomFaena
								FROM direccion AS d
								JOIN tabla_logica t ON t.id_tbl = d.nIdComuna
								JOIN tabla_logica p ON p.id_tbl = d.cPais
								WHERE %s %s",$where,$limit);
				break;
			case 'contacto_persona_juridica':
				$sql = sprintf("SELECT c.*,CONCAT(p.nRutPer,' | ',p.xNombre,' ',p.xApePat,' ',p.xApeMat) AS contacto,
								t.xValor1 as cargo
								FROM contacto_persona_juridica c
								JOIN persona p ON p.id = c.nIdPersona
								JOIN tabla_logica t ON t.id_tbl = c.cCargo
								WHERE %s %s",$where,$limit);
				break;	
			
			default:
				
				break;
		}

        $query = Conexion::conectar()->prepare($sql);

        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

        $query = null;

    }

    public static function mostrarDatosTablaMdl($tabla){

    	$extra = '%@TAB_X1@'.$tabla.'%';
    	$sql = sprintf("SELECT id_tbl,xvalor1 
						FROM tabla_logica 
						WHERE tipo = 'v' AND validar_campos LIKE '%s' ",$extra);
    	
    	$query = Conexion::conectar()->prepare($sql);

        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

        $query = null;
    }
}