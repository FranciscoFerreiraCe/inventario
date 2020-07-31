<?php ob_start();
  $page_title = 'Todos os setores';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_sectors = find_all('sectors')
?>
<?php
 if(isset($_POST['add_sector'])){
   $req_field = array('sector-name');
   validate_fields($req_field);
   $sector_name = remove_junk($db->escape($_POST['sector-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO sectors (name)";
      $sql .= " VALUES ('{$sector_name}')";
      if($db->query($sql)){
        $session->msg("s", "Setor adicionado com sucesso!");
        redirect('setores.php',false);
      } else {
        $session->msg("d", "Desculpe, falha ao cadastrar o setor.");
        redirect('setores.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('setores.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>

  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
  </div>
   <div class="row">
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Adicionar novo setor</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="setores.php">
            <div class="form-group">
                <input type="text" class="form-control" name="sector-name" placeholder="Nome do setor" required>
            </div>
            <button type="submit" name="add_sector" class="btn btn-primary">Novo setor</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todos os setores</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Setores</th>
                    <th class="text-center" style="width: 100px;">Ações</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_sectors as $sec):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($sec['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="editar_setor.php?id=<?php echo (int)$sec['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="deletar_setor.php?id=<?php echo (int)$sec['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remover">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a>
                      </div>
                    </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
