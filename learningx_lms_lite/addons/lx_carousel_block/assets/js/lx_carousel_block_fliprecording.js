function lx_carousel_block_fliprecording() {
"use strict";
	
	const { registerBlockType } = wp.blocks;
	const {
		RichText,
		AlignmentToolbar,
		BlockControls,
		BlockDescription,
		ToggleControl
	} = wp.editor;

	const {
	  InspectorControls
	} = wp.blockEditor;

	const {
	  serverSideRender: ServerSideRender
	} = wp;

	var el = wp.element.createElement;
	registerBlockType('lx-flip-recording-blocks/lx-block', {
		title: lx_flip_recording_obj.custom_block_title,
		icon: 'admin-generic',
		category: 'lx-blocks',
		description: lx_flip_recording_obj.custom_block_desc,
		attributes: {
			lx_fliprecording_selection : {type: 'string',default: ''},
		},

		/* This configures how the content field will work, and sets up the necessary elements */

		edit: function(props) {
			jQuery('.block-editor-writing-flow').addClass('custom_block');
			jQuery('.components-placeholder').hide();
			function changeFlipRecordingSelections(event){
				props.setAttributes({lx_fliprecording_selection: event.target.value});
			}
			var lx_fr_selection=[];
			lx_fr_selection.push(el("option", { key: "Select", value: "" }, 'Select'));
			jQuery.each(lx_flip_recording_obj.fliplist_info, function( key, value ) {
				lx_fr_selection.push(el("option", { key: key, value: key }, value));
			});
			const controls = [
				el(
				  InspectorControls,
				  {},
				  el(
					"div",
					{ style: {padding: "15px" }},
					el(
					  "hr",
					  null
					),
					el("span", {style:{fontWeight: 600, width: '100%'}},lx_flip_recording_obj.selection_content+":"),
					el("br"),
					el("br"),
					el("select", {value: props.attributes.lx_fliprecording_selection, onChange: changeFlipRecordingSelections , style:{width:'100%'}}, lx_fr_selection),
				  ),
				),
			];
			return [
              	controls,
			  	el(ServerSideRender, {
					block: "lx-flip-recording-blocks/lx-block",
					key: "lx-flip-recording-blocks/lx-block",
					attributes: props.attributes,
				} )	
            ];
			return null;
		},
		save: function(props) {
			return null;
		}
	})
}
lx_carousel_block_fliprecording();