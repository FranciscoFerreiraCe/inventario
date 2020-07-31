<?php ob_start();
  $page_title = 'Todos os tipos de equipamento';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_types_equip = find_all('types_equips')
?>
<?php
 if(isset($_POST['types_equip'])){
   $req_field = array('tipos_equipamento-name');
   validate_fields($req_field);
   $type_equip_name = remove_junk($db->escape($_POST['tipos_equipamento-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO types_equips (name)";
      $sql .= " VALUES ('{$type_equip_name}')";
      if($db->query($sql)){
        $session->msg("s", "Tipos de equipamento adicionado com sucesso!");
        redirect('tipos_equipamento.php',false);
      } else {
        $session->msg("d", "Desculpe, falha ao cadastrar o tipo de equipamento.");
        redirect('tipos_equipamento.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('tipos_equipamento.php',false);
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
            <span>Adicionar novo tipo de equipamento</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="tipos_equipamento.php">
            <div class="form-group">
                <input type="text" class="form-control" name="tipos_equipamento-name" placeholder="Nome do tipo de equipamento" required>
            </div>
            <button type="submit" name="types_equip" class="btn btn-primary">Novo tipo de equipamento</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todos os tipos de equipamento</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Tipos de equipamento</th>
                    <th class="text-center" style="width: 100px;">Ações</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_types_equip as $t_equip):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($t_equip['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="editar_tipos_equipamento.php?id=<?php echo (int)$t_equip['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="deletar_tipos_equipamento.php?id=<?php echo (int)$t_equip['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remover">
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