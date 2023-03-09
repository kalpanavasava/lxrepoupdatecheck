/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
function lx_fliplist_carousel() {
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
        registerBlockType('lx-fl1plist-blocks/lx-block', {
            title: lx_fl1plist_block_data.custom_block_title,
            icon: 'admin-generic',
            category: 'lx-blocks',
            description: lx_fl1plist_block_data.custom_block_desc,
            attributes: {
                lx_selection : {type: 'string',default: 'fl1plist'},
                lx_fl1plist_selection : {type: 'string',default: 'categories'},
                lx_category_selection : {type: 'string',default: ''},
                lx_view_selection : {type: 'string',default: 'List'},
                lx_section_class : {type: 'string',default: ''},
                lx_fl1plist_status : {type: 'string',default: ''},
                lx_fl1plist_access : {type: 'string',default: ''},
                lx_section_title : {type: 'string',default: ''},
                className : {type: 'string'}
            },
    
            /* This configures how the content field will work, and sets up the necessary elements */
    
            edit: function(props) {
                var lx_selections_change;
                jQuery('.block-editor-writing-flow').addClass('custom_block');
                jQuery('.components-placeholder').hide();
                var lx_selections_change = [];
                function changefl1plistelection(event) {
                    props.setAttributes({lx_fl1plist_selection: event.target.value});
                }
                function changecategorySelections(event) {
                    var category_chk = [];
                    jQuery('input[name="chk_category_info"]:checked').each(function(key,value) {
                        category_chk[key] = this.value;
                    });
                    props.setAttributes({ lx_category_selection: category_chk.toString()});
                }
                
                function changeViewSelection(event){
                    props.setAttributes({lx_view_selection: event.target.value});
                }
                
                function changeFl1plistStatusSelection(event) {
                    var category_chk = [];
                    jQuery('input[name="lx_fl1plist_status"]:checked').each(function(key,value) {
                        category_chk[key] = this.value;
                    });
                    props.setAttributes({ lx_fl1plist_status: category_chk.toString()});
                }
                
                function changeFl1plistAccessSelection(event) {
                    var category_chk = [];
                    jQuery('input[name="lx_fl1plist_access"]:checked').each(function(key,value) {
                        category_chk[key] = this.value;
                    });
                    props.setAttributes({ lx_fl1plist_access: category_chk.toString()});
                }
                
                function setSectionTitle(event) {
                    props.setAttributes({lx_section_title: event.target.value});
                }
                
                var view_selection = [];
                
                if( props.attributes.lx_selection == 'fl1plist' ){
                    if(props.attributes.lx_fl1plist_selection == 'categories'){
                        var cat_info = props.attributes.lx_fl1plist_selection;
                    }
                     else if(props.attributes.lx_fl1plist_selection == 'not_in_categories'){ 
                        var cat_not_in_info = props.attributes.lx_fl1plist_selection;
                        var section_title = [];
                        var title_main_class;
                        if(props.attributes.lx_fl1plist_status !="" && props.attributes.lx_fl1plist_access !=""){
                            section_title.push(el("input", { onChange: setSectionTitle, style:{width:'100%'}, type: "text",placeholder:'Add section title here' ,className:'add_section_title',value : props.attributes.lx_section_title }) );
                            title_main_class = props.attributes.lx_selection;
                        }
                    }
                     else{
                        cat_info = '';
                        cat_not_in_info = '';
                        com_info = '';
                        props.setAttributes({lx_fl1plist_selection: cat_info});
                    }
                    if( props.attributes.lx_view_selection == 'Tab' ){
                        var tab_info =  props.attributes.lx_view_selection;
                    } else if( props.attributes.lx_view_selection == 'List' ){
                        var list_info =  props.attributes.lx_view_selection;
                    } else{
                        tab_info = '';
                        list_info = 'List';
                        props.setAttributes({lx_view_selection: "List"});
                    }
                    if(props.attributes.lx_fl1plist_selection == 'categories'){
                        view_selection.push(el("input", { onChange: changeViewSelection,type: "radio", value: "Tab",name:'lx_view_selection_info',checked: tab_info }),el("label", null, lx_fl1plist_block_data.tab_view),el("br"));
                    } else{
                        props.setAttributes({lx_view_selection: "List"});
                    }
                    
                    view_selection.push(el("input", { onChange: changeViewSelection, type: "radio", value: "List",name:'lx_view_selection_info',checked: list_info}),el("label", null, lx_fl1plist_block_data.list_view));
                        
                    lx_selections_change.push(el("input", { onChange: changefl1plistelection,  type: "radio", value: "categories",name:'lx_fl1plist_selection_info',checked: cat_info}),el("label", null, lx_fl1plist_block_data.categories),el("br"));
                
                    props.setAttributes({lx_parent_invite_only: null});
                    props.setAttributes({lx_articulate_web_selection: null});
                }else{
                    props.setAttributes({lx_fl1plist_selection: "categories"});
                }
                
                var result;
                var catSelections = [];
                
                if( props.attributes.lx_fl1plist_selection == 'categories' ){
                    jQuery.each(lx_fl1plist_block_data.category_info, function( key, value ) {
                        var category_info = props.attributes.lx_category_selection;
                        var checked = category_info.indexOf(value.slug) < 0? "":"checked";
                        catSelections.push(el("input", { onChange: changecategorySelections, type: "checkbox", name:'chk_category_info',value: value.slug,  checked: checked}),el("label",{style:{wordWrap: 'break-word', width: '92%'}}, value.name),el("br"));
                    });
                } 
                var lx_fl1plist_status_info = [];
                var fl1plist_status = props.attributes.lx_fl1plist_status;
                var publish_status = fl1plist_status.indexOf('publish') < 0? "":"checked";
                var draft_status = fl1plist_status.indexOf('draft') < 0? "":"checked";
        
                lx_fl1plist_status_info.push(el("input", { onChange: changeFl1plistStatusSelection,  type: "checkbox", value: "publish",name:'lx_fl1plist_status',checked: publish_status }),el("label", null, lx_fl1plist_block_data.lx_fl1plist_publish),el("br"));
                
                lx_fl1plist_status_info.push(el("input", { onChange: changeFl1plistStatusSelection,  type: "checkbox", value: "draft",name:'lx_fl1plist_status' ,checked: draft_status }),el("label", null, lx_fl1plist_block_data.lx_fl1plist_draft),el("br"));

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
                        el("span", {style:{fontWeight: 600, width: '100%'}},lx_fl1plist_block_data.selection_content+":"),
                        el("br"),
                        el("br"),
                        el("div", null, lx_selections_change),
                        el("br"),
                        el("div", null,catSelections),
                        el("hr"),
                        el("span", {style:{fontWeight: 600, width: '100%'}},lx_fl1plist_block_data.fl1plist_status_selection+":"),
                        el("br"),
                        el("br"),
                        el("div", null,lx_fl1plist_status_info),
                        el("span", {style:{fontWeight: 600, width: '100%'}},lx_fl1plist_block_data.view_selection_lbl+":"),
                        el("br"),
                        el("br"),
                        el("div", null,view_selection)
                      ),
                    ),
                ];
            
          return [
                  controls,
                    el(
                        "div",
                        { className: props.attributes.lx_selection },
                        el("div", null, section_title),
                        el("br"),
                        el(ServerSideRender, {
                            block: "lx-fl1plist-blocks/lx-block",
                            key: "lx-fl1plist-blocks/lx-block",
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
    lx_fliplist_carousel();