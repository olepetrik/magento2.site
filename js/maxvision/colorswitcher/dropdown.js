/**
 * Colorswitcher - Magento Extension
 *
 * @category    MaxVision
 * @package     Colorswitcher
 * @copyright   Copyright (c) 2015 MaxVision <maxyvision@gmail.com>
 **/
(function (f) {
    f.fn.dropdown = function (_options) {
        var dropdown = this.data ("dropdown") ;

        if (dropdown) {
			dropdown.listContainer.remove () ;
			dropdown.inputContainer.remove () ;
        }
		
		if (!document.dropdowns) {
			document.dropdowns = [] ;
		}

        return this.each (function () {
            var dropdown = jQuery(this) ;

            dropdown.data ("dropdown", dropdown) ;

            /* ******************************************************************* */
            /* begin: PROPERTIES */
            /* ******************************************************************* */
			dropdown.params = _options ;  // одержали шлях до іконки зі стрілкою для dropdown
            /* ******************************************************************* */
            /* end: PROPERTIES */
            /* ******************************************************************* */

            /* ******************************************************************* */
            /* begin: METHODS */
            /* ******************************************************************* */
			dropdown.sizes = function () {
                dropdown.list.width(dropdown.input.outerWidth());
                if (dropdown.options.length > 10) {
                    dropdown.listContainer.height(jQuery(dropdown.options [0]).height() * 10);
                }
            }

			dropdown.init = function () {
				var options = dropdown.children ("OPTION") ;  

				var selected = jQuery(this).find('option[selected="selected"]').val();
				//alert(typeof selected );
				if(typeof selected != 'undefined') {
					selectedVal = jQuery(this).find('option[selected="selected"]').html().trim();
				} else {
					selectedVal = '';
				}
				
				dropdown.hide () ;

				dropdown.isDisabled = (dropdown.attr ("data-disabled") == "true") ? true : false ;
				var disabledClass = (dropdown.isDisabled) ? " disabled" : "" ;
				
				var html = '<div class="dropdown' + disabledClass + '"><input value="' + selectedVal+ '" readonly="readonly" type="text" id="' + dropdown.attr ("id");
//                    html += '"/><img class="dropdownIco" src="/skin/frontend/base/default/colorswitcher/images/icoDropdown.gif" width="20" height="20"/></div>' ;
                    html += '"/><img class="dropdownIco" src="' + dropdown.params +'" width="20" height="20"/></div>' ;
   					html += '<div class="dropdownOptionsList"><ul>' ;

				options.each (function (_i) {
					var option = jQuery(this) ;

					html += '<li data-value="' + option.attr ("value") + '">' + option.text().trim() + '</li>' ;
				}) ;
				
					html += '</ul></div>' ;

				dropdown.before (html) ;

				dropdown.listContainer = dropdown.prev () ;
				dropdown.list = dropdown.listContainer.find ("UL") ;
				dropdown.options = dropdown.list.find ("LI") ;
				dropdown.inputContainer = dropdown.listContainer.prev () ;
				dropdown.input = dropdown.inputContainer.find ("INPUT") ;
				dropdown.arrow = dropdown.inputContainer.find (".dropdownIco") ;

				dropdown.operate = function (_event) {
					var delta = jQuery('#divMainTabs').outerHeight () + jQuery('#divSearch').outerHeight () + jQuery('#divHeader').outerHeight () + jQuery('.divDocumentName:visible').outerHeight () ;

					_event.stopPropagation () ;

					if (dropdown.isDisabled) return ;

					for (var i = 0 ; i < document.dropdowns.length ; i++) {
						document.dropdowns [i].listContainer.hide () ;
					}
					
					dropdown.listContainer.css ({
						width : dropdown.inputContainer.width () + 3
					}) ;
					dropdown.options.css ({
						width : dropdown.listContainer.innerWidth () + 3
					}) ;
					
                    // Top position of Dropdownlist
					var top = 0 ;

                    // Вираховуєм та встановлюєм зміщення випадаючого списка до основного поля Select
					//if (dropdown.input.offset ().top - delta + dropdown.input.outerHeight () + 2 + dropdown.listContainer.outerHeight () > jQuery("BODY").outerHeight ()) {
					//	dropdown.listContainer.css ({
					//		top : dropdown.input.offset ().top - delta - dropdown.listContainer.outerHeight () - 60
					//	}) ;
					//}
					//else {
					//	dropdown.listContainer.css ({
					//		top : dropdown.input.offset ().top - delta + dropdown.input.outerHeight () + 4
					//	}) ;
					//}
					
					dropdown.listContainer.stop (true, true).fadeIn (100) ;
				}

				dropdown.input.click (function (_event) {
					dropdown.operate (_event) ;
				}) ;
				dropdown.arrow.click (function (_event) {
					dropdown.operate (_event) ;
				}) ;

				dropdown.options.each (function (_i) {
					var option = jQuery(this) ;

					option.click (function (_event) {
						dropdown.input.val (option.text ()) ;
						dropdown.val (option.text ()) ;
						dropdown.listContainer.stop (true, true).fadeOut (100) ;

						if (dropdown.params && dropdown.params.change) {
							dropdown.params.change (_event, dropdown) ;
						}
					}) ;
				}) ;

				dropdown.sizes () ;
				dropdown.listContainer.hide () ;
				document.dropdowns.push (dropdown) ;
            }
			/* ******************************************************************* */
            /* end: METHODS */
            /* ******************************************************************* */

			jQuery(window).resize (function () {
				dropdown.sizes () ;
			}) ;
			jQuery(document).click (function () {
				dropdown.listContainer.hide () ;
			}) ;

            dropdown.init () ;
        }).data ("dropdown") ;
    }
})(jQuery) ;