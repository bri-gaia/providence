<?php
/* ----------------------------------------------------------------------
 * views/editor/representation_annotations/screen_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2023 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 	$t_representation_annotation 	= $this->getVar('t_subject');
	$vn_annotation_id 				= $this->getVar('subject_id');

	$vb_can_edit	 	= $t_representation_annotation->isSaveable($this->request);
	$vb_can_delete		= $t_representation_annotation->isDeletable($this->request);

	$vs_rel_table		= $this->getVar('rel_table');
	$vn_rel_type_id		= $this->getVar('rel_type_id');
	$vn_rel_id			= $this->getVar('rel_id');
	
	$forced_values 		= $this->getVar('forced_values') ?? [];
	
	if ($vb_can_edit) {
		$va_cancel_parameters = ($vn_annotation_id ? array('annotation_id' => $vn_annotation_id) : array('type_id' => $t_representation_annotation->getTypeID()));
		print $vs_control_box = caFormControlBox(
			caFormSubmitButton($this->request, __CA_NAV_ICON_SAVE__, _t("Save"), 'RepresentationAnnotationEditorForm').' '.
			($this->getVar('show_save_and_return') ? caFormSubmitButton($this->request, __CA_NAV_ICON_SAVE__, _t("Save and return"), 'RepresentationAnnotationEditorForm', array('isSaveAndReturn' => true)) : '').' '.
			caFormNavButton($this->request, __CA_NAV_ICON_CANCEL__, _t("Cancel"), '', 'editor/representation_annotations', 'RepresentationAnnotationEditor', 'Edit/'.$this->request->getActionExtra(), $va_cancel_parameters),
			($this->getVar('show_show_notifications') ? caFormJSButton($this->request, __CA_NAV_ICON_ALERT__, _t("Show editor alerts"), '', ['class' => 'caEditorFormNotifications']) : ''), 
			((intval($vn_annotation_id) > 0) && $vb_can_delete) ? caFormNavButton($this->request, __CA_NAV_ICON_DELETE__, _t("Delete"), '', 'editor/representation_annotations', 'RepresentationAnnotationEditor', 'Delete/'.$this->request->getActionExtra(), array('annotation_id' => $vn_annotation_id)) : ''
		);
	}
?>
	<div class="sectionBox">
<?php
			print caFormTag($this->request, 'Save/'.$this->request->getActionExtra().'/annotation_id/'.$vn_annotation_id, 'RepresentationAnnotationEditorForm', null, 'POST', 'multipart/form-data');
		
			$va_form_elements = $t_representation_annotation->getBundleFormHTMLForScreen($this->request->getActionExtra(), array(
									'request' => $this->request, 
									'formName' => 'RepresentationAnnotationEditorForm',
									'forcedValues' => $forced_values), $va_bundle_list);
									
			print join("\n", $va_form_elements);
			
			if ($vb_can_edit) { print $vs_control_box; }
?>
			<input type='hidden' name='annotation_id' value='<?php print $vn_annotation_id; ?>'/>
			<input id='isSaveAndReturn' type='hidden' name='is_save_and_return' value='0'/>
			<input type='hidden' name='rel_table' value='<?php print $vs_rel_table; ?>'/>
			<input type='hidden' name='rel_type_id' value='<?php print $vn_rel_type_id; ?>'/>
			<input type='hidden' name='rel_id' value='<?php print $vn_rel_id; ?>'/>
<?php
			if($this->request->getParameter('rel', pInteger)) {
?>
				<input type='hidden' name='rel' value='1'/>
<?php
			}
?>
		</form>
	</div>

	<div class="editorBottomPadding"><!-- empty --></div>
	
	<?php print caSetupEditorScreenOverlays($this->request, $t_representation_annotation, $va_bundle_list); ?>