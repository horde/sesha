<?php
/**
 * This file is the classic list view of the Inventory application for Horde,
 * Sesha. It should also be able to display search results and other useful
 * things.
 *
 * Copyright 2012 Horde LLC (http://www.horde.org)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.horde.org/licenses/gpl.
 */

require_once __DIR__ . '/lib/Application.php';
Horde_Registry::appInit('sesha');

/* While switching from Horde_Template to Horde_View, try to leave only lines which strictly need to be in this file */
// Start page display.

$view = new Sesha_View_List(array('templatePath' => SESHA_TEMPLATES . '/view/',
                                'selectedCategories' => array(Horde_Util::getFormData('category_id')),
                                'sortDir' => Horde_Util::getFormData('sortdir'),
                                'sortBy' => Horde_Util::getFormData('sortby'),
                                'propertyIds' => @unserialize($prefs->getValue('list_properties'))
                            )
                            );
$page_output->addScriptFile('prototype.js', 'horde');
$page_output->addScriptFile('tables.js', 'horde');
$page_output->header(array(
    'title' => $view->title
));
require SESHA_TEMPLATES . '/menu.inc';
echo $view->render('list.php');
$page_output->footer();



// // Page variables
// $title = _("Current Inventory");
// 
// // Intial sorting options
// $sortby = Horde_Util::getFormData('sortby');
// $sortdir = Horde_Util::getFormData('sortdir');
// if (!is_null($sortby)) {
//     $prefs->setValue('sortby', $sortby);
// }
// if (!is_null($sortdir)) {
//     $prefs->setValue('sortdir', $sortdir);
// }
// 
// // Set the category if possible
// try {
//     $categories = Sesha::listCategories();
// } catch (Sesha_Exception $e) {
//     $notification->push(_("There are no categories"), 'horde.warning');
//     $categories = array();
// }
// 
// $category_id = Horde_Util::getFormData('category_id');
// $driver = $GLOBALS['injector']->getInstance('Sesha_Factory_Driver')->create();
// if ($category_id) {
//     $selectedCategory = $driver->getCategory($category_id);
// }
// 
// // Search variables
// $what = Horde_Util::getFormData('criteria');
// $loc = Horde_Util::getFormData('location');
// $where = null;
// if (is_array($loc)) {
//     foreach ($loc as $field) {
//         $where += constant($field);
//     }
// }
// if (!is_null($what) && !is_null($where)) {
//     $title = _("Search Inventory");
//     $table_header = _("Matching Inventory");
// } else {
//     $table_header = $category_id ?
//         sprintf(_("Available Inventory in %s"), $selectedCategory->category) : _("Available Inventory");
// }
// 
// // Get the inventory
// try {
//     $inventory = Sesha::listStock($sortby, $sortdir, $category_id, $what, $where);
// } catch (Sesha_Exception $e) {
//     throw new Horde_Exception($e);
// }
// 
// // Properties being displayed
// try {
//     $property_ids = @unserialize($prefs->getValue('list_properties'));
//     if (empty($property_ids)) {
//         /* The driver understands an empty filter as "all" but if none are selected, we want none */
//         $properties = array();
//     } else {
//         $properties = $GLOBALS['injector']->getInstance('Sesha_Factory_Driver')->create()->getProperties($property_ids);
//     }
// } catch (Sesha_Exception $e) {
// 
// }
// // Start page display.
// $page_output->addScriptFile('prototype.js', 'horde');
// $page_output->addScriptFile('tables.js', 'horde');
// $page_output->header(array(
//     'title' => $title
// ));
// require SESHA_TEMPLATES . '/menu.inc';
// 
// 
// $sortby = $prefs->getValue('sortby');
// $sortdir = $prefs->getValue('sortdir');
// $isAdminEdit = Sesha::isAdmin(Horde_Perms::EDIT);
// $itemEditImg = Horde::img('edit.png', _("Edit Item"));
// $isAdminDelete = Sesha::isAdmin(Horde_Perms::DELETE);
// $adminDeleteImg = Horde::img('delete.png', _("Delete Item"));
// 
// $item_count = count($inventory) == 1
//     ? _("1 Item")
//     : sprintf(_("%d Items"), count($inventory));
// 
// foreach ($categories as $id => $category) {
//      $category->selected = $category->category_id == $category_id ? ' selected="selected"' : '';
// }
// 
// $prefs_url = Horde::url($registry->get('webroot', 'horde') . '/services/prefs/', true);
// $sortdirclass = $sortdir ? 'sortup' : 'sortdown';
// $baseurl = Horde::url('list.php');
// $column_headers = array(
//     array('id' => 's' . Sesha::SESHA_SORT_STOCKID,
//           'class' => $sortby == Sesha::SESHA_SORT_STOCKID ? ' class="' . $sortdirclass . '"' : '',
//           'link' => Horde::link(Horde_Util::addParameter($baseurl, 'sortby', Sesha::SESHA_SORT_STOCKID), _("Sort by stock ID"), 'sortlink') . _("Stock ID") . '</a>',
//           'width' => ' width="5%"'),
//     array('id' => 's' . Sesha::SESHA_SORT_NAME,
//           'class' => $sortby == Sesha::SESHA_SORT_NAME ? ' class="' . $sortdirclass . '"' : '',
//           'link' => Horde::link(Horde_Util::addParameter($baseurl, 'sortby', Sesha::SESHA_SORT_NAME), _("Sort by item name"), 'sortlink') . _("Item Name") . '</a>',
//           'width' => '')
// );
// foreach ($properties as $property_id => $property) {
//     $column_headers[] = array(
//         'id' => 'sp' . $property_id,
//         'class' => $sortby == 'p' . $property_id ? ' class="' . $sortdirclass . '"' : '',
//         'link' => Horde::link(Horde_Util::addParameter($baseurl, 'sortby', 'p' . $property_id), sprintf(_("Sort by %s"), htmlspecialchars($property['property'])), 'sortlink') . htmlspecialchars($property['property']) . '</a>',
//         'width' => '',
//     );
// }
// $column_headers[] = array(
//     'id' => 's' . Sesha::SESHA_SORT_NOTE,
//     'class' => $sortby == Sesha::SESHA_SORT_NOTE ? ' class="' . $sortdirclass . '"' : '',
//     'link' => Horde::link(Horde_Util::addParameter($baseurl, 'sortby', Sesha::SESHA_SORT_NOTE), _("Sort by note"), 'sortlink') . _("Note") . '</a>',
//     'width' => '',
// );
// 
// $property_ids = array_keys($properties);
// $stock_url = Horde::url('stock.php');
// $stock = array();
// foreach ($inventory as $row) {
//     $url = Horde_Util::addParameter($stock_url, 'stock_id', $row['stock_id']);
//     $rows = array();
// 
//     // icons
//     $icons = '';
//     if ($isAdminEdit) {
//         $icons .= Horde::link(Horde_Util::addParameter($url, 'actionId', 'update_stock'), _("Edit Item")) . $itemEditImg . '</a>';
//     }
//     if ($isAdminDelete) {
//         $icons .= Horde::link(Horde_Util::addParameter($url, 'actionId', 'remove_stock'), _("Delete Item")) . $adminDeleteImg . '</a>';
//     }
//     $rows[] = array('class' => ' class="nowrap"', 'row' => $icons);
// 
//     // stock_id
//     $rows[] = array('class' => '', 'row' => Horde::link(Horde_Util::addParameter($url, 'actionId', 'view_stock'), _("View Item")) . htmlspecialchars($row['stock_id']) . '</a>');
// 
//     // name
//     $rows[] = array('class' => '', 'row' => Horde::link(Horde_Util::addParameter($url, 'actionId', 'view_stock'), _("View Item")) . htmlspecialchars($row['stock_name']) . '</a>');
// 
//     // properties
//     foreach ($property_ids as $property_id) {
//         $rows[] = array('class' => '', 'row' => isset($row['p' . $property_id]) ? htmlspecialchars($row['p' . $property_id]) : '&nbsp;');
//     }
// 
//     // note
//     $rows[] = array('class' => '', 'row' => $row['note'] ? htmlspecialchars($row['note']) : '&nbsp;');
// 
//     $stock[] = array('rows' => $rows);
// }
// 
// $t = new Horde_Template();
// $t->setOption('gettext', true);
// $t->set('header', $table_header);
// $t->set('count', $item_count);
// $t->set('form_url', Horde::url('list.php'));
// $t->set('form_input', Horde_Util::pformInput());
// 
// /* Ugly - the template engine doesn't cope with objects. Workaround until we migrate to views */
// $catArray = array();
// foreach ($categories as $category) {
//     $catArray[$category->category_id] = array(
//                         'category_id' => $category->category_id,
//                         'selected' => $category->selected,
//                         'category' => $category->category
//                     );
// }
// $t->set('categories', $catArray);
// $t->set('prefs_url', $prefs_url);
// $t->set('column_headers', $column_headers);
// $t->set('stock', $stock, true);
// $t->set('properties', $properties);
// 
// echo $t->fetch(SESHA_TEMPLATES . '/list.html');
// $page_output->footer();
