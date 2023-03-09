function lx_carousel_content_block_course() {
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
	registerBlockType('lx-course-content-block/lx-block', {
		title: content_block_data.content_block_title,
		icon: 'admin-generic',
		category: 'lx-blocks',
		description: content_block_data.content_block_desc,
		attributes: {
			lx_course_selection : {type: 'string',default: ''},
			lx_login_required : {type: 'string',default: ''},
			lx_content_open_in : {type:'string',default:'in_page'}	
		},
		edit: function(props) {
			jQuery('.block-editor-writing-flow').addClass('custom_block');
			jQuery('.components-placeholder').hide();

			function changeCourseSelections(event) {
				props.setAttributes({lx_course_selection: event.target.value});
			}
			function changeNeedLogin(event){
				if(props.attributes.lx_login_required == 'yes'){
					props.setAttributes({lx_login_required: ''});
				} else{
					props.setAttributes({lx_login_required: event.target.value});
				}
			}
			function changeDisplaySelection(event){
				props.setAttributes({lx_content_open_in:event.target.value});
			}

			var lx_course_selections = [];
			lx_course_selections.push(el("option", { key: "Select", value: "" }, 'Select'));
			jQuery.each(content_block_data.course_info, function( key, value ) {
				lx_course_selections.push(el("option", { key: key, value: key }, value));
			});

			var lx_sel_need_login = [];
			if(props.attributes.lx_course_selection != ''){
				lx_sel_need_login.push(el("hr"),el("input", { onChange: changeNeedLogin,  type: "checkbox", value: "yes",name: "chk_need_login",checked: props.attributes.lx_login_required }),el("label", null, content_block_data.login_need),el("br"));
			}

			var display_selection=[];
			if( props.attributes.lx_content_open_in == 'in_page' ){
				var open_in_page =  props.attributes.lx_content_open_in;
			} else if( props.attributes.lx_content_open_in == 'lightbox' ){
				var open_in_lightbox =  props.attributes.lx_content_open_in;
			}else{
				var open_in_page='';
				var open_in_lightbox='';
			}
			display_selection.push(el('hr'),el("label", null, content_block_data.display_selection_lbl),el("br"),el("br"));
					
			display_selection.push(el("input", { onChange: changeDisplaySelection,  type: "radio", value: "lightbox",name:'lx_display_selection_info',checked: open_in_lightbox}),el("label", null, content_block_data.open_in_lightbox),el("br"));
			
			display_selection.push(el("input", { onChange: changeDisplaySelection,  type: "radio", value: "in_page",name:'lx_display_selection_info',checked: open_in_page}),el("label", null, content_block_data.open_in_page),el("br"));

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
					el("span", {style:{fontWeight: 600, width: '100%'}},content_block_data.selection_content+":"),
					el("br"),
					el("br"),
					el("select", {value: props.attributes.lx_course_selection, onChange: changeCourseSelections , style:{width:'100%'}}, lx_course_selections),
					el("br"),
					el("div", null,display_selection),
					el("br"),
					el("div", null,lx_sel_need_login),
				  ),
				),
			];
		
      return [
              controls,
				el(ServerSideRender, {
				  block: "lx-course-content-block/lx-block",
				  key: "lx-course-content-block/lx-block",
				  attributes: props.attributes
				} )
			
            ];
		return null;

		},
		save: function(props) {
		return null;
		}
	})
} 
lx_carousel_content_block_course();