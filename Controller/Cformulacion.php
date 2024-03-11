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
         
        $this->modelos=$modelos->Obtener("tbl_formulacion "," * "," WHERE proceso='".$_REQUEST['proceso']."' AND material='".$_REQUEST['material']."'" );
           /* echo '<pre>';
              var_dump($this->modelos);die;*/

        self::Formulaview(); 
    }
 
    public function llenarEditar(){  
        $this->modelos =  new oFormulacion();
        $this->modelos_editar =  new oFormulacion();
        $id_for=$_REQUEST['id_for']; 
        
        $modelos = new oFormulacion();
        $modelos_editar = new oFormulacion(); 
        $this->modelos=$modelos->Obtener("tbl_formulacion "," * ", " WHERE proceso='".$_REQUEST['proceso']."' AND material='".$_REQUEST['material']."'" );
        if($id_for!=''){
           $this->modelos_editar=$modelos_editar->camposEditar("tbl_formulacion "," * "," WHERE id_for=$id_for " ); 
         }
       
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
      
        $this->modelos->Registrar("tbl_formulacion", "nombre,formulacion,proceso,material", $_REQUEST);  
        
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
