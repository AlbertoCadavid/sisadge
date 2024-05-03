<?php
//Llamada al modelo
require_once("Models/Mformulacion.php");  
class CformulacionController{
 
    private $insumo;
    private $modelos;
    private $modelos_editar;

	public function __CONSTRUCT(){
		$modelos = new oFormulacion();
    }

    public function Index(){ 
    	$modelos = new oFormulacion();//instanciamos la clase oFormulacion del Modelo CFormulacion
    	self::Formulaview();
    }
 
    public function Proforma(){  
        $insumo = new oFormulacion(); 
        $modelos = new oFormulacion();  
        self::Formulaview();
    }


    public function Menu(){ 
        $insumo = new oFormulacion();
        $vista = 'view_formulacion.php';
        self::Formulaview($vista);
    }


    public function Inicio(){
        $modelos = new oFormulacion();
        $maquinas = new oFormulacion(); 
         
        $this->modelos=$modelos->Obtener("tbl_formulacion "," * "," WHERE proceso='".$_REQUEST['proceso']."' AND material='".$_REQUEST['material']."'" );
       
           $this->row_mezcla=$modelos->ObtenerColumn('tbl_produccion_mezclas',"int_cod_ref_pm","*","".$_REQUEST['nombre']."", " and  id_proceso=1 ORDER BY id_pm DESC");
                
           $this->row_materia_prima=$modelos->get_materiaPrima('insumo'," WHERE clase_insumo='4'  AND estado_insumo='0' "," ORDER BY descripcion_insumo ASC" );
             
           $this->maquinas = $maquinas->get_Maquina(); 

             
        self::Formulaview(); 
    }
 
    public function llenarEditar(){  
        $this->modelos =  new oFormulacion();
        $this->modelos_editar =  new oFormulacion();
        $id_for=$_REQUEST['id_for']; 
        
        $modelos = new oFormulacion();
        $modelos_editar = new oFormulacion();
        $modelos_mezcla = new oFormulacion(); 
        $maquinas = new oFormulacion(); 

        $this->modelos=$modelos->Obtener("tbl_formulacion "," * ", " WHERE proceso='".$_REQUEST['proceso']."' AND material='".$_REQUEST['material']."'" );
        if($id_for!=''){
           $this->modelos_editar=$modelos_editar->camposEditar("tbl_formulacion "," * "," WHERE id_for=$id_for " );

            $idnombre = $this->modelos_editar['nombre']; 
            $this->row_mezcla=$modelos_mezcla->ObtenerColumn('tbl_produccion_mezclas',"int_cod_ref_pm","*","$idnombre", " and id_proceso=1 ORDER BY id_pm DESC");  
         }

         $this->row_materia_prima=$modelos->get_materiaPrima('insumo'," WHERE clase_insumo='4'  AND estado_insumo='0' "," ORDER BY descripcion_insumo ASC" );
           
         $this->maquinas = $maquinas->get_Maquina(); 
       
        self::Formulaview(); 
   
    }

    public function Editar(){  
        $this->modelos =  new oFormulacion();
        $this->modelos_editar =  new oFormulacion();
        $id_for=$_REQUEST['id_for'];  
        
        $modelos = new oFormulacion();
        $modelos_editar = new oFormulacion(); 
        $this->modelos=$modelos->Obtener("tbl_formulacion "," * ", " WHERE proceso='".$_REQUEST['proceso']."' AND material='".$_REQUEST['material']."'" );
        if($_REQUEST['MM_update']=='form2' ){
             
          $this->modelos_editar=$modelos_editar->Update("UPDATE tbl_formulacion SET nombre='".$_REQUEST['nombre']."',formulacion='".$_REQUEST['formulacion']."',proceso='".$_REQUEST['proceso']."',material='".$_REQUEST['material']."' WHERE id_for=$id_for ");

         header("Location:view_index.php?c=cformulacion&a=Inicio&proceso=".$_REQUEST['proceso']."&material=".$_REQUEST['material'].""); 

        }
    
    }
 

    public function Guardar($vista=''){
  
    	$this->modelos =  new oFormulacion();

         $this->mezclas =  new oFormulacion(); 
         $this->proforma = $_REQUEST; 
 
        $nombre =  $_POST['int_cod_ref_pm']=='' ? $_POST['nombre'] : $_POST['int_cod_ref_pm'];

        $this->modelos->Registrar("tbl_formulacion", "nombre,formulacion,proceso,material", $_REQUEST); 
        
         $this->mezclas->RegistrarFormula("tbl_produccion_mezclas", "id_proceso,fecha_registro_pm,str_registro_pm,id_ref_pm,int_cod_ref_pm,version_ref_pm,int_ref1_tol1_pm,int_ref1_tol1_porc1_pm,int_ref2_tol1_pm,int_ref2_tol1_porc2_pm,int_ref3_tol1_pm,int_ref3_tol1_porc3_pm,int_ref1_tol2_pm,int_ref1_tol2_porc1_pm,int_ref2_tol2_pm,int_ref2_tol2_porc2_pm,int_ref3_tol2_pm,int_ref3_tol2_porc3_pm,int_ref1_tol3_pm,int_ref1_tol3_porc1_pm,int_ref2_tol3_pm,int_ref2_tol3_porc2_pm,int_ref3_tol3_pm,int_ref3_tol3_porc3_pm,int_ref1_tol4_pm,int_ref1_tol4_porc1_pm,int_ref2_tol4_pm,int_ref2_tol4_porc2_pm,int_ref3_tol4_pm,int_ref3_tol4_porc3_pm,int_ref1_rpm_pm,int_ref1_tol5_porc1_pm,int_ref2_rpm_pm,int_ref2_tol5_porc2_pm,int_ref3_rpm_pm,int_ref3_tol5_porc3_pm,extrusora_mp,observ_pm,b_borrado_pm", "int_cod_ref_pm",$nombre,  $this->proforma);

         $this->mezclas->RegistrarFormulaHistorico("tbl_produccion_mezclas_historico", "id_proceso,fecha_registro_pm,str_registro_pm,id_ref_pm,int_cod_ref_pm,version_ref_pm,int_ref1_tol1_pm,int_ref1_tol1_porc1_pm,int_ref2_tol1_pm,int_ref2_tol1_porc2_pm,int_ref3_tol1_pm,int_ref3_tol1_porc3_pm,int_ref1_tol2_pm,int_ref1_tol2_porc1_pm,int_ref2_tol2_pm,int_ref2_tol2_porc2_pm,int_ref3_tol2_pm,int_ref3_tol2_porc3_pm,int_ref1_tol3_pm,int_ref1_tol3_porc1_pm,int_ref2_tol3_pm,int_ref2_tol3_porc2_pm,int_ref3_tol3_pm,int_ref3_tol3_porc3_pm,int_ref1_tol4_pm,int_ref1_tol4_porc1_pm,int_ref2_tol4_pm,int_ref2_tol4_porc2_pm,int_ref3_tol4_pm,int_ref3_tol4_porc3_pm,int_ref1_rpm_pm,int_ref1_tol5_porc1_pm,int_ref2_rpm_pm,int_ref2_tol5_porc2_pm,int_ref3_rpm_pm,int_ref3_tol5_porc3_pm,extrusora_mp,observ_pm,b_borrado_pm", "int_cod_ref_pm",$nombre,  $this->proforma);  

        header("Location:view_index.php?c=cformulacion&a=Inicio&proceso=".$_REQUEST['proceso']."&material=".$_REQUEST['material'].""); 
    }

    public function Eliminar(){
           
 
             $this->modelos =  new oFormulacion(); 
            if($_REQUEST['id']!=''){
            
              $this->modelos->Delete("tbl_formulacion","id_for", $_REQUEST['id']); 

            }
             
            header("Location:view_index.php?c=cformulacion&a=Inicio&proceso=".$_REQUEST['proceso']."&material=".$_REQUEST['material'].""); 
            //header("Location:view_index.php?c=compras&a=Crud&columna=". $_REQUEST['columna'] ."&id=". $_REQUEST['id'] ." ");  
    }
 
    public function Formulaview($vista=''){ 
        if($vista){ 
          require_once("views/".$vista);  //header('Location:'.$vista);  
        }
        else{
    	  require_once("views/view_formulacion.php");
        }
    }
 


}



?>
