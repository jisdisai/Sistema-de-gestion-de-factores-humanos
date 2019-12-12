<?php
	class Fecha{
		private $FechaFormatoSql="";


		public function __construct(){
			setlocale(LC_ALL, "es_ES");
			date_default_timezone_set('America/Tegucigalpa');
			if(strcmp ("Sun" , date("D") ) == 0){
				$this->FechaFormatoNormal="Domingo";
			}
			else{
				if(strcmp ("Mon" , date("D") ) == 0){
					$this->FechaFormatoNormal="Lunes";
				}
				else{
					if(strcmp ("Tue" , date("D") ) == 0){
						$this->FechaFormatoNormal="Martes";
					}
					else{
						if(strcmp ("Wed" , date("D") ) == 0){
							$this->FechaFormatoNormal="Miércoles";
						}
						else{
							if(strcmp ("Thu" , date("D") ) == 0){
								$this->FechaFormatoNormal="Jueves";
							}
							else{
								if(strcmp ("Fri" , date("D") ) == 0){
									$this->FechaFormatoNormal="Viernes";
								}
								else{
									$this->FechaFormatoNormal="Sábado";
								}
							}
						}
					}
				}
			}
			$this->FechaFormatoNormal=$this->FechaFormatoNormal." ".date("d")." de ";
			if (strcmp ("01" , date("m") ) == 0){
				$this->FechaFormatoNormal=$this->FechaFormatoNormal."Enero del ".date("Y");
			}
			else{
				if (strcmp ("02" , date("m") ) == 0){
					$this->FechaFormatoNormal=$this->FechaFormatoNormal."Febrero del ".date("Y");
				}
				else{
					if (strcmp ("03" , date("m") ) == 0){
						$this->FechaFormatoNormal=$this->FechaFormatoNormal."Marzo del ".date("Y");
					}
					else{
						if (strcmp ("04" , date("m") ) == 0){
							$this->FechaFormatoNormal=$this->FechaFormatoNormal."Abril del ".date("Y");
						}
						else{
							if (strcmp ("05" , date("m") ) == 0){
								$this->FechaFormatoNormal=$this->FechaFormatoNormal."Mayo del ".date("Y");
							}
							else{
								if (strcmp ("06" , date("m") ) == 0){
									$this->FechaFormatoNormal=$this->FechaFormatoNormal."Junio del ".date("Y");
								}
								else{
									if (strcmp ("07" , date("m") ) == 0){
										$this->FechaFormatoNormal=$this->FechaFormatoNormal."Julio del ".date("Y");
									}
									else{
										if (strcmp ("08" , date("m") ) == 0){
											$this->FechaFormatoNormal=$this->FechaFormatoNormal."Agosto del ".date("Y");
										}
										else{
											if (strcmp ("09" , date("m") ) == 0){
												$this->FechaFormatoNormal=$this->FechaFormatoNormal."Septiembre del ".date("Y");
											}
											else{
												if (strcmp ("10" , date("m") ) == 0){
													$this->FechaFormatoNormal=$this->FechaFormatoNormal."Octubre del ".date("Y");
												}
												else{
													if (strcmp ("11" , date("m") ) == 0){
														$this->FechaFormatoNormal=$this->FechaFormatoNormal."Noviembre del ".date("Y");
													}
													else{
														$this->FechaFormatoNormal=$this->FechaFormatoNormal."Diciembre del ".date("Y");
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		public function obtenerFechaNormal(){
			return $this->FechaFormatoNormal;
		}
		public function obtenerFechaSql(){
			return date("Y")."-".date("m")."-".date("d");
		}

	}
?>