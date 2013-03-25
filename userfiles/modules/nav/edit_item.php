<?
$rand = uniqid();
if(is_admin() == false){
    error('Must be admin');
}
$id = false;
if(isset($params['item-id'])){
	$id = intval($params['item-id']);
}



if($id == 0){
	$data = array();
	$data['id'] = $id;
	$data['parent_id'] = 0;
	if(isset($params['parent_id'])){
		$data['parent_id'] = intval($params['parent_id']);
	}
	if(!isset($params['content_id'])){
		$data['content_id'] = '';
	} else {
		$data['content_id'] = $params['content_id'];
	}
	if(!isset($params['categories_id'])){
		$data['categories_id'] = '';
	} else {
		$data['categories_id'] = $params['categories_id'];
	}
	$data['is_active'] = 'y';
	$data['position'] = '9999';
	$data['url'] = '';
	$data['title'] = '';
//	$data['categories_id'] = '';
} else {

	$data = get_menu_item($id);
}
if( $id != 0){
//$data = menu_tree( $id);
}

?>
<? if($data != false): ?>
<? //$rand = uniqid(); ?>


<div class="vSpace"></div>
<div class="<? print $config['module_class']; ?> menu_item_edit" id="mw_edit_menu_item_<?  print $rand ?>">
  <? if((!isset($data['title']) or $data['title']=='' ) and isset($data["content_id"]) and intval($data["content_id"]) > 0 ): ?>
  <? $cont = get_content_by_id($data["content_id"]);
	if(isset($cont['title'])){
		$data['title'] = $cont['title'];
		$item_url = content_link($cont['id']);
	}
	?>
  <? else: ?>
  <? if((!isset($data['title']) or $data['title']=='' )and isset($data["categories_id"]) and intval($data["categories_id"])>0): ?>
  <? $cont = get_category_by_id($data["categories_id"]);
    if(isset($cont['title'])){
    	$data['title'] = $cont['title'];
    	  $item_url = category_link($cont['id']);
    }
?>
  <? endif; ?>
  <? endif; ?>
  <?
  if (isset($data['content_id']) and intval($data['content_id']) != 0) {
		 	$item_url = content_link($data['content_id']);

	}

	if (isset($data['categories_id']) and intval($data['categories_id']) != 0) {

	$item_url = category_link($data['categories_id']);
	}


  if ((isset($item_url)  and $item_url != false) and (!isset($data['url']) or trim($data['url']) == '')) {
    $data['url'] = $item_url ;
  }


  ?>
  <div id="custom_link_inline_controller" class="mw-ui-gbox" style="display: none;"> <span onclick="cancel_editing_menu(<?  print $data['id'] ?>);" class="mw-ui-btnclose"></span>
    <h4>Edit menu item</h4>
    <div class="custom_link_delete_header"> <span class="mw-ui-delete" onclick="mw.menu_item_delete(<?  print $data['id'] ?>);">Delete</span></div>
    <input type="hidden" name="id" value="<?  print $data['id'] ?>" />
    <input type="text" placeholder="<?php _e("Title"); ?>" name="title" value="<?  print $data['title'] ?>" />
    <button class="mw-ui-btn2" onclick="mw.$('#menu-selector-<?  print $data['id'] ?>').toggle();">
    <?php _e("Change"); ?>
    </button>
    <div class="mw_clear vSpace"></div>
    <input type="text" placeholder="<?php _e("URL"); ?>" name="url" value="<?  print $data['url'] ?>" />
    <button class="mw-ui-btn2 mw-ui-btn-blue left" onclick="mw.menu_save_new_item('#custom_link_inline_controller');">Save</button>
    <div class="mw_clear vSpace"></div>
    <?php if($data['id'] != 0): ?>
    <div id="menu-selector-<?  print $data['id'] ?>" class="mw-ui mw-ui-category-selector mw-tree mw-tree-selector">
      <microweber module="categories/selector" active_ids="<?  print $data['content_id'] ?>" categories_active_ids="<?  print $data['categories_id'] ?>"  for="content" rel_id="<? print 0 ?>" input-type-categories="radio"  input-name-categories="link_id" input-name="link_id"  />
    </div>
    <script>mw.treeRenderer.appendUI('#menu-selector-<?  print $data['id'] ?>'); </script>
    <? endif; ?>
    <?  if(isset($params['menu-id']) and !isset($data['parent_id']) or $data['parent_id'] ==0): ?>
    <input type="text" name="parent_id" value="<?  print $params['menu-id'] ?>" />
    <? endif; ?>
  </div>
  <input type="hidden" name="id" value="<?  print $data['id'] ?>" />
  <input type="hidden" name="content_id" value="<?  print $data['content_id'] ?>" />
  <input type="hidden" name="categories_id" value="<?  print $data['categories_id'] ?>" />
  <?  if(isset($params['menu-id']) and  intval($data['id']) == 0): ?>
  <input type="hidden" name="parent_id" value="<?  print $params['menu-id'] ?>" />
  <?  elseif(isset($data['parent_id']) and $data['parent_id'] !=0): ?>
  <input type="hidden" name="parent_id" value="<?  print $data['parent_id'] ?>" />
  <?  elseif(isset($params['parent_id'])): ?>
  <input type="hidden" name="parent_id" value="<?  print $params['parent_id'] ?>" />
  <? endif; ?>
</div>
<? else: ?>
<? endif; ?>
