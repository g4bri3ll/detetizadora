<?php

class SalvaPDFContrato{
	
	function Salva($documento){
		
		// Pasta onde o arquivo vai ser salvo
		$_UP['pasta'] = 'arquivoPDF/contratos/';
		// Tamanho máximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
		// Array com as extensões permitidas
		$_UP['extensoes'] = array('pdf', 'PDF');
		// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
		$_UP['renomeia'] = false;
		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Nao foi feito o upload do arquivo';
		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($documento['error'] != 0) {
		  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$documento['error']]);
		  exit; // Para a execução do script
		}
		// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
		// Faz a verificação da extensão do arquivo
		$extensao = @end(explode('.', $documento['name']));
		if (array_search($extensao, $_UP['extensoes']) === false) {
		  echo "Por favor, envie arquivos com as seguintes extensões: pdf, PDF";
		  exit;
		}
		// Faz a verificação do tamanho do arquivo
		if ($_UP['tamanho'] < $documento['size']) {
		  echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
		  exit;
		}
		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
		// Primeiro verifica se deve trocar o nome do arquivo
		if ($_UP['renomeia'] == true) {
		  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
		  $nome_final = md5(time()).'.pdf';
		} else {
		  // Mantém o nome original do arquivo
		  $nome_final = $documento['name'];
		}
		  
		// Depois verifica se é possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($documento['tmp_name'], $_UP['pasta'] . $nome_final)) {
		  
			// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
		  	return $nome_final;
		  	//echo "Upload efetuado com sucesso!";
		  	//'<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
		  echo "Não foi possível enviar o arquivo, tente novamente";
		  return "erro";
		}
		
	}
	
}
?>