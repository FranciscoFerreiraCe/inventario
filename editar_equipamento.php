<?php ob_start();
  $page_title = 'Editar Equipamento';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$equipment = find_by_id('equipments',(int)$_GET['id']);
$all_types_equip = find_all('types_equips');
$all_supplier = find_all('suppliers');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
if(!$equipment){
  $session->msg("d","Equipamento não encontrado!");
  redirect('equipamentos.php');
}
?>
<?php
 if(isset($_POST['update_equipment'])){
    $req_fields = array('equipment-tombo','equipment-specifications','equipment-type_equip','equipment-manufacturer','equipment-situation');
    validate_fields($req_fields);

   if(empty($errors)){
       $equip_tombo  = remove_junk($db->escape($_POST['equipment-tombo']));
       $equip_specifications  = remove_junk($db->escape($_POST['equipment-specifications']));
       $equip_type_equip   = remove_junk($db->escape($_POST['equipment-type_equip']));
       $equip_supplier   = remove_junk($db->escape($_POST['equipment-supplier']));
       $equip_manufacturer   = remove_junk($db->escape($_POST['equipment-manufacturer']));
       $equip_situation  = remove_junk($db->escape($_POST['equipment-situation']));     
       $equip_updated_by    = (int) $_SESSION['user_id'];
       $equip_updated_at    = make_date();


       $query   = "UPDATE equipments SET";
       $query  .=" tombo ='{$equip_tombo}', specifications ='{$equip_specifications}',";
       $query  .=" types_equip_id ='{$equip_type_equip}', supplier_id ='{$equip_supplier}', manufacturer_id ='{$equip_manufacturer}', situation_id='{$equip_situation}', updated_by='{$equip_updated_by}', updated_at='{$equip_updated_at}'";
       $query  .=" WHERE id ='{$equipment['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Equipamento alterado com sucesso!");
                 redirect('equipamentos.php', false);
               } else {
                 $session->msg('d','Desculpe, falha ao alterar o equipamento.');
                 redirect('editar_equipamento.php?id='.$equipment['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('editar_equipamento.php?id='.$equipment['id'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Adicionar Novo Equipamento</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="editar_equipamento.php?id=<?= (int)$equipment['id'] ?>" class="clearfix">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-3">
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-th-large"></i>
                      </span>
                      <input type="text" class="form-control" name="equipment-tombo" placeholder="Número do Tombo" value="<?= (int)$equipment['tombo'] ?>" required>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-th-large"></i>
                      </span>
                      <input type="text" class="form-control" name="equipment-specifications" placeholder="Especificações do Equipamento" value="<?= $equipment['specifications'] ?>" required>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-md-5">
                    <select class="form-control" name="equipment-type_equip" required>
                      <option value="">Selecione o Tipo de Equipamento</option>
                    <?php  foreach ($all_types_equip as $t_equip): if($t_equip['id'] == $equipment['types_equip_id']): ?>
                      <option selected value="<?= (int)$t_equip['id'] ?>"><?= $t_equip['name'] ?></option>
                    <?php else: ?>
                      <option value="<?= (int)$t_equip['id'] ?>"><?= $t_equip['name'] ?></option>
                    <?php endif; endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-5">
                     <select class="form-control" name="equipment-supplier" required>
                      <option value="">Selecione o Fornecedor</option>
                    <?php  foreach ($all_supplier as $sup): if($sup['id'] == $equipment['supplier_id']): ?>
                      <option selected value="<?= (int)$sup['id'] ?>"><?= $sup['name'] ?></option>
                    <?php else: ?>
                      <option value="<?= (int)$sup['id'] ?>"><?= $sup['name'] ?></option>
                    <?php endif; endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-md-5">
                    <select class="form-control" name="equipment-manufacturer" required>
                      <option value="">Selecione o Fabricante</option>
                    <?php  foreach ($all_manufacturer as $man): if($man['id'] == $equipment['manufacturer_id']): ?>
                      <option selected value="<?= (int)$man['id'] ?>"><?= $man['name'] ?></option>
                    <?php else: ?>
                      <option value="<?= (int)$man['id'] ?>"><?= $man['name'] ?></option>
                    <?php endif; endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-5">
                     <select class="form-control" name="equipment-situation" required>
                      <option value="">Selecione a Situação</option>
                    <?php  foreach ($all_situation as $sit): if($sit['id'] == $equipment['situation_id']): ?>
                      <option selected value="<?= (int)$sit['id'] ?>"><?= $sit['name'] ?></option>
                    <?php else: ?>
                      <option value="<?= (int)$sit['id'] ?>"><?= $sit['name'] ?></option>
                    <?php endif; endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>             
              
              <button type="submit" name="update_equipment" class="btn btn-danger">Atualizar equipamento</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
