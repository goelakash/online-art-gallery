(function($) {

	jQuery.fn.dropotron = function(options) {
		var settings = jQuery.extend({
			selectorParent:		jQuery(this)
		}, options);
		return jQuery.dropotron(settings);
	}

	jQuery.dropotron = function(options) {

		// Settings
			var settings = jQuery.extend({
				selectorParent:			null,				// The parent jQuery object
				menuClass:				'dropotron',		// Menu class (assigned to every UL)
				expandMode:				'hover',			// Expansion mode ("hover" or "click")
				hoverDelay:				150,				// Hover delay (in ms)
				hideDelay:				250,				// Hide delay (in ms; 0 disables)
				openerClass:			'opener',			// Opener class
				openerActiveClass:		'active',			// Active opener class
				mode:					'slide',			// Menu mode ("instant", "fade", "slide", "zoom")
				speed:					'fast',				// Menu speed ("fast", "slow", or ms)
				easing:					'swing',			// Easing mode ("swing", ???)
				offsetX:				0,					// Submenu offset X
				offsetY:				0,					// Submenu offset Y
				baseZIndex:				1					// Base Z-Index
			}, options);

		// Variables
			var _top = settings.selectorParent, _menus = _top.find('ul');
			var _window = jQuery('html');
			var isLocked = false, hoverTimeoutId = null, hideTimeoutId = null;

		// Main
			if (settings.hideDelay > 0)
			{
				_top.add(_menus)
					.mousemove(function(e) {
						window.clearTimeout(hideTimeoutID);
					})
					.mouseleave(function(e) {
						hideTimeoutID = window.setTimeout(function() {
							_top.trigger('doCollapseAll');
						}, settings.hideDelay);
					});
			}
		
			_top
				.bind('doCollapseAll', function() {
					_menus
						.trigger('doCollapse');
				});

			_menus.each(function() {
				var menu = jQuery(this), opener = menu.parent();

				menu
					.hide()
					.addClass(settings.menuClass)
					.css('position', 'absolute')
					.bind('doExpand', function() {
						
						if (menu.is(':visible'))
							return false;
						
						_menus.each(function() {
							var t = jQuery(this);
							if (!jQuery.contains(t.get(0), opener.get(0)))
								t.trigger('doCollapse');
						});
						
						var left, top, isTL = (menu.css('z-index') == 1);
						
						if (isTL)
						{
							left = opener.position().left;
							top = opener.position().top + opener.outerHeight();
						}
						else
						{
							left = opener.parent().outerWidth() + settings.offsetX;
							top = opener.position().top + settings.offsetY;
						}

						menu
							.css('left', left + 'px')
							.css('top', top + 'px');
							
						switch (settings.mode)
						{
							case 'zoom':

								isLocked = true;

								opener.addClass(settings.openerActiveClass);
								menu.animate({
									width: 'toggle',
									height: 'toggle'
								}, settings.speed, settings.easing, function() {
									isLocked = false;
								});

								break;
						
							case 'slide':

								isLocked = true;

								var tmp;
								
								if (isTL)
									tmp = { height: 'toggle' };
								else
									tmp = { width: 'toggle' };
								
								opener.addClass(settings.openerActiveClass);
								menu.animate(tmp, settings.speed, settings.easing, function() {
									isLocked = false;
								});

								break;
						
							case 'fade':

								isLocked = true;
								
								if (isTL)
								{
									var tmp;

									if (settings.speed == 'slow')
										tmp = 80;
									else if (settings.speed == 'fast')
										tmp = 40;
									else
										tmp = Math.floor(settings.speed / 2);
									
									opener.fadeTo(tmp, 0.01, function() {
										opener.addClass(settings.openerActiveClass);
										opener.fadeTo(settings.speed, 1);
										menu.fadeIn(settings.speed, function() {
											isLocked = false;
										});
									});
								}
								else
								{
									opener.addClass(settings.openerActiveClass);
									opener.fadeTo(settings.speed, 1);
									menu.fadeIn(settings.speed, function() {
										isLocked = false;
									});
								}

								break;
								
							case 'instant':
							default:

								opener.addClass(settings.openerActiveClass);
								menu.show();

								break;
						}
							
						return false;
					})
					.bind('doCollapse', function() {
						
						if (!menu.is(':visible'))
							return false;

						menu.hide();
						opener.removeClass(settings.openerActiveClass);
						menu.find('.' + settings.openerActiveClass).removeClass(settings.openerActiveClass);
						menu.find('ul').hide();
						
						return false;

					})
					.bind('doToggle', function(e) {
					
						if (menu.is(':visible'))
							menu.trigger('doCollapse');
						else
							menu.trigger('doExpand');
					
						return false;

					});
					
				opener
					.addClass('opener')
					.css('cursor', 'pointer')
					.click(function(e) {
					
						if (isLocked)
							return;

						e.stopPropagation();
						menu.trigger('doToggle');
					
					});

				if (settings.expandMode == 'hover')
					opener.hover(function(e) {
							if (isLocked)	
								return;
						
							var t = jQuery(this);
							hoverTimeoutID = window.setTimeout(function() {
								menu.trigger('doExpand');
							}, settings.hoverDelay);
						},
						function (e) {
							window.clearTimeout(hoverTimeoutID);
						}
					);
			});

			_top.find('a')
				.css('display', 'block')
				.click(function(e) {

					if (isLocked)
						return;
						
					_top.trigger('doCollapseAll');

					e.stopPropagation();

				});
				
			_top.find('li')
				.css('white-space', 'nowrap')
				.each(function() {
					var t = jQuery(this), a = t.children('a'), ul = t.children('ul');
					if (a.length > 0 && ul.length == 0)
						t.click(function(e) {

							if (isLocked)
								return;
								
							_top.trigger('doCollapseAll');

							e.stopPropagation();
							
							window.location.href = a.attr('href');

						});
				});

			_top.children('li').each(function() {

				var opener = jQuery(this), menu = opener.children('ul');

				menu
					.detach()
					.appendTo('body');

				for(var z = settings.baseZIndex, i = 1, y = menu; y.length > 0; i++)
				{
					y.css('z-index', z++);
					y = y.find('> li > ul');
				}

			});
			
			_window
				.click(function() {
					if (!isLocked)
						_top.trigger('doCollapseAll');
				})
				.keypress(function(e) {
					if (!isLocked
					&&	e.keyCode == 27) {
						e.preventDefault();
						_top.trigger('doCollapseAll');
					}
				});
	};

})(jQuery);
