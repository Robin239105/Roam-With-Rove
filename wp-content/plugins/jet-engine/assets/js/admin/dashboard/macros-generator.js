Vue.component( 'jet-engine-macros-generator', {
	name: 'jet-engine-macros-generator',
	template: '#jet-engine-macros-generator',
	data: function() {
		return {
			macrosData: window.JetEngineDashboardConfig.macros_generator,
			contextList: window.JetEngineDashboardConfig.shortode_generator.context_list,
			showCopy: undefined !== navigator.clipboard && undefined !== navigator.clipboard.writeText,
			isBricksMacroVisible: window.JetEngineDashboardConfig.has_bricks,
			isBricksMacroEnabled: false,
			result: {
				macros: '',
				advancedSettings: {
					fallback: '',
					context: '',
				},
			},
			copied: false,
		};
	},
	watch: {
		result: {
			handler: function( newVal ) {
				if ( newVal.macros && ! newVal[ newVal.macros ] ) {
					this.$set( this.result, newVal.macros, {} );
				}
			},
			deep: true,
		},
	},
	computed: {
		macrosList: function() {
			const result = [];

			for ( var i = 0; i < this.macrosData.length; i++ ) {
				result.push( {
					value: this.macrosData[ i ].id,
					label: this.macrosData[ i ].name,
				} );
			}

			return result;
		},
		macrosControls: function() {
			
			const controls = [];

			if ( ! this.result.macros ) {
				return [];
			}

			let foundControls = false;

			for ( var i = 0; i < this.macrosData.length; i++ ) {
				if ( this.macrosData[ i ].id == this.result.macros ) {
					if ( this.macrosData[ i ].controls ) {
						foundControls = this.macrosData[ i ].controls
					}
					break;
				}
			}

			if ( foundControls ) {
				return this.getPreparedControls( foundControls );
			} else {
				return controls;
			}

		},
		generatedMacros: function() {

			if ( ! this.result.macros ) {
				return '--';
			}

			let res = '%';
			
			res += this.result.macros;

			if ( this.result[ this.result.macros ] ) {


				for ( var i = 0; i < this.macrosControls.length; i++ ) {
					res += '|';

					let controlName = this.macrosControls[ i ].name;

					if ( undefined !== this.result[ this.result.macros ][ controlName ] ) {
						res += this.result[ this.result.macros ][ controlName ];
					}
					
				}

			}

			res += '%';

			if ( this.result.advancedSettings && ( this.result.advancedSettings.fallback || this.result.advancedSettings.context ) ) {
				
				let advancedSettings = { ...this.result.advancedSettings };

				if ( '' === advancedSettings.fallback ) {
					delete advancedSettings.fallback;
				}

				res += JSON.stringify( advancedSettings );
			}

			if ( this.isBricksMacroEnabled ) {
				res = this.formatForBricksBuilder( res );
			}

			return res;

		},
	},
	methods: {
		getPreparedControls: function( macrosControls ) {

			const controls = [];

			for ( const controlID in macrosControls ) {

				let control     = macrosControls[ controlID ];
				let optionsList = [];
				let type        = control.type;
				let label       = control.label;
				let defaultVal  = control.default;
				let groupsList  = [];
				let condition   = control.condition || {};

				switch ( control.type ) {

					case 'text':
						type = 'cx-vui-input';
						break;

					case 'textarea':
						type = 'cx-vui-textarea';
						break;

					case 'number':
						type = 'cx-vui-input';
						inputType = 'number';
						break;

					case 'switcher':
						type = 'cx-vui-switcher';
						if ( 'yes' === defaultVal || 'true' === defaultVal ) {
							defaultVal = true;
						} else {
							defaultVal = false;
						}
						break;

					case 'select':

						type = 'cx-vui-select';

						if ( control.groups ) {

							for ( var i = 0; i < control.groups.length; i++) {

								let group = control.groups[ i ];
								let groupOptions = [];

								for ( const optionValue in group.options ) {
									groupOptions.push( {
										value: optionValue,
										label: group.options[ optionValue ],
									} );
								}

								groupsList.push( {
									label: group.label,
									options: groupOptions,
								} );

							}
						} else {
							for ( const optionValue in control.options ) {
								optionsList.push( {
									value: optionValue,
									label: control.options[ optionValue ],
								} );
							}
						}

						break;
				}

				controls.push( {
					type: type,
					name: controlID,
					label: label,
					description: control.description || '',
					default: defaultVal,
					optionsList: optionsList,
					groupsList: groupsList,
					condition: condition,
				} );

			}

			return controls;
		},
		controlKey( control ) {
			return '' + control.name + control.type + control.label;
		},
		checkCondition: function( condition, macros ) {

			let checkResult = true;

			condition = condition || {};

			for ( const [ fieldName, check ] of Object.entries( condition ) ) {

				let value = this.result[ macros ] && this.result[ macros ][ fieldName ] || '';

				if ( check && check.length ) {
					if ( ! check.includes( value ) ) {
						checkResult = false;
					}
				} else {
					if ( check != value ) {
						checkResult = false;
					}
				}
			}

			return checkResult;

		},
		copyToClipboard: function() {
			
			var self = this;

			navigator.clipboard.writeText( this.generatedMacros ).then( function() {
				// clipboard successfully set
				self.copied = true;
				setTimeout( function() {
					self.copied = false;
				}, 2000 );
			}, function() {
				// clipboard write failed
			} );
		},
		formatForBricksBuilder: function( input ) {
			// Map of replacements for characters in the part before the curly braces
			const replacements = {
				'"': "'",
				'{': '~#',
				'}': '#~',
				'[': '&@',
				']': '@&',
				'%2C': ',',
			};

			// Return the result
			return this.applyReplacements(input, replacements);
		},
		applyReplacements: function(text, replacements) {
			// Function to apply character replacements to the prefix part
			let modifiedText = text;
			for (const [original, replacement] of Object.entries(replacements)) {
				modifiedText = modifiedText.replaceAll(original, replacement);
			}
			return modifiedText;
		},
	},
} );
