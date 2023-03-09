jQuery(function($) {
   //alert(jQuery(".quadmenu-container").prop("href"));
   jQuery("a[href='http://backlink']").prop("href", document.referrer);
   jQuery("a[href='https://backlink']").prop("href", document.referrer);
});

