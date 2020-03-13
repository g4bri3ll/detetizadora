<?php 
include_once 'Model/DAO/ContratoDAO.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<!-- Bootstrap Core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="dist/css/sb-admin-2.css" rel="stylesheet">

</head>
<body>


<?php if (!empty($_GET['RelatoriosOrdemVistoria'])){ ?>

	<div class="row"><br><br>
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<form action="RelatoriosOrdemVistoria.php" method="post">
				<div class="panel panel-green">
					<div class="panel-heading">Relatorio de ordem de vistoria
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Informe uma data</label> 
							<input type="date" class="form-control" name="data" />
						</div>
						<div class="form-group">
							<label>Informe o contrato</label> 
							<select id="" class="form-control" name="idContrato">
                                <option value="0"></option>
                                <?php 
                                $conDAO = new ContratoDAO();
                                $arrayContrato = $conDAO->ListaContrato();
                                foreach ($arrayContrato as $conDAO => $c){
                                ?>
                                   <option value="<?php echo $c['id']; ?>"><?php echo $c['nome_contrato']; ?></option>
                                <?php } ?>
                           </select>
					   </div>
					</div>
					<div class="panel-footer">
						<input type="submit" class="btn btn-default" value="relatorio"> <a
							href="index.php" class="btn btn-default">Volta</a>
					</div>
				</div>
			</form>
			<!-- /.col-lg-4 -->
		</div>
		<div class="col-lg-2"></div>
	</div>
<?php } else ?>


<?php if (!empty($_GET['RelatorioOrdemServicoParaPrograma'])){ ?>

	<div class="row"><br><br>
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<form action="RelatorioOrdemServicoParaPrograma.php" method="post">
			<!-- 
			Form valido para gerar na pagina certa
			<form action="RelatorioOrdemServicoParaPrograma.php" method="post">
			
			 -->
				<div class="panel panel-green">
					<div class="panel-heading">Relatorio de ordem de servico por programa</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Informe uma data</label> 
							<input type="date" class="form-control" name="data" />
						</div>
						<div class="form-group">
							<label>Informe o contrato</label> 
							<select id="" class="form-control" name="idContrato">
                                <option value="0"></option>
                                <?php 
                                $conDAO = new ContratoDAO();
                                $arrayContrato = $conDAO->ListaContrato();
                                foreach ($arrayContrato as $conDAO => $c){
                                ?>
                                   <option value="<?php echo $c['id']; ?>"><?php echo $c['nome_contrato']; ?></option>
                                <?php } ?>
                           </select>
					   </div>
					</div>
					<div class="panel-footer">
						<input type="submit" class="btn btn-default" value="relatorio"> 
						<a href="index.php" class="btn btn-default">Volta</a>
					</div>
				</div>
			</form>
			<!-- /.col-lg-8 -->
		</div>
		<div class="col-lg-2"></div>
	</div>
<?php } else ?>


<?php if (!empty($_GET['RelatorioControlePraga'])){ ?>

	<div class="row"><br><br>
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
				<form action="RelatorioControlePraga.php" method="post">
					<div class="panel panel-green">
					<div class="panel-heading">Relatorio de controle de pragas</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Informe o contrato</label> 
							<select id="" class="form-control" name="idContrato">
	                               <option value="0"></option>
	                               <?php 
	                               $conDAO = new ContratoDAO();
	                               $arrayContrato = $conDAO->ListaContrato();
	                               foreach ($arrayContrato as $conDAO => $c){
	                               ?>
	                                  <option value="<?php echo $c['id']; ?>"><?php echo $c['nome_contrato']; ?></option>
	                               <?php } ?>
	                        </select>
					   </div>
					   
					</div>
					<div class="panel-footer">
						<input type="submit" class="btn btn-default" value="relatorio"> 
						<a href="index.php" class="btn btn-default">Volta</a>
					</div>
					</div>
				</form>
			<!-- /.col-lg-4 -->
		</div>
		<div class="col-lg-2"></div>
	</div>
<?php } else ?>


<?php if (!empty($_GET['RelatorioOrdemServicoComArmadilhaCliente'])){ ?>

	<div class="row"><br><br>
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
				<form action="RelatorioOrdemServicoComArmadilhaCliente.php" method="post">
					<div class="panel panel-green">
						<div class="panel-heading">Relatorio de ordem de servico com armadilha cliente</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Informe uma data</label> 
								<input type="date" class="form-control" name="data" />
							</div>
							<div class="form-group">
								<label>Informe o contrato</label> 
								<select id="" class="form-control" name="idContrato">
	                                <option value="0"></option>
	                                <?php 
	                                $conDAO = new ContratoDAO();
	                                $arrayContrato = $conDAO->ListaContrato();
	                                foreach ($arrayContrato as $conDAO => $c){
	                                ?>
	                                   <option value="<?php echo $c['id']; ?>"><?php echo $c['nome_contrato']; ?></option>
	                                <?php } ?>
	                           </select>
						   </div>
						</div>
						<div class="panel-footer">
							<input type="submit" class="btn btn-default" value="relatorio"> <a
								href="index.php" class="btn btn-default">Volta</a>
						</div>
					</div>
				</form>
			</div>
		<!-- /.col-lg-4 -->
		<div class="col-lg-2"></div>
	</div>
<?php } else ?>

<?php if (!empty($_GET['RelatorioOrdemServicoComArmadilhaFuncionario'])){ ?>

	<div class="row"><br><br>
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
				<form action="RelatorioOrdemServicoComArmadilhaFuncionario.php" method="post">
					<div class="panel panel-green">
						<div class="panel-heading">Relatorio de ordem de servico com armadilha funcionario</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Informe uma data</label> 
								<input type="date" class="form-control" name="data" />
							</div>
							<div class="form-group">
								<label>Informe o contrato</label> 
								<select id="" class="form-control" name="idContrato">
	                                <option value="0"></option>
	                                <?php 
	                                $conDAO = new ContratoDAO();
	                                $arrayContrato = $conDAO->ListaContrato();
	                                foreach ($arrayContrato as $conDAO => $c){
	                                ?>
	                                   <option value="<?php echo $c['id']; ?>"><?php echo $c['nome_contrato']; ?></option>
	                                <?php } ?>
	                           </select>
						   </div>
						</div>
						<div class="panel-footer">
							<input type="submit" class="btn btn-default" value="relatorio"> <a
								href="index.php" class="btn btn-default">Volta</a>
						</div>
					</div>
				</form>
			</div>
		<!-- /.col-lg-4 -->
		<div class="col-lg-2"></div>
	</div>
<?php } else ?>

<?php if (!empty($_GET['RelatorioModeloOrdemServicoFuncionario'])){ ?>

	<div class="row"><br><br>
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
				<form action="RelatorioModeloOrdemServicoFuncionario.php" method="post">
					<div class="panel panel-green">
						<div class="panel-heading">Relatorio de ordem de servico funcionario</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Informe uma data</label> 
								<input type="date" class="form-control" name="data" />
							</div>
							<div class="form-group">
								<label>Informe o contrato</label> 
								<select id="" class="form-control" name="idContrato">
	                                <option value="0"></option>
	                                <?php 
	                                $conDAO = new ContratoDAO();
	                                $arrayContrato = $conDAO->ListaContrato();
	                                foreach ($arrayContrato as $conDAO => $c){
	                                ?>
	                                   <option value="<?php echo $c['id']; ?>"><?php echo $c['nome_contrato']; ?></option>
	                                <?php } ?>
	                           </select>
						   </div>
						</div>
						<div class="panel-footer">
							<input type="submit" class="btn btn-default" value="relatorio"> <a
								href="index.php" class="btn btn-default">Volta</a>
						</div>
					</div>
				</form>
			</div>
		<!-- /.col-lg-4 -->
		<div class="col-lg-2"></div>
	</div>
<?php } else ?>

<?php if (!empty($_GET['RelatorioModeloOrdemServicoCliente'])){ ?>

	<div class="row"><br><br>
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
				<form action="RelatorioModeloOrdemServicoCliente.php" method="post">
					<div class="panel panel-green">
						<div class="panel-heading">Relatorio de ordem de servico cliente</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Informe uma data</label> 
								<input type="date" class="form-control" name="data" />
							</div>
							<div class="form-group">
								<label>Informe o contrato</label> 
								<select id="" class="form-control" name="idContrato">
	                                <option value="0"></option>
	                                <?php 
	                                $conDAO = new ContratoDAO();
	                                $arrayContrato = $conDAO->ListaContrato();
	                                foreach ($arrayContrato as $conDAO => $c){
	                                ?>
	                                   <option value="<?php echo $c['id']; ?>"><?php echo $c['nome_contrato']; ?></option>
	                                <?php } ?>
	                           </select>
						   </div>
						</div>
						<div class="panel-footer">
							<input type="submit" class="btn btn-default" value="relatorio"> <a
								href="index.php" class="btn btn-default">Volta</a>
						</div>
					</div>
				</form>
			</div>
		<!-- /.col-lg-4 -->
		<div class="col-lg-2"></div>
	</div>
<?php } ?>






	<!-- jQuery -->
	<script src="vendor/jquery/jquery.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="vendor/metisMenu/metisMenu.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="dist/js/sb-admin-2.js"></script>

</body>
</html>