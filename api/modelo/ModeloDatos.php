<?php

/**
* 
*/
class ModeloDatos
{
	
	public function registrarDatosDecimal($obj)
	{
		$retorno = new stdClass();
		$retorno->id_usuario 	= $obj->id_usuario;	
		$retorno->iddispositivo = $obj->iddispositivo;	
		$retorno->id_toma 		= '';	

		$parametro = '';

		for ($i=0; $i < 260; $i++) { 
			if (isset($obj->parametro[$i])) {
				if ($i == 259 ) {
					$dato 		=  explode('_', $obj->parametro[$i]);
					$parametro .= "'".hexdec($dato[0])."',";
				} else {
					$parametro .= "'".hexdec($obj->parametro[$i])."',";
				}
				
			} else {
			$parametro .= "'0',";
				
			}
		}

		$parametro =  eliminaUltimocaracter($parametro);


		$sql =  "INSERT INTO toma_decimal (id_dispositivo, id_usuario, registro, calibracion, serie_bluetooth,BGND1,BGND2,BGND3,BGND4,BGND5,BGND6,BGND7,BGND8,BGND9,BGND10,BGND11,BGND12,BGND13,BGND14,BGND15,BGND16,BGND17,BGND18,BGND19,BGND20,G1,G2,G3,G4,G5,G6,G7,G8,G9,G10,G11,G12,G13,G14,G15,G16,G17,G18,G19,G20,R1,R2,R3,R4,R5,R6,R7,R8,R9,R10,R11,R12,R13,R14,R15,R16,R17,R18,R19,R20,IR1,IR2,IR3,IR4,IR5,IR6,IR7,IR8,IR9,IR10,IR11,IR12,IR13,IR14,IR15,IR16,IR17,IR18,IR19,IR20,NIR1D1,NIR1D2,NIR1D3,NIR1D4,NIR1D5,NIR1D6,NIR1D7,NIR1D8,NIR1D9,NIR1D10,NIR1D11,NIR1D12,NIR1D13,NIR1D14,NIR1D15,NIR1D16,NIR1D17,NIR1D18,NIR1D19,NIR1D20,NIR1M1,NIR1M2,NIR1M3,NIR1M4,NIR1M5,NIR1M6,NIR1M7,NIR1M8,NIR1M9,NIR1M10,NIR1M11,NIR1M12,NIR1M13,NIR1M14,NIR1M15,NIR1M16,NIR1M17,NIR1M18,NIR1M19,NIR1M20,NIR1U1,NIR1U2,NIR1U3,NIR1U4,NIR1U5,NIR1U6,NIR1U7,NIR1U8,NIR1U9,NIR1U10,NIR1U11,NIR1U12,NIR1U13,NIR1U14,NIR1U15,NIR1U16,NIR1U17,NIR1U18,NIR1U19,NIR1U20,NIR2D1,NIR2D2,NIR2D3,NIR2D4,NIR2D5,NIR2D6,NIR2D7,NIR2D8,NIR2D9,NIR2D10,NIR2D11,NIR2D12,NIR2D13,NIR2D14,NIR2D15,NIR2D16,NIR2D17,NIR2D18,NIR2D19,NIR2D20,NIR2M1,NIR2M2,NIR2M3,NIR2M4,NIR2M5,NIR2M6,NIR2M7,NIR2M8,NIR2M9,NIR2M10,NIR2M11,NIR2M12,NIR2M13,NIR2M14,NIR2M15,NIR2M16,NIR2M17,NIR2M18,NIR2M19,NIR2M20,NIR2U1,NIR2U2,NIR2U3,NIR2U4,NIR2U5,NIR2U6,NIR2U7,NIR2U8,NIR2U9,NIR2U10,NIR2U11,NIR2U12,NIR2U13,NIR2U14,NIR2U15,NIR2U16,NIR2U17,NIR2U18,NIR2U19,NIR2U20,NIR3D1,NIR3D2,NIR3D3,NIR3D4,NIR3D5,NIR3D6,NIR3D7,NIR3D8,NIR3D9,NIR3D10,NIR3D11,NIR3D12,NIR3D13,NIR3D14,NIR3D15,NIR3D16,NIR3D17,NIR3D18,NIR3D19,NIR3D20,NIR3M1,NIR3M2,NIR3M3,NIR3M4,NIR3M5,NIR3M6,NIR3M7,NIR3M8,NIR3M9,NIR3M10,NIR3M11,NIR3M12,NIR3M13,NIR3M14,NIR3M15,NIR3M16,NIR3M17,NIR3M18,NIR3M19,NIR3M20,NIR3U1,NIR3U2,NIR3U3,NIR3U4,NIR3U5,NIR3U6,NIR3U7,NIR3U8,NIR3U9,NIR3U10,NIR3U11,NIR3U12,NIR3U13,NIR3U14,NIR3U15,NIR3U16,NIR3U17,NIR3U18,NIR3U19,NIR3U20) VALUES('".$obj->iddispositivo."', '".$obj->id_usuario."', '".$obj->registro."', '".$obj->calibracion."', '".$obj->serie_bluetooth."', $parametro )"; 

			$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);

			//return $sql;
                        $valor = '';


			$respuesta 				= $this->extraerRegistrosPaciente($obj);
			$total = count($respuesta);

				if ($total == 2) {
					foreach ($respuesta as $indice => $parametros) :
						 switch ($indice) {
						 	case 0:
						 		$retorno->id_toma = $parametros->id_toma;
						 		$primer_registro = $parametros;
						 	break;
							
						 	case 1:
						 		$ultimo_registro = $parametros;
							break;					
							
						}
						
					endforeach;

					$post = [
					// 'pe_reg' => 50,
					// 'ul_reg' => 100,
					'pe_reg' => $primer_registro,
					'ul_reg' => $ultimo_registro,
					];
					$valor  = 'OK';
					if (isset($obj->calibracion) && empty($obj->calibracion)) {
						

					$json 			= json_encode($post);
					$ch 			= curl_init($obj->web_service);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
					$response 		= curl_exec($ch);
					curl_close($ch);
					//$respuesta_ws = $response;

					$respuesta_ws = json_decode($response);
					$respuesta_ws = json_decode($respuesta_ws,2);

					$valor = $respuesta_ws['glucosa'];
					//$valor = "91";
					$retorno->glucosa 	= $valor;
					if ($valor == 'Er' || $valor = '') {
						//$this->DeleteGlucosa($retorno);
					}else{
						$this->updateGlucosa($retorno);
					}
					}
					


				}
                                return $retorno->glucosa;
	}

	public function DeleteGlucosa($obj)
	{
		$sql = "DELETE FROM toma_decimal WHERE id_toma	= '".$obj->id_toma."'";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_DELETE);
	}

	public function updateGlucosa($obj)
	{
		$sql = "UPDATE toma_decimal SET glucosa = '".$obj->glucosa."' 
				WHERE id_usuario = '".$obj->id_usuario."' 
				AND id_dispositivo= '".$obj->iddispositivo."'
				AND id_toma	= '".$obj->id_toma."'";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_UPDATE);
	}


	public function  registrarDatos($obj)
	{
		$parametro = '';

		for ($i=0; $i < 300; $i++) { 
			if (isset($obj->parametro[$i])) {
			if ($i == 259 ) {
					$dato 		=  explode('_', $obj->parametro[$i]);
					$parametro .= "'".$dato[0]."',";
				} else {
					$parametro .= "'".$obj->parametro[$i]."',";
				}
				
			} else {
			$parametro .= "'0',";
				
			}
		}

		$parametro =  eliminaUltimocaracter($parametro);


		$sql =  "INSERT INTO toma (id_dispositivo, id_usuario, registro, parametro_001, parametro_002, parametro_003, parametro_004, parametro_005, parametro_006, parametro_007, parametro_008, parametro_009, parametro_010, parametro_011, parametro_012, parametro_013, parametro_014, parametro_015, parametro_016, parametro_017, parametro_018, parametro_019, parametro_020, parametro_021, parametro_022, parametro_023, parametro_024, parametro_025, parametro_026, parametro_027, parametro_028, parametro_029, parametro_030, parametro_031, parametro_032, parametro_033, parametro_034, parametro_035, parametro_036, parametro_037, parametro_038, parametro_039, parametro_040, parametro_041, parametro_042, parametro_043, parametro_044, parametro_045, parametro_046, parametro_047, parametro_048, parametro_049, parametro_050, parametro_051, parametro_052, parametro_053, parametro_054, parametro_055, parametro_056, parametro_057, parametro_058, parametro_059, parametro_060, parametro_061, parametro_062, parametro_063, parametro_064, parametro_065, parametro_066, parametro_067, parametro_068, parametro_069, parametro_070, parametro_071, parametro_072, parametro_073, parametro_074, parametro_075, parametro_076, parametro_077, parametro_078, parametro_079, parametro_080, parametro_081, parametro_082, parametro_083, parametro_084, parametro_085, parametro_086, parametro_087, parametro_088, parametro_089, parametro_090, parametro_091, parametro_092, parametro_093, parametro_094, parametro_095, parametro_096, parametro_097, parametro_098, parametro_099, parametro_100, parametro_101, parametro_102, parametro_103, parametro_104, parametro_105, parametro_106, parametro_107, parametro_108, parametro_109, parametro_110, parametro_111, parametro_112, parametro_113, parametro_114, parametro_115, parametro_116, parametro_117, parametro_118, parametro_119, parametro_120, parametro_121, parametro_122, parametro_123, parametro_124, parametro_125, parametro_126, parametro_127, parametro_128, parametro_129, parametro_130, parametro_131, parametro_132, parametro_133, parametro_134, parametro_135, parametro_136, parametro_137, parametro_138, parametro_139, parametro_140, parametro_141, parametro_142, parametro_143, parametro_144, parametro_145, parametro_146, parametro_147, parametro_148, parametro_149, parametro_150, parametro_151, parametro_152, parametro_153, parametro_154, parametro_155, parametro_156, parametro_157, parametro_158, parametro_159, parametro_160, parametro_161, parametro_162, parametro_163, parametro_164, parametro_165, parametro_166, parametro_167, parametro_168, parametro_169, parametro_170, parametro_171, parametro_172, parametro_173, parametro_174, parametro_175, parametro_176, parametro_177, parametro_178, parametro_179, parametro_180, parametro_181, parametro_182, parametro_183, parametro_184, parametro_185, parametro_186, parametro_187, parametro_188, parametro_189, parametro_190, parametro_191, parametro_192, parametro_193, parametro_194, parametro_195, parametro_196, parametro_197, parametro_198, parametro_199, parametro_200, parametro_201, parametro_202, parametro_203, parametro_204, parametro_205, parametro_206, parametro_207, parametro_208, parametro_209, parametro_210, parametro_211, parametro_212, parametro_213, parametro_214, parametro_215, parametro_216, parametro_217, parametro_218, parametro_219, parametro_220, parametro_221, parametro_222, parametro_223, parametro_224, parametro_225, parametro_226, parametro_227, parametro_228, parametro_229, parametro_230, parametro_231, parametro_232, parametro_233, parametro_234, parametro_235, parametro_236, parametro_237, parametro_238, parametro_239, parametro_240, parametro_241, parametro_242, parametro_243, parametro_244, parametro_245, parametro_246, parametro_247, parametro_248, parametro_249, parametro_250, parametro_251, parametro_252, parametro_253, parametro_254, parametro_255, parametro_256, parametro_257, parametro_258, parametro_259, parametro_260, parametro_261, parametro_262, parametro_263, parametro_264, parametro_265, parametro_266, parametro_267, parametro_268, parametro_269, parametro_270, parametro_271, parametro_272, parametro_273, parametro_274, parametro_275, parametro_276, parametro_277, parametro_278, parametro_279, parametro_280, parametro_281, parametro_282, parametro_283, parametro_284, parametro_285, parametro_286, parametro_287, parametro_288, parametro_289, parametro_290, parametro_291, parametro_292, parametro_293, parametro_294, parametro_295, parametro_296, parametro_297, parametro_298, parametro_299, parametro_300) VALUES('".$obj->iddispositivo."', '".$obj->id_usuario."', '".$obj->registro."', $parametro )"; 

			$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);
	}

	public function extraerRegistrosPaciente($obj)
	{
		
		$sql = "SELECT * FROM toma_decimal 
				WHERE id_usuario = '$obj->id_usuario' 
				AND id_dispositivo = '$obj->iddispositivo' ORDER BY id_toma DESC LIMIT 2";
		$data = ModeloConexion::ejecutar($sql, DB_NAME, DB_SELECT);

		return $data['LISTA'];
	}

	public function actualizarParametro($obj)
	{
		$sql = "UPDATE resultado_toma set resultado = '$obj->valor' WHERE id_resultado >11";
		$data = ModeloConexion::ejecutar($sql, DB_NAME, DB_UPDATE);

	}

	public function resultadoMuestra()
	{
		$sql = "SELECT resultado FROM resultado_toma ORDER BY id_resultado DESC LIMIT 1 ";
		$data = ModeloConexion::ejecutar($sql, DB_NAME, DB_SELECT);

		$resultado =  $data['LISTA'][0]->resultado;
		return $resultado;
	}
}
?>