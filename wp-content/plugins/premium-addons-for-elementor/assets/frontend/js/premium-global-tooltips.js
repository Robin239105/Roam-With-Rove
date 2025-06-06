(function ($) {
	/**
	 * Tooltip tour trigger props
	 * [pa-tooltip-trigger | tooltip-unique-css-selector] =>  property given to the button to trigger the next tooltip
	 * [pa-tooltip-selector | tooltip-id given by the user]
	 * premium-tooltipster-closer  => a class used for closing the tooltips
	 */

	$(window).on('elementor/frontend/init', function () {

		var premiumGlobalTooltipsHandler = function ($scope, $) {

			if (!$scope.hasClass('premium-global-tooltips-yes')) {
				return;
			}

			var elemType = $scope.data('element_type'),
				id = $scope.data(elementorFrontend.isEditMode() ? "id" : "tooltip-id"),
				settings = {};

			generateSettings(elemType, id);

			if (!settings) {
				return false;
			}

			generateGlobalTooltip();

			if ('viewport' === settings.trigger) {
				// Using IntersectionObserverAPI.
				var eleObserver = new IntersectionObserver(function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							if ('' !== settings.target) {
								$scope.find(settings.target).tooltipster('open');
							} else {
								$scope.tooltipster('open');
							}

							eleObserver.unobserve(entry.target);
						}
					});
				});

				eleObserver.observe($scope[0]);
			}

			/**
			 * Helper Functions.
			 */

			function generateSettings(type, id) {

				var editMode = elementorFrontend.isEditMode(),
					tooltipSettings = {},
					tempTarget = $scope.find('#premium-global-tooltips-' + id),
					tempTarget2 = $scope.find('#premium-global-tooltips-temp-' + id),
					tempExist = 0 !== tempTarget.length || 0 !== tempTarget2.length,
					editMode = elementorFrontend.isEditMode() && tempExist;

				if (editMode) {
					tooltipSettings = tempTarget.data('tooltip_settings');

					if ('widget' === type && !tooltipSettings) {
						tooltipSettings = tempTarget2.data('tooltip_settings');
					}
				} else {
					tooltipSettings = $scope.data('tooltip_settings');
				}

				if (!tooltipSettings) {
					return false;
				}

				settings = tooltipSettings;

				if (0 !== Object.keys(settings).length) {
					return settings;
				}
			}

			function generateGlobalTooltip() {

				var content = settings.content,
					triggerClick = null,
					triggerHover = null,
					isSmallDevice = ['tablet', 'tablet_extra', 'mobile', 'mobile_extra'].includes(elementorFrontend.getCurrentDeviceMode()),
					stopTooltip = !elementorFrontend.isEditMode() && 'template' === settings.type && '' !== settings.uniqueClass && !settings.isTourStarter;

				//Always trigger on click on touch devices.
				if (isSmallDevice || settings.trigger === 'click') {
					triggerClick = stopTooltip ? false : true;
					triggerHover = false;

				} else if (settings.trigger === 'hover') {
					triggerClick = false;
					triggerHover = stopTooltip ? false : true;
				} else if ('viewport' === settings.trigger) {
					triggerClick = false;
					triggerHover = false;
				}

				settings.triggerClick = triggerClick;
				settings.triggerHover = triggerHover;

                var $tooltipTarget = '' !== settings.target
                    ? $scope.attr('data-tooltip-content', '#tooltip_content-' + id).find(settings.target)
                    : $scope.attr('data-tooltip-content', '#tooltip_content-' + id);
				// init tooltipster.
				if (elementorFrontend.isEditMode()) {
					closeTooltips($tooltipTarget);
				}

                $tooltipTarget.tooltipster(getTooltipsterSettings(settings));


				// if ('' !== settings.target) {
				// 	$scope.attr('data-tooltip-content', '#tooltip_content-' + id).find(settings.target).tooltipster(getTooltipsterSettings(settings));
				// } else {
				// 	$scope.attr('data-tooltip-content', '#tooltip_content-' + id).tooltipster(getTooltipsterSettings(settings));
				// }

				if (elementorFrontend.isEditMode()) {

					// update options.
					var onViewPort = 'viewport' === settings.trigger;

					// Check if content contains interactive elements.
					var hasInteractiveElements = $('#tooltip_content-' + id).find('a, button').length > 0;

					var newOptions = {
						functionBefore: function () {

							if (settings.hideOn.includes(elementorFrontend.getCurrentDeviceMode())) {
								return false;
							}
						},
						functionReady: function (origin, tooltipObj) {

							$('.tooltipster-box').addClass('tooltipster-box-' + id);
							$('.tooltipster-arrow').addClass('tooltipster-arrow-' + id);

							$('.tooltipster-box').addClass('tooltipster-box-' + settings.elemID);

							var type = settings.type;

							//prevent class overlapping
							var items = $('.tooltipster-box-' + id),
								length = items.length;

							if (items.length > 1) {
								delete items[length - 1];
								items.removeClass('tooltipster-box-' + id);
							}

							// update content.
							if ('template' === settings.type) {

								var templateID = $("#tooltip_content-" + id).data('template-id');

								if (undefined !== templateID && '' !== templateID) {

									$.ajax({
										type: 'GET',
										url: PremiumSettings.ajaxurl,
										data: {
											action: 'get_elementor_template_content',
											templateID: templateID
										}
									}).success(function (response) {
										var data;

										try {
											data = JSON.parse(response).data;
										} catch (error) {
											data = response.data;
										}

										if (undefined !== data.template_content) {

											// Check for interactive elements after content loads.
											hasInteractiveElements = $(data.template_content).find('a, button').length > 0;
											// dynamically updates the interactive option based on content inside the template.
											instance.option('interactive', hasInteractiveElements);

											if ('' !== settings.target) {
												$scope.find(settings.target).tooltipster('content', data.template_content);
											} else {
												$scope.tooltipster('content', data.template_content);
											}
										}
									});
								}
							} else {

								if ('' !== settings.target) {
									$scope.find(settings.target).tooltipster('content', $("#tooltip_content-" + id).detach());
								} else {
									$scope.tooltipster('content', $("#tooltip_content-" + id).detach());
								}
							}

							$scope.find(".premium-global-tooltips-wrapper-temp-" + id).remove();

							// render lottie animation.
							if ('lottie' === type) {

								// check if chrome desktop.
								var isChromeDesktop = ['widescreen', 'desktop', 'laptop'].includes(elementorFrontend.getCurrentDeviceMode()) && ( /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor) );

								if ( isChromeDesktop ) {
									$('.tooltipster-box-' + id).closest('.premium-tooltipster-base').addClass('has-lottie-animation');
								}

								var $tooltipContent = $(tooltipObj.tooltip);

								var lottieInstance = new premiumLottieAnimations($tooltipContent);
								lottieInstance.init();
							}

							$(window).resize();
						},
						animation: settings.anime,
						animationDuration: settings.duration,
						delay: settings.delay,
						trigger: "custom",
						triggerOpen: {
							click: onViewPort ? false : settings.triggerClick,
							tap: onViewPort ? false : true,
							mouseenter: onViewPort ? false : settings.triggerHover
						},
						triggerClose: {
							click: onViewPort ? true : settings.triggerClick,
							tap: onViewPort ? false : true,
							mouseleave: onViewPort ? false : settings.triggerHover
						},
						arrow: settings.arrow,
						minWidth: settings.minWidth[getCurrentDevice()],
						maxWidth: settings.maxWidth[getCurrentDevice()],
						distance: settings.distance,
						interactive: hasInteractiveElements,
						side: 'string' === typeof settings.side ? cleanPosition(settings.side) : settings.side[0], // does this return anything except for a string?
						zindex: settings.zIndex
					};

					// update settings
					Object.keys(newOptions).forEach(function (key) {
						if ('' !== settings.target) {
							$scope.find(settings.target).tooltipster('option', "" + key, newOptions[key]);
						} else {
							$scope.tooltipster('option', "" + key, newOptions[key]);
						}
					});
				}

				// display gallery images randomly.
				if ('gallery' === settings.type && 1 < settings.content.length) {

					var event = ('hover' === settings.trigger) ? 'mouseenter.paRand' + id : 'click.paRand' + id;

					$scope.off(event);
					$scope.on(event, function () {

						var state = '' !== settings.target ? $scope.find(settings.target).tooltipster('status').state : $scope.tooltipster('status').state;

						if ('click' === event) {
							if ('appearing' === state) {
								updateGalleryContent(content);
							}
						} else {
							updateGalleryContent(content);
						}
					});
				}

				// init mouse follower event.
				$scope.off('mousemove.paTooltipsFollower' + id);

				if (settings.follow_mouse) {

					$scope.on('mousemove.paTooltipsFollower' + id, function (e) {

						var element = $('.tooltipster-box-' + id).closest('.premium-tooltipster-base');

						$(element).css({
							"transition": "left 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0s, top 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0s",
							"transform": "translate(-50%,-50%)",
							"cursor": "crosshair"
						});

						MouseFollower(e.pageX, e.pageY, element);
					});
				}
			}

			function getTooltipsterSettings(settings) {
				var onViewPort = 'viewport' === settings.trigger,
					// Check if content contains interactive elements.
					hasInteractiveElements = $('#tooltip_content-' + id).find('a, button').length > 0;

				var tooltipSettings = {

					functionBefore: function () {

						if (settings.hideOn.includes(elementorFrontend.getCurrentDeviceMode())) {
							return false;
						}

						closeTooltips(false);
					},
					functionInit: function (instance, helper) {

						if (!helper) {
							return;
						}

						if (!elementorFrontend.isEditMode()) { // fronend.

							if ('' !== settings.uniqueClass) {
								addTourEvents();
							}

							$("#tooltip_content-" + id).parent().addClass('pa-tooltipstered');

							var content = $("#tooltip_content-" + id).detach();

							instance.content(content);

							$(".pa-tooltipstered.premium-global-tooltips-wrapper-temp-" + id).remove();
						}

						if ('' !== settings.uniqueClass) {
							if ('' !== settings.target) {
								$scope.find(settings.target).attr('pa-tooltip-selector', settings.uniqueClass);

							} else {
								$scope.attr('pa-tooltip-selector', settings.uniqueClass);
							}
						}
					},
					functionReady: function (origin, tooltipObj) {

						$('.tooltipster-box').addClass('tooltipster-box-' + id);
						$('.tooltipster-arrow').addClass('tooltipster-arrow-' + id);

						$('.tooltipster-box').addClass('tooltipster-box-' + settings.elemID);
						var type = settings.type;

						//prevent class overlapping
						var items = $('.tooltipster-box-' + id),
							length = items.length;

						if (items.length > 1) {
							delete items[length - 1];
							items.removeClass('tooltipster-box-' + id);
						}

						// render lottie animation.
						if ('lottie' === type) {

							// check if chrome desktop.
							var isChromeDesktop = ['widescreen', 'desktop', 'laptop'].includes(elementorFrontend.getCurrentDeviceMode()) && ( /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor) );

							if ( isChromeDesktop ) {
								$('.tooltipster-box-' + id).closest('.premium-tooltipster-base').addClass('has-lottie-animation');
							}

							var $tooltipContent = $(tooltipObj.tooltip);

							var lottieInstance = new premiumLottieAnimations($tooltipContent);
							lottieInstance.init();
						}

						$(window).resize();
					},
					contentAsHTML: true,
					contentCloning: true,
					plugins: ['sideTip'],
					animation: settings.anime,
					animationDuration: settings.duration,
					delay: settings.delay,
					trigger: "custom",
					triggerOpen: {
						click: onViewPort ? false : settings.triggerClick,
						tap: onViewPort ? false : true,
						mouseenter: onViewPort ? false : settings.triggerHover
					},
					triggerClose: {
						click: onViewPort ? true : settings.triggerClick,
						tap: onViewPort ? false : true,
						mouseleave: onViewPort ? false : settings.triggerHover
					},
					arrow: settings.arrow,
					autoClose: false,
					minWidth: settings.minWidth[getCurrentDevice()],
					maxWidth: settings.maxWidth[getCurrentDevice()],
					distance: settings.distance,
					interactive: hasInteractiveElements && !settings.follow_mouse,
					minIntersection: 16,
					side: 'string' === typeof settings.side ? cleanPosition(settings.side) : settings.side[0],
					zIndex: settings.zindex || 9999999
				};

				return tooltipSettings;
			}

			function addTourEvents() {

				if ('' !== settings.uniqueClass) {

					var tooltipTriggers = $("div[class*='tooltip-']");

					tooltipTriggers.each(function (index, trigger) {

						var classes = $(trigger).attr('class').split(' ');

						for (var i = 0; i < classes.length; i++) {

							var triggerId = classes[i];

							if ('tooltip-' === triggerId.slice(0, 8)) {
								$(trigger).off('click.paTourTrigger');
								$(trigger).on('click.paTourTrigger', function (e) {
									e.preventDefault();

									closeTooltips(false);

									$('.tooltipstered[pa-tooltip-selector=' + classes[i] + ']').tooltipster('open');
								});

								break;
							}
						}
					});

					$('.premium-tooltipster-closer').on('click.paCloseTour', function() { closeTooltips(false) });
				}
			}

			function MouseFollower(pageX, pageY, element) {
				TweenLite.to(element, 1, {
					css: {
						left: pageX,
						top: pageY,
					},
				});
			}

			function updateGalleryContent(src) {
				var randSrc = getRandomImage(src),
					newContent = '<div id="tooltip_content-' + id + '" class="premium-global-tooltip-content premium-tooltip-content-wrapper-' + id + '"><span class="premium-tooltip-gallery"><img src="' + randSrc + '"></span></div></div>';

				if ('' !== settings.target) {
					$scope.find(settings.target).tooltipster('content', newContent);
				} else {
					$scope.tooltipster('content', newContent);
				}
			}

			function getRandomImage(gallery) {
				var index = Math.floor(Math.random() * gallery.length);
				return gallery[index].url;
			}

			function closeTooltips(target) {
				var instances = $.tooltipster.instances();

                $.each(instances, function (i, instance) {
					if (target) {
						if (instance._$origin.is(target)) {
							instance.close();
						}
					} else {
						if (!instance._$origin.hasClass('premium-image-hotspots-main-icons')) {
							instance.close();
						}
					}
				});
			}

			function getCurrentDevice() {

				var currentDevice = elementorFrontend.getCurrentDeviceMode();

				if (['mobile', 'mobile_extra'].includes(currentDevice)) {
					return 'mobile';
				} else if (['tablet', 'tablet_extra'].includes(currentDevice)) {

				} else {
					return 'desktop';
				}
			}

			/**
			 * Cleans the position string.
			 * separates the array using the ',' and removes empty spaces.
			 *
			 * @param {string} pos
			 * @returns Array
			 */
            function cleanPosition(pos) {
                return pos.split(',').map(function(s) {
                    return s.trim();
                  }).filter(function(s) {
                    return s;
                  });
            }
		};

		elementorFrontend.hooks.addAction("frontend/element_ready/global", premiumGlobalTooltipsHandler);
	});
})(jQuery);