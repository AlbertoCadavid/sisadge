<?php
/**
 * Clase Refleccion.
 * Nos permite extraer propidades de las clases.
 * @author 	dypweb.net
 * @link 	info@dypweb.net
 * @version 0.1 (25/08/2008)
 */
class Refleccion extends Reflection
{	
		private 	$clase;
		private 	$obj_clase;
		private 	$existeArchivo;
		private 	$propiedadClase		= array();
		private 	$propiedadMetodo	= array();
		
		public function __construct($ruta)
		{	Config::set("REFLECCION",$ruta);
			$this->existeArchivo	= @include_once(Config::get("REFLECCION"));
		}
	
		public function getPropiedadesClase($clase)
		{	$this->clase		= $clase;	
			if(!$this->existeArchivo)
			{	$this->propiedadClase["existeArchivo"]	= false;
				return false;
			}
			$this->obj_clase 	= new ReflectionClass($clase);
			$this->propiedadClase["existeArchivo"]	= $this->existeArchivo;
			$this->propiedadClase["rutaNombre"]		= $this->obj_clase;
			$this->propiedadClase["instanciable"]	= $this->obj_clase->isInstantiable();
			$this->propiedadClase["final"]			= $this->obj_clase->isFinal();
			$this->propiedadClase["abstracta"]		= $this->obj_clase->isAbstract();
			$this->propiedadClase["nombre"]			= $this->obj_clase->getName();
			return $this->propiedadClase;
		}

		public function getPropiedadesMetodos($metodo)
		{	if(!method_exists($this->clase,$metodo))
			{	$this->propiedadMetodo["existe"]	= false;
				return $this->propiedadMetodo;
			}
			$metodo = new ReflectionMethod($this->clase, $metodo);
			$this->propiedadMetodo["existe"]		= true;
			$this->propiedadMetodo["publico"]		= $metodo->isPublic();
			$this->propiedadMetodo["constructor"]	= $metodo->isConstructor();
			$this->propiedadMetodo["abstracto"]		= $metodo->isAbstract();
			return $this->propiedadMetodo;
		}
}

?>
