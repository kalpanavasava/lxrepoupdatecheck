/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
function lx_carousel_block_course() {
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
	registerBlockType('lx-articulate-web-block/lx-block', {
		title: lx_block_articulate_lite.custom_block_title,
		icon: 'admin-generic',
		category: 'lx-blocks',
		description: lx_block_articulate_lite.custom_block_desc,
		attributes: {
			lx_selection : {type: 'string',default: 'articulate-web'},
			lx_category_selection : {type: 'string',default: ''},
			lx_need_login : {type: 'string',default: ''},
			lx_view_selection : {type: 'string',default: 'List'},
			lx_section_class : {type: 'string',default: ''},
			lx_articulate_web_selection : {type: 'string',default: 'categories'},
			lx_articulate_web_category_selection : {type: 'string',default: ''},
			lx_alt_web_view_selection : {type: 'string',default: 'List'},
			lx_alt_web_display_selection : {type: 'string',default: ''},
			lx_alt_web_resource_type : {type: 'string',default: ''},
			className : {type: 'string'}
		},

		/* This configures how the content field will work, and sets up the necessary elements */

		edit: function(props) {
			var lx_selections_change;
			jQuery('.block-editor-writing-flow').addClass('custom_block');
			jQuery('.components-placeholder').hide();
			var lx_selections_change = [];

			function changecategorySelections(event) {
				var category_chk = [];
				jQuery('input[name="chk_category_info"]:checked').each(function(key,value) {
					category_chk[key] = this.value;
				});
				props.setAttributes({ lx_category_selection: category_chk.toString()});
			}
			function changeAltWebResourceType(event) {
				var category_chk = [];
				jQuery('input[name="lx_alt_web_resource_type"]:checked').each(function(key,value) {
					category_chk[key] = this.value;
				});
				props.setAttributes({ lx_alt_web_resource_type: category_chk.toString()});
			}
			function changeNeedLogin(event){
				if(props.attributes.lx_need_login == 'need_login'){
					props.setAttributes({lx_need_login: ''});
				} else{
					props.setAttributes({lx_need_login: event.target.value});
				}
			}
			
			function changeViewSelection(event){
				props.setAttributes({lx_view_selection: event.target.value});
			}
			function changeAltWebViewSelection(event){
				props.setAttributes({lx_alt_web_view_selection: event.target.value});
			}
			function changeAltWebDisplaySelection(event){
				props.setAttributes({lx_alt_web_display_selection: event.target.value});
			}
			function changeArticulateWebSelection(event) {
				props.setAttributes({lx_articulate_web_selection: event.target.value});
			}
			function changeArticulateWebcategorySelections(event) {
				var category_chk = [];
				jQuery('input[name="chk_art_web_category_info"]:checked').each(function(key,value) {
					category_chk[key] = this.value;
				});
				props.setAttributes({ lx_articulate_web_category_selection: category_chk.toString()});
			}
			var view_selection = [];
			var display_selection = [];
			var resource_type_selection = [];
			if(props.attributes.lx_selection == 'articulate-web'){
				props.setAttributes({lx_course_selection: null});
				var cat_info = 'categories';
				props.setAttributes({lx_articulate_web_selection: 'categories'});
				if( props.attributes.lx_alt_web_view_selection == 'Tab' ){
					var tab_info =  props.attributes.lx_alt_web_view_selection;
				} else if( props.attributes.lx_alt_web_view_selection == 'List' ){
					var list_info =  props.attributes.lx_alt_web_view_selection;
				} else{
					tab_info = '';
					list_info = '';
				}
				
				view_selection.push(el('hr'),el("label", null, lx_block_articulate_lite.view_selection_lbl),el("br"),el("br"));
				
				view_selection.push(el("input", { onChange: changeAltWebViewSelection,type: "radio", value: "Tab",name:'lx_alt_web_view_selection_info',checked: tab_info }),el("label", null, lx_block_articulate_lite.tab_view));
				
				view_selection.push(el("input", { onChange: changeAltWebViewSelection,  type: "radio", value: "List",name:'lx_alt_web_view_selection_info',checked: list_info,style:{marginLeft:'10px'}}),el("label", null, lx_block_articulate_lite.list_view),el("br"));
				
				lx_selections_change.push(el("input", { onChange: changeArticulateWebSelection,  type: "radio", value: "categories",name:'lx_articulate_selection_info',checked: cat_info}),el("label", null, lx_block_articulate_lite.categories),el("br"));
				
				/* Display selection */
				if( props.attributes.lx_alt_web_display_selection == 'in_page' ){
					var open_in_page =  props.attributes.lx_alt_web_display_selection;
				} else if( props.attributes.lx_alt_web_display_selection == 'lightbox' ){
					var open_in_lightbox =  props.attributes.lx_alt_web_display_selection;
				} 
			
				resource_type_selection.push(el('hr'),el("label", null, lx_block_articulate_lite.resource_type_lbl),el("br"),el("br"));
				
				var resource_category_info = props.attributes.lx_alt_web_resource_type;
				var resource_url = resource_category_info.indexOf('resource_url') < 0? "":"checked";
				var zip_package = resource_category_info.indexOf('zip_package') < 0? "":"checked";
				resource_type_selection.push(el("input", { onChange: changeAltWebResourceType,  type: "checkbox", value: "resource_url",name:'lx_alt_web_resource_type',checked: resource_url }),el("label", null, lx_block_articulate_lite.resource_url),el("br"));
				
				resource_type_selection.push(el("input", { onChange: changeAltWebResourceType,  type: "checkbox", value: "zip_package",name:'lx_alt_web_resource_type' ,checked: zip_package }),el("label", null, lx_block_articulate_lite.zip_package),el("br"));
				
				if(zip_package == 'checked'){
					
					display_selection.push(el('hr'),el("label", null, lx_block_articulate_lite.display_selection_lbl),el("br"),el("br"));
					
					display_selection.push(el("input", { onChange: changeAltWebDisplaySelection,  type: "radio", value: "lightbox",name:'lx_alt_web_display_selection_info',checked: open_in_lightbox}),el("label", null, lx_block_articulate_lite.open_in_lightbox),el("br"));
					
					display_selection.push(el("input", { onChange: changeAltWebDisplaySelection,  type: "radio", value: "in_page",name:'lx_alt_web_display_selection_info',checked: open_in_page}),el("label", null, lx_block_articulate_lite.open_in_page),el("br"));
				} else{
					open_in_page = '';
					open_in_lightbox = '';
				}
				
			} 
			
			var result;
			var catSelections = [];
	
			if( props.attributes.lx_articulate_web_selection == 'categories' ){
				jQuery.each(lx_block_articulate_lite.category_info, function( key, value ) {
					var category_info = props.attributes.lx_articulate_web_category_selection;
					var checked = category_info.indexOf(value.term_id) < 0? "":"checked";
					catSelections.push(el("input", { onChange: changeArticulateWebcategorySelections, type: "checkbox", name:'chk_art_web_category_info',value: value.term_id,  checked: checked}),el("label",{style:{wordWrap: 'break-word', width: '92%'}}, value.name),el("br"));
				});
			}
			var lx_selections_need_login = [];
			if(props.attributes.lx_selection != null){
				lx_selections_need_login.push(el("hr"),el("input", { onChange: changeNeedLogin,  type: "checkbox", value: "need_login",name: "chk_need_login",checked: props.attributes.lx_need_login }),el("label", null, lx_block_articulate_lite.need_login),el("br"));
			}
		
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
					el("span", {style:{fontWeight: 600, width: '100%'}},lx_block_articulate_lite.selection_content+":"),
					el("br"),
					el("br"),
					el("div", null, lx_selections_change),
					el("br"),
					el("div", null,catSelections),
					el("div", null,view_selection),
					el("div", null,resource_type_selection),
					el("div", null,display_selection),
					el("div", null,lx_selections_need_login),
					el("br"),
				  ),
				),
			];
		
      return [
              controls,
				el(
					"div",
					{ className: props.attributes.lx_selection },
					el(ServerSideRender, {
						block: "lx-articulate-web-block/lx-block",
						key: "lx-articulate-web-block/lx-block",
						attributes: props.attributes,
						className: 'main_class_div'
					} )
				)
			
            ];
		return null;

		},
		save: function(props) {
		return null;
		}
	})
} 
lx_carousel_block_course();