(function ($, document) {
    "use strict";

    function deviceOS() {
        var useragent = navigator.userAgent;

        if (useragent.match(/Android/i)) {
            return 'android';
        } else if (useragent.match(/webOS/i)) {
            return 'webos';
        } else if (useragent.match(/iPhone/i)) {
            return 'iphone';
        } else if (useragent.match(/iPod/i)) {
            return 'ipod';
        } else if (useragent.match(/iPad/i)) {
            return 'ipad';
        } else if (useragent.match(/Windows Phone/i)) {
            return 'windows phone';
        } else if (useragent.match(/SymbianOS/i)) {
            return 'symbian';
        } else if (useragent.match(/RIM/i) || useragent.match(/BB/i)) {
            return 'blackberry';
        } else {
            return false;
        }
    }

    function scrollTop() {
        var el = document.scrollingElement || document.documentElement;
        return el.scrollTop;
    }

    var isMobile = false !== deviceOS();

    $.extend($.fn.popmake.triggers, {
        exit_intent: function (settings) {
            // Merge Defaults.
            settings = $.extend({
                methods: ['mouseleave'],
                top_sensitivity: 10,
                delay_sensitivity: 350,
                continue_back_on_close: false,
                linkclick_method: 'hover',
                linkclick_targeting: [],
                linkclick_custom_targeting: '',
                link_hover_delay: 300,
                mobile_time_delay: 500,
                mobilescroll_up_percent: 0.2
            }, settings);

            var $popup = PUM.getPopup(this),
                popupID = PUM.getSetting($popup, 'id'),
                timers = {}, // Stores the timeouts used for sensitivity delay & such.
                maybeOpen = function (label, returnValue) {
                    returnValue = returnValue || false;

                    /**
                     * If the popup is already open return history.back()
                     * going to the previous page to not be annoying.
                     */
                    if ($popup.popmake('state', 'isOpen')) {
                        return returnValue;
                    }

                    /**
                     * If the conditions fail or cookies are set already, return history.back()
                     * going to the previous page to not be annoying.
                     */
                    if ($popup.popmake('checkCookies', settings) || !$popup.popmake('checkConditions')) {
                        return returnValue;
                    }

                    /**
                     * Set the global last open trigger to the a text description of the trigger.
                     */
                    $.fn.popmake.last_open_trigger = label;

                    $popup.popmake('open');

                    return true;
                };

            if (!Array.isArray(settings.methods) && typeof settings.methods === "object") {
                settings.methods = Object.keys(settings.methods);
            }

            if (Array.isArray(settings.methods) && !settings.methods.length) {
                /**
                 * If its missing, could be popup date wasn't migrated yet, better default to mouseleave only.
                 */
                settings.methods = ['mouseleave'];
            }

            settings.methods.forEach(function (method) {
                switch (method) {
                case 'mouseleave':
                    $(document)
                        .on('mouseleave', function (e) {
                            if (e.target.nodeName.toLowerCase() === 'select' || e.clientY > settings.top_sensitivity) {
                                return;
                            }

                            timers.sensitivity_delay = setTimeout(function () {
                                maybeOpen('Exit Intent - Mouse Leave');
                                timers.sensitivity_delay = null;
                            }, settings.delay_sensitivity);
                        })
                        .on('mouseenter', function () {
                            clearTimeout(timers.sensitivity_delay);
                        });
                    break;

                case 'lostfocus':
                    $(window, document).on('blur', function () {
                        maybeOpen('Exit Intent - Lost Focus');
                    });
                    break;

                case 'backbutton':
                    /**
                     * If no cookies exist for this popup add a new empty history state so that we can detect back button clicks.
                     */
                    if (!$popup.popmake('checkCookies', settings) && (history.state === null || typeof history.state.popup === "undefined")) {

                        var state = history.state || {};
                        /**
                         * First we update the current state, adding a flag for later detection.
                         */
                        history.replaceState($.extend({}, state, {popup: popupID}), "", window.location);

                        /**
                         * Next we push a new empty state with the same url and no flag set.
                         */
                        history.pushState({popup: null}, "", window.location);
                    }

                    /**
                     * Listen for history navigation changes and respond correctly based on chosen settings.
                     */
                    setTimeout(function () {
                        window.addEventListener('popstate', function (event) {
                            if (event.state && event.state.popup === popupID) {
                                if (maybeOpen('Exit Intent - Back Button')) {
                                    /**
                                     * If option to continue on close is set, when the popup is closed,
                                     * send them back where they intended to go.
                                     */
                                    if (settings.continue_back_on_close) {
                                        $popup.on('pumAfterClose', function () {
                                            history.back();
                                        });
                                    }
                                } else {
                                    history.back();
                                }
                            }
                        });
                    }, 100);
                    break;

                case 'linkclick':
                    if (!Array.isArray(settings.linkclick_targeting) && typeof settings.linkclick_targeting === "object") {
                        settings.linkclick_targeting = Object.keys(settings.linkclick_targeting);
                    }

					var selectors = [],
						linkHandler = function (event) {
							if (maybeOpen('Exit Intent - Link Click')) {
								event.preventDefault();
							}
						};


					if (settings.linkclick_targeting.indexOf("external") >= 0) {
						selectors.push('a:external');
					}

					if (settings.linkclick_targeting.indexOf("internal") >= 0) {
						selectors.push('a:internal');
					}

					if (settings.linkclick_targeting.indexOf("custom") >= 0) {
						selectors.push(settings.linkclick_custom_targeting);
					}

					selectors = selectors.join(',');

					$(document)
                        .on('mouseenter touchstart', selectors, function (event) {
                            timers.link_hover_delay = setTimeout(function () {
                                linkHandler(event);

                                timers.link_hover_delay = null;
                            }, settings.link_hover_delay);
                        })
                        .on('mouseleave touchend', selectors, function () {
                            clearTimeout(timers.link_hover_delay);
                        });
                    break;

                case 'mobiletime':
                    if (isMobile) {
                        setTimeout(function () {
                            maybeOpen('Exit Intent - Time Delay');
                        }, settings.mobile_time_delay);
                    }
                    break;

                case 'mobilescroll':

                    // Let the user scroll up by some significant amount
                    var percentUp = settings.mobilescroll_up_percent / 100,
                        $window = $(window),
                        scrollStart = $window.scrollTop(),
                        pageHeight = $(document).height(),
                        interval, scrollAmount, upScrollPercent;

                    if (isMobile && pageHeight > 0) {
                        // Only check the scroll position every few seconds, to avoid bogging the UI
                        interval = setInterval(function () {

                            scrollAmount = scrollStart - $window.scrollTop();

                            if (scrollAmount < 0) {
                                scrollAmount = 0;
                                scrollStart = $window.scrollTop();
                            }

                            upScrollPercent = scrollAmount / pageHeight;

                            if (upScrollPercent > percentUp) {
                                if (maybeOpen('Exit Intent - Time Delay')) {
                                    clearInterval(interval);
                                }
                            }
                        }, 100);
                    }
                    break;
                }
            });
        },
        exit_prevention: function (settings) {
            var $popup = PUM.getPopup(this),
                allow_unload = false; // Page can only be unloaded once this is true. Used for hard exit.

            // Merge Defaults.
            settings = $.extend({
                message: ''
            }, settings);

            window.onbeforeunload = function () {
                if (allow_unload) {
                    return;
                }

                // If the popup is already open return.
                if ($popup.popmake('state', 'isOpen')) {
                    return;
                }

                // If cookie exists or conditions fail return.
                if ($popup.popmake('checkCookies', settings) || !$popup.popmake('checkConditions')) {
                    return;
                }

                // Set the global last open trigger to the a text description of the trigger.
                $.fn.popmake.last_open_trigger = 'Exit Prevention' + settings.message;

                $popup.popmake('open');

                allow_unload = true;

                return settings.message;
            };
        }
    });
}(jQuery, document));
